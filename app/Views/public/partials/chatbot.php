<script src="/public/website/assets/static/js/chatbot.js"></script>

<!-- <div id="chatbot-button">
    💬
</div> -->

<div class="fixed-contact-btn p-3" id="chatbot-button">
    <i class="fas fa-comment-dots"></i>
    <span>Got A Question?<br>I'm Here To Help</span>
</div>

<div id="chatbot-window">
    <div id="chatbot-header">
        <span>Chat Assistant</span>
        <button id="chatbot-close">&times;</button>
    </div>

    <div id="chatbot-messages">
        <div class="bot-msg">
            👋 Hello! How can I help you today?
        </div>

        <div class="quick-replies">
            <button class="reply" data-info="What services do you offer?">Our Services</button>
            <button class="reply" data-info="How do I contact you?">Contact Info</button>
            <button class="reply" data-info="Do you repair gate motors?">Gate Motors</button>
        </div>
    </div>

    <div id="chatbot-input">
        <input type="text" id="chatbot-text" placeholder="Ask me anything...">
        <button id="chatbot-send">Send</button>
    </div>
</div>
