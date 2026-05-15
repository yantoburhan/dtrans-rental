<?php

/**
 * AdminController — Admin dashboard and overview
 */
class AdminController extends Controller
{
    public function dashboard(): void
    {
        $bookingModel = new Booking();
        $carModel     = new Car();
        $driverModel  = new Driver();
        $userModel    = new User();

        $stats = [
            'total_bookings'   => $bookingModel->count(),
            'active_rentals'   => $bookingModel->getActiveRentals(),
            'total_revenue'    => $bookingModel->getTotalRevenue(),
            'total_customers'  => $userModel->getTotalCustomers(),
            'total_cars'       => $carModel->getTotalCars(),
            'most_rented_cars' => $carModel->getMostRented(5),
            'best_drivers'     => $driverModel->getBestDrivers(5),
            'monthly_revenue'  => $bookingModel->getMonthlyRevenue(date('Y')),
            'recent_bookings'  => method_exists($bookingModel, 'getRecentBookings')
                ? $bookingModel->getRecentBookings(10)
                : [],
        ];

        $this->view('admin.dashboard', compact('stats'), 'admin');
    }
}
