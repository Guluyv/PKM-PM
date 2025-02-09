class ChatApp {
    constructor(chatId) {
        this.chatId = chatId;
        this.messageContainer = document.getElementById('messages');
        this.messageInput = document.getElementById('messageInput');
        this.sendButton = document.getElementById('sendButton');
        this.typingIndicator = document.getElementById('typing-indicator');
        this.connectionStatus = document.getElementById('connection-status');
       
        // WebSocket setup
        this.ws = null;
        this.connectWebSocket();
       
        this.initializeEventListeners();
    }


    connectWebSocket() {
        const token = document.querySelector('meta[name="csrf-token"]').content;
        this.ws = new WebSocket(`ws://localhost:8080?token=${token}&chat_id=${this.chatId}`);

        this.ws.onerror = (error) => {
            console.error('WebSocket error:', error);
            this.connectionStatus.innerHTML = '<span class="text-red-600">Connection Error</span>';
        };
       
        this.ws.onopen = () => {
            this.connectionStatus.innerHTML = '<span class="text-green-600">Connected</span>';
            this.loadInitialMessages();
        };


        this.ws.onclose = () => {
            this.connectionStatus.innerHTML = '<span class="text-red-600">Disconnected</span>';
            // Reconnect after 3 seconds
            setTimeout(() => this.connectWebSocket(), 3000);
        };


        this.ws.onmessage = (event) => {
            try {
                const data = JSON.parse(event.data);
                if (data.type === 'message') {
                    this.appendMessage(data);
                } else if (data.type === 'typing') {
                    this.handleTypingIndicator(data);
                }
            } catch (error) {
                console.error('Error parsing message:', error);
            }
        };
    }


    initializeEventListeners() {
        // Existing event listeners
        this.sendButton.addEventListener('click', () => this.sendMessage());
        this.messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });


        // Add typing indicator
        let typingTimeout;
        this.messageInput.addEventListener('input', () => {
            if (this.ws.readyState === WebSocket.OPEN) {
                this.ws.send(JSON.stringify({
                    type: 'typing',
                    chat_id: this.chatId,
                    user_id: window.currentUserId
                }));


                clearTimeout(typingTimeout);
                typingTimeout = setTimeout(() => {
                    this.ws.send(JSON.stringify({
                        type: 'stop_typing',
                        chat_id: this.chatId,
                        user_id: window.currentUserId
                    }));
                }, 1000);
            }
        });
    }


    async sendMessage() {
        const message = this.messageInput.value.trim();
        if (!message) return;


        if (this.ws.readyState === WebSocket.OPEN) {
            // Send via WebSocket
            this.ws.send(JSON.stringify({
                type: 'message',
                chat_id: this.chatId,
                sender_id: window.currentUserId,
                message: message
            }));


            // Clear input
            this.messageInput.value = '';
        }
    }


    async loadInitialMessages() {
        try {
            const response = await fetch(`/ceritayuk/api/chat.php?chat_id=${this.chatId}`);
            const data = await response.json();
            if (data.success) {
                // Clear existing messages
                this.messageContainer.innerHTML = '';
                data.data.forEach(message => this.appendMessage(message));
            }
        } catch (error) {
            console.error('Error loading messages:', error);
        }
    }


    handleTypingIndicator(data) {
        if (data.user_id !== window.currentUserId) {
            this.typingIndicator.classList.remove('hidden');
            setTimeout(() => {
                this.typingIndicator.classList.add('hidden');
            }, 1000);
        }
    }


    // Keep your existing helper methods
    appendMessage(message) {
        // Your existing appendMessage implementation
        const messageElement = document.createElement('div');
        const isSender = message.sender_id === window.currentUserId;
       
        messageElement.className = `flex ${isSender ? 'justify-end' : 'justify-start'} mb-4`;
        messageElement.innerHTML = `
            <div class="${isSender ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'}
                         rounded-lg px-4 py-2 max-w-[70%]">
                <p class="text-sm">${this.escapeHtml(message.message)}</p>
                <span class="text-xs ${isSender ? 'text-blue-200' : 'text-gray-500'} mt-1">
                    ${this.formatTime(message.created_at)}
                </span>
            </div>
        `;


        this.messageContainer.appendChild(messageElement);
        this.scrollToBottom();
    }


    escapeHtml(unsafe) {
        // Your existing escapeHtml implementation
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }


    formatTime(timestamp) {
        // Your existing formatTime implementation
        const date = new Date(timestamp);
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }


    scrollToBottom() {
        // Your existing scrollToBottom implementation
        this.messageContainer.scrollTop = this.messageContainer.scrollHeight;
    }

    async sendMessage() {
        const message = this.messageInput.value.trim();
        if (!message) return;
    
        if (this.ws.readyState === WebSocket.OPEN) {
            try {
                this.ws.send(JSON.stringify({
                    type: 'message',
                    chat_id: this.chatId,
                    sender_id: window.currentUserId,
                    message: message
                }));
                this.messageInput.value = '';
            } catch (error) {
                console.error('Error sending message:', error);
                alert('Gagal mengirim pesan, silakan coba lagi.');
            }
        } else {
            alert('Koneksi terputus, mencoba menghubungkan kembali...');
            this.connectWebSocket();
        }
    }

    
}


// Initialize chat when page loads
document.addEventListener('DOMContentLoaded', () => {
    const chatContainer = document.getElementById('chat-container');
    if (chatContainer) {
        const chatId = chatContainer.dataset.chatId;
        window.chatApp = new ChatApp(chatId);
    }
});

