<?php

/**
 * AdminChatController — Admin live chat management
 */
class AdminChatController extends Controller
{
    private ChatMessage $chatModel;

    public function __construct()
    {
        $this->chatModel = new ChatMessage();
    }

    public function index(): void
    {
        $threads = $this->chatModel->getCustomerThreads();

        $this->view('admin.chat.index', [
            'pageTitle' => 'Live Chat',
            'threads'   => $threads,
            'csrf'      => $this->generateCsrf(),
        ], 'admin');
    }

    public function fetch(string $customerId): void
    {
        $customerId = (int) $customerId;
        $messages   = $this->chatModel->getByUser($customerId);
        $this->chatModel->markCustomerMessagesRead($customerId);

        $this->json(['success' => true, 'messages' => $messages]);
    }

    public function send(string $customerId): void
    {
        $this->verifyCsrf();

        $customerId = (int) $customerId;
        $message    = trim($this->input('message', ''));

        if ($message === '') {
            $this->json(['success' => false, 'message' => 'Message cannot be empty.'], 400);
            return;
        }

        $this->chatModel->createMessage($customerId, 'admin', $message);
        $this->json(['success' => true]);
    }
}
