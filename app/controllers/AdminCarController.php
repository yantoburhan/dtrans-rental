<?php

/**
 * AdminCarController — Manage cars in admin panel
 */
class AdminCarController extends Controller
{
    private Car $carModel;

    public function __construct()
    {
        $this->carModel = new Car();
    }

    public function index(): void
    {
        $cars = $this->carModel->getAll();
        $this->view('admin.cars.index', compact('cars'), 'admin');
    }

    public function create(): void
    {
        $this->view('admin.cars.create', [], 'admin');
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/cars');
            return;
        }

        // Validate CSRF
        if (!$this->validateCsrf($_POST['_csrf_token'] ?? '')) {
            $this->flash('danger', 'Invalid CSRF token.');
            $this->redirect('admin/cars');
            return;
        }

        // Get form data
        $data = [
            'brand' => trim($_POST['brand'] ?? ''),
            'model' => trim($_POST['model'] ?? ''),
            'year' => (int) ($_POST['year'] ?? 0),
            'plate_number' => trim($_POST['plate_number'] ?? ''),
            'transmission' => $_POST['transmission'] ?? '',
            'capacity' => (int) ($_POST['capacity'] ?? 0),
            'category' => $_POST['category'] ?? '',
            'daily_price' => (float) ($_POST['daily_price'] ?? 0),
            'description' => trim($_POST['description'] ?? ''),
            'status' => 'available',
        ];

        // Basic validation
        if (empty($data['brand']) || empty($data['model']) || $data['year'] < 2000 || empty($data['plate_number'])) {
            $this->flash('danger', 'Please fill in all required fields.');
            $this->redirect('admin/cars/create');
            return;
        }

        // Handle photo upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/cars/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $filePath)) {
                $data['photo'] = 'uploads/cars/' . $fileName;
            }
        }

        // Insert car
        try {
            $this->carModel->create($data);
            $this->flash('success', 'Car created successfully.');
        } catch (Exception $e) {
            $this->flash('danger', 'Failed to create car: ' . $e->getMessage());
        }

        $this->redirect('admin/cars');
    }

    public function edit(int $id): void
    {
        $car = $this->carModel->find($id);
        if (!$car) {
            $this->flash('danger', 'Car not found.');
            $this->redirect('admin/cars');
            return;
        }
        $this->view('admin.cars.edit', compact('car'), 'admin');
    }

    public function update(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/cars');
            return;
        }

        // Validate CSRF
        if (!$this->validateCsrf($_POST['_csrf_token'] ?? '')) {
            $this->flash('danger', 'Invalid CSRF token.');
            $this->redirect('admin/cars');
            return;
        }

        // Check if car exists
        $car = $this->carModel->find($id);
        if (!$car) {
            $this->flash('danger', 'Car not found.');
            $this->redirect('admin/cars');
            return;
        }

        // Get form data
        $data = [
            'brand' => trim($_POST['brand'] ?? ''),
            'model' => trim($_POST['model'] ?? ''),
            'year' => (int) ($_POST['year'] ?? 0),
            'plate_number' => trim($_POST['plate_number'] ?? ''),
            'transmission' => $_POST['transmission'] ?? '',
            'capacity' => (int) ($_POST['capacity'] ?? 0),
            'category' => $_POST['category'] ?? '',
            'daily_price' => (float) ($_POST['daily_price'] ?? 0),
            'description' => trim($_POST['description'] ?? ''),
            'status' => $_POST['status'] ?? 'available',
        ];

        // Basic validation
        if (empty($data['brand']) || empty($data['model']) || $data['year'] < 2000 || empty($data['plate_number'])) {
            $this->flash('danger', 'Please fill in all required fields.');
            $this->redirect("admin/cars/{$id}/edit");
            return;
        }

        // Handle photo upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/cars/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Delete old photo if exists
            if (!empty($car['photo']) && file_exists(__DIR__ . '/../../public/' . $car['photo'])) {
                unlink(__DIR__ . '/../../public/' . $car['photo']);
            }

            $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $filePath)) {
                $data['photo'] = 'uploads/cars/' . $fileName;
            }
        }

        // Update car
        try {
            $this->carModel->update($id, $data);
            $this->flash('success', 'Car updated successfully.');
        } catch (Exception $e) {
            $this->flash('danger', 'Failed to update car: ' . $e->getMessage());
        }

        $this->redirect('admin/cars');
    }

    public function delete(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/cars');
            return;
        }

        // Validate CSRF
        if (!$this->validateCsrf($_POST['_csrf_token'] ?? '')) {
            $this->flash('danger', 'Invalid CSRF token.');
            $this->redirect('admin/cars');
            return;
        }

        // Check if car exists
        $car = $this->carModel->find($id);
        if (!$car) {
            $this->flash('danger', 'Car not found.');
            $this->redirect('admin/cars');
            return;
        }

        // Delete photo if exists
        if (!empty($car['photo']) && file_exists(__DIR__ . '/../../public/' . $car['photo'])) {
            unlink(__DIR__ . '/../../public/' . $car['photo']);
        }

        // Delete car
        try {
            $this->carModel->remove($id);
            $this->flash('success', 'Car deleted successfully.');
        } catch (Exception $e) {
            $this->flash('danger', 'Failed to delete car: ' . $e->getMessage());
        }

        $this->redirect('admin/cars');
    }
}