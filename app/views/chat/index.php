<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Live Chat</h1>
            <p class="text-muted mb-0">Chat with support directly from your dashboard.</p>
        </div>
        <a href="<?= Env::get('APP_URL') ?>/customer/dashboard" class="btn btn-light">Back to Dashboard</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div id="chatMessages" class="border rounded p-3 mb-3" style="min-height: 60vh; max-height: 60vh; overflow-y: auto; background: #f8f9fa;"></div>

            <form id="chatForm" class="d-flex gap-2">
                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                <input id="messageInput" name="message" type="text" class="form-control" placeholder="Write a message..." autocomplete="off">
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>
</div>

<script>
    const chatMessages = $('#chatMessages');
    const chatForm = $('#chatForm');
    const messageInput = $('#messageInput');

    function renderMessages(messages) {
        chatMessages.empty();

        if (!messages.length) {
            chatMessages.append('<div class="text-center text-muted">No messages yet. Say hello!</div>');
            return;
        }

        messages.forEach(msg => {
            const align = msg.sender === 'admin' ? 'text-start' : 'text-end';
            const bg = msg.sender === 'admin' ? 'bg-white' : 'bg-primary text-white';
            const bubble = `
                <div class="mb-3 d-flex ${align}">
                    <div class="p-3 rounded ${bg}" style="max-width: 70%; box-shadow: 0 1px 5px rgba(0,0,0,0.08);">
                        <div>${$('<div>').text(msg.message).html()}</div>
                        <div class="text-muted small mt-2">${msg.created_at}</div>
                    </div>
                </div>
            `;
            chatMessages.append(bubble);
        });

        chatMessages.scrollTop(chatMessages[0].scrollHeight);
    }

    function loadMessages() {
        $.get('<?= Env::get('APP_URL') ?>/customer/chat/messages', function(response) {
            if (response.success) {
                renderMessages(response.messages);
            }
        });
    }

    chatForm.on('submit', function(event) {
        event.preventDefault();
        const message = messageInput.val().trim();
        if (!message) return;

        $.post('<?= Env::get('APP_URL') ?>/customer/chat/send', {
            _csrf_token: $('input[name="_csrf_token"]').val(),
            message: message
        }, function(response) {
            if (response.success) {
                messageInput.val('');
                loadMessages();
            } else {
                alert(response.message || 'Failed to send message.');
            }
        }, 'json');
    });

    loadMessages();
    setInterval(loadMessages, 5000);
</script>
