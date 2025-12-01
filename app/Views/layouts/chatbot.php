<?php
require_once __DIR__ . '/../../../functions.php';
csrf_field();
?>

<div id="chatbot-widget" class="chatbot-widget">
    <button class="chatbot-toggle-btn" id="chatbotToggle">
        💬
    </button>

    <div class="chatbot-window" id="chatbotWindow">
        <div class="chatbot-header">
            <span>Ask Nigey Assistant</span>
            <button id="chatbotClose">&times;</button>
        </div>

        <div class="chatbot-messages" id="chatbotMessages">
            <div class="bot-msg">
                Hi 👋 I'm here to help you explore CodeWithNigey Academy.
                Ask me about logging in, auditor access, courses, or fees.
            </div>
        </div>

        <form id="chatbotForm" class="chatbot-form">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
            <input
                type="text"
                name="message"
                id="chatbotInput"
                placeholder="Type your question..."
                autocomplete="off"
            >
            <button type="submit">Send</button>
        </form>
    </div>
</div>

<script src="/portal/assets/static/js/chatbot.js"></script>
