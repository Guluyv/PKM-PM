<?php include __DIR__ . '/../../layouts/student/header.php'; ?>

<div class="flex flex-col h-screen">
    <!-- Chat Header -->
    <div class="bg-white shadow-sm px-4 py-3 flex items-center">
        <a href="<?= BASE_URL ?>/student/chat" class="mr-3">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h1 class="font-medium text-gray-800">Chat Konseling</h1>
            <p class="text-xs text-gray-500">Konselor akan merahasiakan identitas Anda</p>
        </div>
        <div id="connection-status" class="ml-auto text-xs">
            <span class="text-yellow-600">Connecting...</span>
        </div>
    </div>

    <!-- Chat Messages -->
    <div id="messages" class="flex-1 overflow-y-auto p-4 space-y-4">
        <?php foreach ($data['messages'] as $message): ?>
            <?php $isSender = $message['sender_id'] == $_SESSION['user_id']; ?>
            <div class="flex <?= $isSender ? 'justify-end' : 'justify-start' ?>">
                <div class="<?= $isSender ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' ?> rounded-lg px-4 py-2 max-w-[70%]">
                    <p><?= htmlspecialchars($message['message']) ?></p>
                    <span class="text-xs <?= $isSender ? 'text-blue-200' : 'text-gray-500' ?> mt-1">
                        <?= date('H:i', strtotime($message['created_at'])) ?>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    
    <!-- Typing Indicator -->
    <div id="typing-indicator" class="px-4 py-2 text-sm text-gray-500 hidden">
        <span class="animate-pulse">Konselor sedang mengetik...</span>
    </div>

    <!-- Chat Input -->
    <div class="bg-white border-t p-4">
        <form id="chatForm" class="flex items-center space-x-2">
            <input type="hidden" name="chat_id" value="<?= $data['chat']['id'] ?>">
            <input type="text" 
                   id="messageInput"
                   name="message"
                   class="flex-1 border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:border-blue-500"
                   placeholder="Ketik pesan...">
            <button type="submit" 
                    class="bg-blue-600 text-white rounded-full p-2 w-10 h-10 flex items-center justify-center hover:bg-blue-700">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<!-- Chat JavaScript -->
<script>
let ws;
const chatId = <?= $data['chat']['id'] ?>;
const userId = <?= $_SESSION['user_id'] ?>;
const messagesDiv = document.getElementById('messages');
const connectionStatus = document.getElementById('connection-status');

function connectWebSocket() {
    ws = new WebSocket('ws://localhost:8080');

    ws.onopen = function() {
        connectionStatus.innerHTML = '<span class="text-green-600">Connected</span>';
        // Join chat room
        ws.send(JSON.stringify({
            type: 'join',
            chat_id: chatId,
            user_id: userId
        }));
    };

    ws.onclose = function() {
        connectionStatus.innerHTML = '<span class="text-red-600">Disconnected</span>';
        // Try to reconnect after 3 seconds
        setTimeout(connectWebSocket, 3000);
    };

    ws.onmessage = function(e) {
        const data = JSON.parse(e.data);
        
        if (data.type === 'message') {
            addMessage(data);
        } else if (data.type === 'typing') {
            handleTyping(data);
        }
    };
}

function addMessage(data) {
    const isSender = data.sender_id === userId;
    const messageElement = document.createElement('div');
    messageElement.className = `flex ${isSender ? 'justify-end' : 'justify-start'}`;
    messageElement.innerHTML = `
        <div class="${isSender ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'} rounded-lg px-4 py-2 max-w-[70%]">
            <p>${escapeHtml(data.message)}</p>
            <span class="text-xs ${isSender ? 'text-blue-200' : 'text-gray-500'} mt-1">
                ${formatTime(data.timestamp)}
            </span>
        </div>
    `;
    messagesDiv.appendChild(messageElement);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

function handleTyping(data) {
    const typingIndicator = document.getElementById('typing-indicator');
    if (data.user_id !== userId) {
        typingIndicator.classList.remove('hidden');
        clearTimeout(typingTimeout);
        typingTimeout = setTimeout(() => {
            typingIndicator.classList.add('hidden');
        }, 1000);
    }
}

// Connect when page loads
connectWebSocket();

// Handle form submission
document.getElementById('chatForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const messageInput = this.querySelector('#messageInput');
    const message = messageInput.value.trim();
    
    if (!message) return;

    // Send via WebSocket
    ws.send(JSON.stringify({
        type: 'message',
        chat_id: chatId,
        sender_id: userId,
        message: message
    }));

    // Also save to database
    fetch('<?= BASE_URL ?>/api/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(new FormData(this))
    });

    messageInput.value = '';
});

// Helper functions
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatTime(timestamp) {
    const date = new Date(timestamp);
    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

// Handle typing indicator
let typingTimeout;
const messageInput = document.getElementById('messageInput');
messageInput.addEventListener('input', function() {
    ws.send(JSON.stringify({
        type: 'typing',
        chat_id: chatId,
        user_id: userId
    }));
});
</script>

<?php
 $csrfToken = CSRF::generateToken();

 ?>
 <script>
    // Tambahkan meta tag untuk CSRF token
    document.head.innerHTML += `<meta name="csrf-token" content="<?= $csrfToken ?>">`;
</script>
<?php include __DIR__ . '/../../layouts/student/footer.php'; ?>