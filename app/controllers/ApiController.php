<?php

/**
 * ApiController — JSON endpoints for AJAX interactions
 * Used by realtime availability checks and booking calculations
 */
class ApiController extends Controller
{
    public function carAvailability(): void
    {
        $carId      = (int) $this->input('car_id', 0);
        $pickupDate = $this->input('pickup_date');
        $returnDate = $this->input('return_date');

        if (!$carId || !$pickupDate || !$returnDate) {
            $this->json(['error' => 'Missing parameters.'], 400);
        }

        $bookingModel = new Booking();
        $available    = !$bookingModel->hasOverlap($carId, $pickupDate, $returnDate);

        $this->json(['available' => $available]);
    }

    public function availableDrivers(): void
    {
        $pickupDate = $this->input('pickup_date');
        $returnDate = $this->input('return_date');

        if (!$pickupDate || !$returnDate) {
            $this->json(['error' => 'Missing parameters.'], 400);
        }

        $driverModel = new Driver();
        $drivers     = $driverModel->getAvailableDrivers($pickupDate, $returnDate);

        $this->json(['drivers' => $drivers]);
    }

    public function calculateBooking(): void
    {
        $carId      = (int) $this->input('car_id', 0);
        $driverId   = (int) $this->input('driver_id', 0);
        $pickupDate = $this->input('pickup_date');
        $returnDate = $this->input('return_date');

        $car = (new Car())->find($carId);
        if (!$car) {
            $this->json(['error' => 'Car not found.'], 404);
        }

        $totalDays   = (int) ceil((strtotime($returnDate) - strtotime($pickupDate)) / 86400);
        $carPrice    = $car['daily_price'] * $totalDays;
        $driverPrice = $driverId ? ($car['driver_price_per_day'] * $totalDays) : 0;

        $this->json([
            'total_days'   => $totalDays,
            'car_price'    => $carPrice,
            'driver_price' => $driverPrice,
            'total_price'  => $carPrice + $driverPrice,
        ]);
    }
}
