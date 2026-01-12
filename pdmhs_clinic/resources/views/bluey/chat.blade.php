<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bluey - Your Health Buddy 💙</title>
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1877f2 0%, #42a5f5 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .chat-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 800px;
            width: 100%;
            height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-header {
            background: linear-gradient(135deg, #1877f2 0%, #42a5f5 100%);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 20px 20px 0 0;
            position: relative;
        }

        .bluey-avatar {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            padding: 5px;
            overflow: visible;
        }

        .bluey-avatar svg {
            width: 130%;
            height: 130%;
        }

        .chat-header h1 {
            font-family: 'Albert Sans', sans-serif;
            font-size: 25px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .chat-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .health-tip {
            background: rgba(255,255,255,0.2);
            padding: 10px;
            border-radius: 10px;
            margin-top: 10px;
            font-size: 13px;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #f5f7fa;
        }

        .message {
            margin-bottom: 15px;
            display: flex;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.user {
            justify-content: flex-end;
        }

        .message-content {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 15px;
            word-wrap: break-word;
            font-family: 'Albert Sans', sans-serif;
            font-weight: 700;
            font-size: 20px;
        }

        .message.bluey .message-content {
            background: white;
            color: #333;
            border: 2px solid #1877f2;
            border-radius: 15px 15px 15px 0;
        }

        .message.user .message-content {
            background: #1877f2;
            color: white;
            border-radius: 15px 15px 0 15px;
        }

        .message-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            background: white;
            border: 2px solid #1877f2;
            flex-shrink: 0;
            padding: 2px;
        }

        .message-avatar svg {
            width: 120%;
            height: 120%;
        }

        .chat-input-container {
            padding: 20px;
            background: white;
            border-top: 1px solid #e0e0e0;
        }

        .chat-input-wrapper {
            display: flex;
            gap: 10px;
        }

        .chat-input {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }

        .chat-input:focus {
            border-color: #1877f2;
        }

        .send-btn {
            background: #1877f2;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            cursor: pointer;
            font-family: 'Albert Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            transition: background 0.3s;
        }

        .send-btn:hover {
            background: #42a5f5;
        }

        .send-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .typing-indicator {
            display: none;
            padding: 10px;
            color: #666;
            font-style: italic;
            font-size: 13px;
        }

        .typing-indicator.active {
            display: block;
        }

        .related-topics {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #e0e0e0;
        }

        .related-topics h5 {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        .related-link {
            display: inline-block;
            color: #1877f2;
            font-size: 12px;
            margin-right: 10px;
            cursor: pointer;
            text-decoration: underline;
        }

        .related-link:hover {
            color: #42a5f5;
        }

        /* Scrollbar styling */
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #1877f2;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <div class="bluey-avatar">
                <svg viewBox="0 0 200 120" xmlns="http://www.w3.org/2000/svg">
                    <!-- Nurse Hat -->
                    <path d="M85 15 L115 15 L120 5 L80 5 Z" fill="#ffffff" stroke="#1e40af" stroke-width="2"/>
                    <!-- Medical Cross -->
                    <circle cx="100" cy="10" r="3" fill="#dc2626"/>
                    <rect x="95" y="5" width="10" height="2" fill="#dc2626"/>
                    <!-- Cat Ears -->
                    <path d="M70,40 Q75,20 80,25 Q85,20 90,40 Z" fill="#60a5fa"/>
                    <path d="M110,40 Q115,20 120,25 Q125,20 130,40 Z" fill="#60a5fa"/>
                    <path d="M75,35 Q78,25 80,28 Q82,25 85,35 Z" fill="#ffffff"/>
                    <path d="M115,35 Q118,25 120,28 Q122,25 125,35 Z" fill="#ffffff"/>
                    <!-- Cat Face -->
                    <ellipse cx="100" cy="65" rx="35" ry="30" fill="#60a5fa"/>
                    <!-- Eyes -->
                    <circle cx="88" cy="58" r="4" fill="#ffffff"/>
                    <circle cx="112" cy="58" r="4" fill="#ffffff"/>
                    <circle cx="89" cy="57" r="2" fill="#000000"/>
                    <circle cx="113" cy="57" r="2" fill="#000000"/>
                    <!-- Nose -->
                    <polygon points="98,68 102,68 100,72" fill="#ff6b6b"/>
                    <!-- Mouth -->
                    <path d="M95 75 Q100 80 105 75" stroke="#000000" stroke-width="1.5" fill="none"/>
                    <line x1="95" y1="75" x2="92" y2="72" stroke="#000000" stroke-width="1.5"/>
                    <line x1="105" y1="75" x2="108" y2="72" stroke="#000000" stroke-width="1.5"/>
                    <!-- Whiskers -->
                    <line x1="65" y1="65" x2="75" y2="68" stroke="#ffffff" stroke-width="2"/>
                    <line x1="65" y1="70" x2="75" y2="70" stroke="#ffffff" stroke-width="2"/>
                    <line x1="125" y1="68" x2="135" y2="65" stroke="#ffffff" stroke-width="2"/>
                    <line x1="125" y1="70" x2="135" y2="70" stroke="#ffffff" stroke-width="2"/>
                </svg>
            </div>
            <h1>Bluey - Your Health Buddy!</h1>
        </div>

        <div class="chat-messages" id="chatMessages">
            <div class="message bluey">
                <div class="message-avatar">
                    <svg viewBox="0 0 200 120" xmlns="http://www.w3.org/2000/svg">
                        <!-- Nurse Hat -->
                        <path d="M85 15 L115 15 L120 5 L80 5 Z" fill="#ffffff" stroke="#1e40af" stroke-width="2"/>
                        <!-- Medical Cross -->
                        <circle cx="100" cy="10" r="3" fill="#dc2626"/>
                        <rect x="95" y="5" width="10" height="2" fill="#dc2626"/>
                        <!-- Cat Ears -->
                        <path d="M70,40 Q75,20 80,25 Q85,20 90,40 Z" fill="#60a5fa"/>
                        <path d="M110,40 Q115,20 120,25 Q125,20 130,40 Z" fill="#60a5fa"/>
                        <path d="M75,35 Q78,25 80,28 Q82,25 85,35 Z" fill="#ffffff"/>
                        <path d="M115,35 Q118,25 120,28 Q122,25 125,35 Z" fill="#ffffff"/>
                        <!-- Cat Face -->
                        <ellipse cx="100" cy="65" rx="35" ry="30" fill="#60a5fa"/>
                        <!-- Eyes -->
                        <circle cx="88" cy="58" r="4" fill="#ffffff"/>
                        <circle cx="112" cy="58" r="4" fill="#ffffff"/>
                        <circle cx="89" cy="57" r="2" fill="#000000"/>
                        <circle cx="113" cy="57" r="2" fill="#000000"/>
                        <!-- Nose -->
                        <polygon points="98,68 102,68 100,72" fill="#ff6b6b"/>
                        <!-- Mouth -->
                        <path d="M95 75 Q100 80 105 75" stroke="#000000" stroke-width="1.5" fill="none"/>
                        <line x1="95" y1="75" x2="92" y2="72" stroke="#000000" stroke-width="1.5"/>
                        <line x1="105" y1="75" x2="108" y2="72" stroke="#000000" stroke-width="1.5"/>
                        <!-- Whiskers -->
                        <line x1="65" y1="65" x2="75" y2="68" stroke="#ffffff" stroke-width="2"/>
                        <line x1="65" y1="70" x2="75" y2="70" stroke="#ffffff" stroke-width="2"/>
                        <line x1="125" y1="68" x2="135" y2="65" stroke="#ffffff" stroke-width="2"/>
                        <line x1="125" y1="70" x2="135" y2="70" stroke="#ffffff" stroke-width="2"/>
                    </svg>
                </div>
<div class="message-content">
                    Hi there! I'm Bluey, your friendly health buddy! 🩺<br><br>
                    I'm here to help you with:<br>
                    • Health questions & first aid tips<br>
                    • Nutrition & healthy eating advice<br>
                    • Mental health & stress management<br>
                    • Daily wellness tips<br><br>
                    What would you like to know today?
                </div>
            </div>
        </div>

        <div class="typing-indicator" id="typingIndicator">
            Bluey is thinking... 💭
        </div>

        <div class="chat-input-container">
            <div class="chat-input-wrapper">
                <input 
                    type="text" 
                    class="chat-input" 
                    id="chatInput" 
                    placeholder="Ask me about health, first aid, or medical terms..."
                    onkeypress="handleKeyPress(event)"
                >
                <button class="send-btn" onclick="sendMessage()" id="sendBtn">Send</button>
            </div>
        </div>
    </div>

    <script>
        const chatMessages = document.getElementById('chatMessages');
        const chatInput = document.getElementById('chatInput');
        const sendBtn = document.getElementById('sendBtn');
        const typingIndicator = document.getElementById('typingIndicator');

        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }

        function askQuestion(question) {
            chatInput.value = question;
            sendMessage();
        }

        async function sendMessage() {
            const question = chatInput.value.trim();
            
            if (!question) return;

            // Disable input
            chatInput.disabled = true;
            sendBtn.disabled = true;

            // Add user message
            addMessage(question, 'user');
            chatInput.value = '';

            // Show typing indicator
            typingIndicator.classList.add('active');

            try {
                const response = await fetch('/bluey/ask', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ question })
                });

                const data = await response.json();

                if (data.success) {
                    // Hide typing indicator
                    typingIndicator.classList.remove('active');
                    
                    // Add Bluey's response
                    addMessage(data.data.answer, 'bluey', data.data.related_topics);
                }
            } catch (error) {
                console.error('Error:', error);
                typingIndicator.classList.remove('active');
                addMessage('Oops! Something went wrong. Please try again! 😅', 'bluey');
            }

            // Re-enable input
            chatInput.disabled = false;
            sendBtn.disabled = false;
            chatInput.focus();
        }

        function addMessage(text, sender, relatedTopics = []) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}`;

            if (sender === 'bluey') {
                messageDiv.innerHTML = `
                    <div class="message-avatar">
                        <svg viewBox="0 0 200 120" xmlns="http://www.w3.org/2000/svg">
                            <path d="M85 15 L115 15 L120 5 L80 5 Z" fill="#ffffff" stroke="#1e40af" stroke-width="2"/>
                            <circle cx="100" cy="10" r="3" fill="#dc2626"/>
                            <rect x="95" y="5" width="10" height="2" fill="#dc2626"/>
                            <path d="M70,40 Q75,20 80,25 Q85,20 90,40 Z" fill="#60a5fa"/>
                            <path d="M110,40 Q115,20 120,25 Q125,20 130,40 Z" fill="#60a5fa"/>
                            <path d="M75,35 Q78,25 80,28 Q82,25 85,35 Z" fill="#ffffff"/>
                            <path d="M115,35 Q118,25 120,28 Q122,25 125,35 Z" fill="#ffffff"/>
                            <ellipse cx="100" cy="65" rx="35" ry="30" fill="#60a5fa"/>
                            <circle cx="88" cy="58" r="4" fill="#ffffff"/>
                            <circle cx="112" cy="58" r="4" fill="#ffffff"/>
                            <circle cx="89" cy="57" r="2" fill="#000000"/>
                            <circle cx="113" cy="57" r="2" fill="#000000"/>
                            <polygon points="98,68 102,68 100,72" fill="#ff6b6b"/>
                            <path d="M95 75 Q100 80 105 75" stroke="#000000" stroke-width="1.5" fill="none"/>
                            <line x1="95" y1="75" x2="92" y2="72" stroke="#000000" stroke-width="1.5"/>
                            <line x1="105" y1="75" x2="108" y2="72" stroke="#000000" stroke-width="1.5"/>
                            <line x1="65" y1="65" x2="75" y2="68" stroke="#ffffff" stroke-width="2"/>
                            <line x1="65" y1="70" x2="75" y2="70" stroke="#ffffff" stroke-width="2"/>
                            <line x1="125" y1="68" x2="135" y2="65" stroke="#ffffff" stroke-width="2"/>
                            <line x1="125" y1="70" x2="135" y2="70" stroke="#ffffff" stroke-width="2"/>
                        </svg>
                    </div>
                    <div class="message-content">
                        ${formatMessage(text)}
                        ${relatedTopics.length > 0 ? `
                            <div class="related-topics">
                                <h5>Related topics:</h5>
                                ${relatedTopics.map(topic => 
                                    `<span class="related-link" onclick="askQuestion('${topic}')">${topic}</span>`
                                ).join('')}
                            </div>
                        ` : ''}
                    </div>
                `;
            } else {
                messageDiv.innerHTML = `
                    <div class="message-content">${text}</div>
                `;
            }

            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function formatMessage(text) {
            // Convert markdown-style formatting to HTML
            return text
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\n/g, '<br>');
        }

        // Focus input on load
        window.onload = () => {
            chatInput.focus();
        };
    </script>
</body>
</html>
