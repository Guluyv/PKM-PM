class ChatApp {
    constructor(chatId) {
        this.chatId = chatId;
        this.messageContainer = document.getElementById('messages');
        this.messageInput = document.getElementById('messageInput');
        this.sendButton = document.getElementById('sendButton');
        this.lastMessageTime = null;

        this.initializeEventListeners();
        this.startPolling();
    }

    initializeEventListeners() {
        // Send message on button click
        this.sendButton.addEventListener('click', () => this.sendMessage());

        // Send message on Enter key
        this.messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });
    }

    async sendMessage() {
        const message = this.messageInput.value.trim();
        if (!message) return;

        try {
            const response = await fetch('/ceritayuk/api/chat.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'send',
                    chat_id: this.chatId,
                    message: message
                })
            });

            const data = await response.json();
            if (data.success) {
                this.messageInput.value = '';
                this.appendMessage(data.data);
            }
        } catch (error) {
            console.error('Error sending message:', error);
        }
    }

    appendMessage(message) {
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

    async getNewMessages() {
        try {
            const url = `/ceritayuk/api/chat.php?chat_id=${this.chatId}`;
            const response = await fetch(url);
            const data = await response.json();

            if (data.success) {
                this.updateMessages(data.data);
            }
        } catch (error) {
            console.error('Error fetching messages:', error);
        }
    }

    updateMessages(messages) {
        messages.forEach(message => {
            if (!this.lastMessageTime || new Date(message.created_at) > new Date(this.lastMessageTime)) {
                this.appendMessage(message);
                this.lastMessageTime = message.created_at;
            }
        });
    }

    startPolling() {
        // Poll for new messages every 3 seconds
        setInterval(() => this.getNewMessages(), 3000);
    }

    scrollToBottom() {
        this.messageContainer.scrollTop = this.messageContainer.scrollHeight;
    }

    escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    formatTime(timestamp) {
        const date = new Date(timestamp);
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
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