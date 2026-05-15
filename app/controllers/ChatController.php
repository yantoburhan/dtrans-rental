<?php

/**
 * ChatController — Customer live chat
 */
class ChatController extends Controller
{
    private ChatMessage $chatModel;

    public function __construct()
    {
        $this->chatModel = new ChatMessage();
    }

    public function index(): void
    {
        $this->view('chat.index', [
            'pageTitle' => 'Live Chat',
            'csrf'      => $this->generateCsrf(),
        ]);
    }

    public function fetch(): void
    {
        $user     = Session::get('user');
        $messages = $this->chatModel->getByUser((int) $user['id']);

        $this->json(['success' => true, 'messages' => $messages]);
    }

    public function send(): void
    {
        $this->verifyCsrf();

        $user    = Session::get('user');
        $message = trim($this->input('message', ''));

        if ($message === '') {
            $this->json(['success' => false, 'message' => 'Message cannot be empty.'], 400);
            return;
        }

        $this->chatModel->createMessage((int) $user['id'], 'customer', $message);
        $this->json(['success' => true]);
    }
}
