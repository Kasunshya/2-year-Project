<div class="chat-icon" id="chatIcon">
    <i class="fas fa-comments"></i>
</div>

<div class="chat-widget" id="chatWidget" style="display: none;">
    <div class="chat-header">
        <h3>Frostine Bakery Chat</h3>
        <span class="close-chat" id="closeChat">&times;</span>
    </div>
    
    <div class="chat-messages" id="chatMessages">
        <div class="bot-message">Hello! How can I help you today?</div>
    </div>
    
    <div class="chat-input">
        <input type="text" id="userInput" placeholder="Type your message...">
        <button onclick="sendMessage()">Send</button>
    </div>
</div>

<style>
.chat-icon {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    background: #c98d83;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    z-index: 1000;
}

.chat-icon i {
    color: white;
    font-size: 24px;
}

.close-chat {
    position: absolute;
    right: 10px;
    top: 10px;
    color: white;
    cursor: pointer;
    font-size: 20px;
}

.chat-widget {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 300px;
    height: 400px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    z-index: 1000;
    display: none;
}

.chat-header {
    padding: 10px;
    background: #c98d83;
    color: white;
    border-radius: 10px 10px 0 0;
}

.chat-messages {
    height: 300px;
    overflow-y: auto;
    padding: 10px;
}

.chat-input {
    padding: 10px;
    border-top: 1px solid #ccc;
}

.bot-message, .user-message {
    margin: 5px;
    padding: 8px;
    border-radius: 10px;
    max-width: 80%;
}

.bot-message {
    background: #f1f1f1;
    margin-right: auto;
}

.user-message {
    background: #c98d83;
    color: white;
    margin-left: auto;
}

#userInput {
    width: 75%;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    width: 20%;
    padding: 5px;
    background: #783b31;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.bot-message a {
    color: #783b31;
    text-decoration: underline;
}

.bot-message a:hover {
    color: #c98d83;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatIcon = document.getElementById('chatIcon');
    const chatWidget = document.getElementById('chatWidget');
    const closeChat = document.getElementById('closeChat');

    chatIcon.addEventListener('click', function() {
        chatWidget.style.display = 'block';
        chatIcon.style.display = 'none';
    });

    closeChat.addEventListener('click', function() {
        chatWidget.style.display = 'none';
        chatIcon.style.display = 'flex';
    });
});

function sendMessage() {
    const input = document.getElementById('userInput');
    const message = input.value.trim().toLowerCase();
    
    if (message === '') return;

    // Add user message to chat
    addMessage(message, 'user');
    input.value = '';

    // Handle specific queries
    const responses = {
        'hello': 'Hi! How can I help you today?',
        'hi': 'Hello! Welcome to Frostine Bakery!',
        'category': 'You can explore all our categories at our website. Click here: <a href="<?php echo URLROOT; ?>/customer/customerproducts">View Categories</a>',
        'product': 'Check out our amazing products here: <a href="<?php echo URLROOT; ?>/customer/customerproducts">View Products</a>',
        'custom': 'Want a custom cake? Visit our customization page: <a href="<?php echo URLROOT; ?>/customer/customercustomisation">Cake Customization</a>',
        'register': 'Create your account here: <a href="<?php echo URLROOT; ?>/users/register">Register</a>',
        'account': 'Create your account here: <a href="<?php echo URLROOT; ?>/users/register">Register</a>',
        'price': 'Our prices vary by product. Please check our Products page for details',
        'order': 'You can place an order through our website after logging in',
        'delivery': 'Yes, we offer delivery services!',
        'enquiry': 'Have questions? Submit your enquiry here: <a href="<?php echo URLROOT; ?>/customer/enquiry">Enquiry Form</a>'
    };

    let botResponse = null;

    // Check for keywords in the message
    if (message.includes('category') || message.includes('categories')) {
        botResponse = responses.category;
    } else if (message.includes('product') || message.includes('items')) {
        botResponse = responses.product;
    } else if (message.includes('custom') || message.includes('customization')) {
        botResponse = responses.custom;
    } else if (message.includes('register') || message.includes('account')) {
        botResponse = responses.register;
    } else if (message.includes('enquiry') || message.includes('question') || message.includes('ask')) {
        botResponse = responses.enquiry;
    }

    if (botResponse) {
        const chatMessages = document.getElementById('chatMessages');
        const messageDiv = document.createElement('div');
        messageDiv.className = 'bot-message';
        messageDiv.innerHTML = botResponse;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    } else {
        // If no specific match, send to server for general response
        fetch('<?php echo URLROOT; ?>/chat/sendMessage', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'message=' + encodeURIComponent(message)
        })
        .then(response => response.json())
        .then(data => {
            addMessage(data.response, 'bot');
        });
    }
}

function addMessage(message, sender) {
    const chatMessages = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = sender + '-message';
    if (sender === 'user') {
        messageDiv.textContent = message;
    } else {
        messageDiv.innerHTML = message;
    }
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Allow Enter key to send message
document.getElementById('userInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});
</script>