<?php

/**
 * AdminTourismController — Manage tourism destinations in admin panel
 */
class AdminTourismController extends Controller
{
    private TourismDestination $tourismModel;

    public function __construct()
    {
        $this->tourismModel = new TourismDestination();
    }

    public function index(): void
    {
        $destinations = $this->tourismModel->all('created_at', 'DESC');
        $this->view('admin.tourism.index', compact('destinations'), 'admin');
    }

    public function create(): void
    {
        $this->view('admin.tourism.create', [], 'admin');
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/tourism');
            return;
        }

        if (!$this->validateCsrf($_POST['_csrf_token'] ?? '')) {
            $this->flash('danger', 'Invalid CSRF token.');
            $this->redirect('admin/tourism/create');
            return;
        }

        $data = [
            'name'                => trim($_POST['name'] ?? ''),
            'description'         => trim($_POST['description'] ?? ''),
            'location'            => trim($_POST['location'] ?? ''),
            'maps_embed_url'      => trim($_POST['maps_embed_url'] ?? ''),
            'ticket_price'        => (float) ($_POST['ticket_price'] ?? 0),
            'recommended_vehicle' => trim($_POST['recommended_vehicle'] ?? ''),
        ];

        if (empty($data['name']) || empty($data['location'])) {
            $this->flash('danger', 'Name and location are required.');
            $this->redirect('admin/tourism/create');
            return;
        }

        try {
            $this->tourismModel->insert($data);
            $this->flash('success', 'Tourism destination created successfully.');
        } catch (Exception $e) {
            $this->flash('danger', 'Failed to create destination: ' . $e->getMessage());
        }

        $this->redirect('admin/tourism');
    }

    public function edit(int $id): void
    {
        $destination = $this->tourismModel->find($id);
        if (!$destination) {
            $this->flash('danger', 'Destination not found.');
            $this->redirect('admin/tourism');
            return;
        }

        $this->view('admin.tourism.edit', compact('destination'), 'admin');
    }

    public function update(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/tourism');
            return;
        }

        if (!$this->validateCsrf($_POST['_csrf_token'] ?? '')) {
            $this->flash('danger', 'Invalid CSRF token.');
            $this->redirect("admin/tourism/{$id}/edit");
            return;
        }

        $destination = $this->tourismModel->find($id);
        if (!$destination) {
            $this->flash('danger', 'Destination not found.');
            $this->redirect('admin/tourism');
            return;
        }

        $data = [
            'name'                => trim($_POST['name'] ?? ''),
            'description'         => trim($_POST['description'] ?? ''),
            'location'            => trim($_POST['location'] ?? ''),
            'maps_embed_url'      => trim($_POST['maps_embed_url'] ?? ''),
            'ticket_price'        => (float) ($_POST['ticket_price'] ?? 0),
            'recommended_vehicle' => trim($_POST['recommended_vehicle'] ?? ''),
        ];

        if (empty($data['name']) || empty($data['location'])) {
            $this->flash('danger', 'Name and location are required.');
            $this->redirect("admin/tourism/{$id}/edit");
            return;
        }

        try {
            $this->tourismModel->update($id, $data);
            $this->flash('success', 'Tourism destination updated successfully.');
        } catch (Exception $e) {
            $this->flash('danger', 'Failed to update destination: ' . $e->getMessage());
        }

        $this->redirect('admin/tourism');
    }

    public function delete(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/tourism');
            return;
        }

        if (!$this->validateCsrf($_POST['_csrf_token'] ?? '')) {
            $this->flash('danger', 'Invalid CSRF token.');
            $this->redirect('admin/tourism');
            return;
        }

        $destination = $this->tourismModel->find($id);
        if (!$destination) {
            $this->flash('danger', 'Destination not found.');
            $this->redirect('admin/tourism');
            return;
        }

        try {
            $this->tourismModel->delete($id);
            $this->flash('success', 'Tourism destination deleted successfully.');
        } catch (Exception $e) {
            $this->flash('danger', 'Failed to delete destination: ' . $e->getMessage());
        }

        $this->redirect('admin/tourism');
    }
}
