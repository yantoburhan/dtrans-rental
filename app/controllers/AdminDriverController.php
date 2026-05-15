<?php

/**
 * AdminDriverController — Manage drivers in admin panel
 */
class AdminDriverController extends Controller
{
    private Driver $driverModel;

    public function __construct()
    {
        $this->driverModel = new Driver();
    }

    public function index(): void
    {
        $drivers = $this->driverModel->all('id', 'DESC');
        $this->view('admin.drivers.index', compact('drivers'), 'admin');
    }

    public function create(): void
    {
        $this->view('admin.drivers.create', [], 'admin');
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/drivers');
            return;
        }

        if (!$this->validateCsrf($_POST['_csrf_token'] ?? '')) {
            $this->flash('danger', 'Invalid CSRF token.');
            $this->redirect('admin/drivers/create');
            return;
        }

        $data = [
            'full_name'  => trim($_POST['full_name'] ?? ''),
            'phone'      => trim($_POST['phone'] ?? ''),
            'email'      => trim($_POST['email'] ?? ''),
            'experience' => (int) ($_POST['experience'] ?? 0),
            'languages'  => trim($_POST['languages'] ?? ''),
            'age'        => (int) ($_POST['age'] ?? 0),
            'status'     => $_POST['status'] ?? 'available',
        ];

        if (empty($data['full_name']) || empty($data['phone']) || empty($data['email'])) {
            $this->flash('danger', 'Please fill in all required fields.');
            $this->redirect('admin/drivers/create');
            return;
        }

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/drivers/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
            $filePath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $filePath)) {
                $data['photo'] = 'uploads/drivers/' . $fileName;
            }
        }

        try {
            $this->driverModel->insert($data);
            $this->flash('success', 'Driver created successfully.');
        } catch (Exception $e) {
            $this->flash('danger', 'Failed to create driver: ' . $e->getMessage());
        }

        $this->redirect('admin/drivers');
    }

    public function edit(int $id): void
    {
        $driver = $this->driverModel->find($id);
        if (!$driver) {
            $this->flash('danger', 'Driver not found.');
            $this->redirect('admin/drivers');
            return;
        }

        $this->view('admin.drivers.edit', compact('driver'), 'admin');
    }

    public function update(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/drivers');
            return;
        }

        if (!$this->validateCsrf($_POST['_csrf_token'] ?? '')) {
            $this->flash('danger', 'Invalid CSRF token.');
            $this->redirect("admin/drivers/{$id}/edit");
            return;
        }

        $driver = $this->driverModel->find($id);
        if (!$driver) {
            $this->flash('danger', 'Driver not found.');
            $this->redirect('admin/drivers');
            return;
        }

        $data = [
            'full_name'  => trim($_POST['full_name'] ?? ''),
            'phone'      => trim($_POST['phone'] ?? ''),
            'email'      => trim($_POST['email'] ?? ''),
            'experience' => (int) ($_POST['experience'] ?? 0),
            'languages'  => trim($_POST['languages'] ?? ''),
            'age'        => (int) ($_POST['age'] ?? 0),
            'status'     => $_POST['status'] ?? 'available',
        ];

        if (empty($data['full_name']) || empty($data['phone']) || empty($data['email'])) {
            $this->flash('danger', 'Please fill in all required fields.');
            $this->redirect("admin/drivers/{$id}/edit");
            return;
        }

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/drivers/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            if (!empty($driver['photo']) && file_exists(__DIR__ . '/../../public/' . $driver['photo'])) {
                unlink(__DIR__ . '/../../public/' . $driver['photo']);
            }
            $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
            $filePath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $filePath)) {
                $data['photo'] = 'uploads/drivers/' . $fileName;
            }
        }

        try {
            $this->driverModel->update($id, $data);
            $this->flash('success', 'Driver updated successfully.');
        } catch (Exception $e) {
            $this->flash('danger', 'Failed to update driver: ' . $e->getMessage());
        }

        $this->redirect('admin/drivers');
    }

    public function delete(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/drivers');
            return;
        }

        if (!$this->validateCsrf($_POST['_csrf_token'] ?? '')) {
            $this->flash('danger', 'Invalid CSRF token.');
            $this->redirect('admin/drivers');
            return;
        }

        $driver = $this->driverModel->find($id);
        if (!$driver) {
            $this->flash('danger', 'Driver not found.');
            $this->redirect('admin/drivers');
            return;
        }

        if (!empty($driver['photo']) && file_exists(__DIR__ . '/../../public/' . $driver['photo'])) {
            unlink(__DIR__ . '/../../public/' . $driver['photo']);
        }

        try {
            $this->driverModel->delete($id);
            $this->flash('success', 'Driver deleted successfully.');
        } catch (Exception $e) {
            $this->flash('danger', 'Failed to delete driver: ' . $e->getMessage());
        }

        $this->redirect('admin/drivers');
    }
}
