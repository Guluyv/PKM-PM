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
    </div>

    <!-- Chat Messages -->
    <div id="messages" class="flex-1 overflow-y-auto p-4 space-y-4">
        <?php if (!empty($data['messages'])): ?>
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
        <?php endif; ?>
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
document.getElementById('chatForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const messageInput = form.querySelector('#messageInput');
    const message = messageInput.value.trim();
    
    if (!message) return;

    // Send message using fetch
    fetch('<?= BASE_URL ?>/api/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(new FormData(form))
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Add message to chat
            const messagesDiv = document.getElementById('messages');
            const messageElement = document.createElement('div');
            messageElement.className = 'flex justify-end';
            messageElement.innerHTML = `
                <div class="bg-blue-600 text-white rounded-lg px-4 py-2 max-w-[70%]">
                    <p>${data.message}</p>
                    <span class="text-xs text-blue-200 mt-1">${data.timestamp}</span>
                </div>
            `;
            messagesDiv.appendChild(messageElement);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
            messageInput.value = '';
        }
    })
    .catch(error => console.error('Error:', error));
});

// Auto scroll to bottom
const messagesDiv = document.getElementById('messages');
messagesDiv.scrollTop = messagesDiv.scrollHeight;
</script>

<?php include __DIR__ . '/../../layouts/student/footer.php'; ?>