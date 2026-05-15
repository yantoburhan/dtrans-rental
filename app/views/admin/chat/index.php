<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Admin Live Chat</h1>
            <p class="text-muted mb-0">Respond to customer chat messages in real time.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>Customers</strong>
                </div>
                <div class="list-group list-group-flush" id="threadList">
                    <?php if (empty($threads)): ?>
                        <div class="p-3 text-muted">No active chat threads yet.</div>
                    <?php else: ?>
                        <?php foreach ($threads as $thread): ?>
                            <button type="button" class="list-group-item list-group-item-action thread-item" data-customer-id="<?= htmlspecialchars($thread['id']) ?>">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold"><?= htmlspecialchars($thread['full_name']) ?></div>
                                        <div class="small text-muted"><?= htmlspecialchars($thread['last_message']) ?></div>
                                    </div>
                                    <?php if ((int) $thread['unread_count'] > 0): ?>
                                        <span class="badge bg-danger rounded-pill"><?= (int) $thread['unread_count'] ?></span>
                                    <?php endif; ?>
                                </div>
                            </button>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div id="chatWindow" class="d-none">
                        <div class="mb-3">
                            <h5 id="chatCustomerName"></h5>
                            <p class="text-muted small" id="chatCustomerEmail"></p>
                        </div>
                        <div id="chatMessages" class="border rounded p-3 mb-3" style="min-height: 60vh; max-height: 60vh; overflow-y: auto; background: #f8f9fa;"></div>
                        <form id="adminChatForm" class="d-flex gap-2">
                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                            <input id="adminMessageInput" name="message" type="text" class="form-control" placeholder="Write a message..." autocomplete="off">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>

                    <div id="emptyState" class="text-center text-muted">
                        <p class="mb-0">Select a customer thread to start chatting.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const threads = <?= json_encode($threads) ?>;
    const threadList = $('#threadList');
    const chatWindow = $('#chatWindow');
    const emptyState = $('#emptyState');
    const chatMessages = $('#chatMessages');
    const chatCustomerName = $('#chatCustomerName');
    const chatCustomerEmail = $('#chatCustomerEmail');
    const adminChatForm = $('#adminChatForm');
    const adminMessageInput = $('#adminMessageInput');
    let activeCustomerId = null;

    function createMessageBubble(msg) {
        const alignment = msg.sender === 'admin' ? 'text-end' : 'text-start';
        const badge = msg.sender === 'admin' ? 'bg-primary text-white' : 'bg-white';
        return `
            <div class="mb-3 ${alignment}">
                <div class="d-inline-block p-3 rounded ${badge}" style="max-width: 80%; box-shadow: 0 1px 5px rgba(0,0,0,0.08);">
                    <div>${$('<div>').text(msg.message).html()}</div>
                    <div class="text-muted small mt-2">${msg.created_at}</div>
                </div>
            </div>
        `;
    }

    function loadThread(customerId) {
        activeCustomerId = customerId;
        const thread = threads.find(t => t.id === customerId);
        if (!thread) return;

        chatCustomerName.text(thread.full_name);
        chatCustomerEmail.text(thread.email);
        chatWindow.removeClass('d-none');
        emptyState.hide();
        adminChatForm.show();

        fetchMessages();
    }

    function renderMessages(messages) {
        chatMessages.empty();
        if (!messages.length) {
            chatMessages.append('<div class="text-center text-muted">No messages yet for this thread.</div>');
            return;
        }
        messages.forEach(msg => chatMessages.append(createMessageBubble(msg)));
        chatMessages.scrollTop(chatMessages[0].scrollHeight);
    }

    function fetchMessages() {
        if (!activeCustomerId) return;
        $.get('<?= Env::get('APP_URL') ?>/admin/chat/' + activeCustomerId + '/messages', function(response) {
            if (response.success) {
                renderMessages(response.messages);
            }
        }, 'json');
    }

    threadList.on('click', '.thread-item', function() {
        const customerId = Number($(this).data('customer-id'));
        loadThread(customerId);
    });

    adminChatForm.on('submit', function(event) {
        event.preventDefault();
        const message = adminMessageInput.val().trim();
        if (!message || !activeCustomerId) return;

        $.post('<?= Env::get('APP_URL') ?>/admin/chat/' + activeCustomerId + '/send', {
            _csrf_token: $('input[name="_csrf_token"]').val(),
            message: message
        }, function(response) {
            if (response.success) {
                adminMessageInput.val('');
                fetchMessages();
            } else {
                alert(response.message || 'Failed to send message.');
            }
        }, 'json');
    });
</script>
