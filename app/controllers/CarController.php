<?php

/**
 * CarController — Public car listings and details
 */
class CarController extends Controller
{
    public function index(): void
    {
        $carModel = new Car();

        $today = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tomorrow = (clone $today)->modify('+1 day');

        $filters = [
            'category'     => $this->input('category', ''),
            'transmission' => $this->input('transmission', ''),
            'capacity'     => $this->input('capacity', ''),

            // Default otomatis hari ini & besok
            'pickup_date'  => $this->input(
                'pickup_date',
                $today->format('Y-m-d')
            ),

            'return_date'  => $this->input(
                'return_date',
                $tomorrow->format('Y-m-d')
            ),
        ];

        $cars = $carModel->getAvailableCars(array_filter($filters));

        $this->view('cars.index', [
            'cars'      => $cars,
            'filters'   => $filters,
            'pageTitle' => 'Available Cars',
        ]);
    }

    public function show(int $id): void
    {
        $carModel = new Car();
        $car      = $carModel->getWithPhotos($id);

        if (!$car) {
            $this->flash('danger', 'Car not found.');
            $this->redirect('cars');
            return;
        }

        $this->view('cars.show', [
            'car'       => $car,
            'pageTitle' => htmlspecialchars($car['brand'] . ' ' . $car['model']),
        ]);
    }
}
