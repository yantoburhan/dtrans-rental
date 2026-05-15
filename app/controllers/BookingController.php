<?php

/**
 * BookingController — Customer-facing booking management
 */
class BookingController extends Controller
{
    private Booking $bookingModel;
    private Car $carModel;
    private Driver $driverModel;

    public function __construct()
    {
        $this->bookingModel = new Booking();
        $this->carModel     = new Car();
        $this->driverModel  = new Driver();
    }

    // ----------------------------------------------------------------
    // List all customer bookings
    // ----------------------------------------------------------------

    public function index(): void
    {
        $user = Session::get('user');

        if (!$user) {
            $this->flash('danger', 'Please login first.');
            $this->redirect('login');
            return;
        }

        $bookings = $this->bookingModel->getByUser($user['id']);

        $this->view('bookings.index', [
            'bookings' => $bookings
        ]);
    }

    // ----------------------------------------------------------------
    // Show single booking detail
    // ----------------------------------------------------------------

    public function show(string $id): void
    {
        $user = Session::get('user');

        if (!$user) {
            $this->flash('danger', 'Please login first.');
            $this->redirect('login');
            return;
        }

        $booking = $this->bookingModel->getFullDetail((int) $id);

        if (!$booking || $booking['user_id'] != $user['id']) {
            $this->flash('danger', 'Booking not found.');
            $this->redirect('customer/bookings');
            return;
        }

        $this->view('bookings.show', [
            'booking' => $booking
        ]);
    }

    // ----------------------------------------------------------------
    // Create booking page
    // ----------------------------------------------------------------

    public function create(): void
    {
        $carId      = (int) $this->input('car_id', 0);
        $pickupDate = $this->input('pickup_date', date('Y-m-d'));
        $returnDate = $this->input(
            'return_date',
            date('Y-m-d', strtotime('+1 day'))
        );

        $car = $this->carModel->getWithPhotos($carId);

        if (!$car) {
            $this->flash('danger', 'Car not found.');
            $this->redirect('cars');
            return;
        }

        $availableDrivers = $this->driverModel
            ->getAvailableDrivers($pickupDate, $returnDate);

        $this->view('bookings.create', [
            'car'              => $car,
            'availableDrivers' => $availableDrivers,
            'pickupDate'       => $pickupDate,
            'returnDate'       => $returnDate,
            'csrf'             => $this->generateCsrf(),
        ]);
    }

    // ----------------------------------------------------------------
    // Store booking
    // ----------------------------------------------------------------

    public function store(): void
    {
        $this->verifyCsrf();

        $user = Session::get('user');

        if (!$user) {
            $this->flash('danger', 'Please login first.');
            $this->redirect('login');
            return;
        }

        $carId      = (int) $this->input('car_id', 0);
        $driverId   = (int) $this->input('driver_id', 0) ?: null;
        $pickupDate = $this->input('pickup_date');
        $returnDate = $this->input('return_date');

        // Validate dates
        if ($pickupDate >= $returnDate) {
            $this->flash(
                'danger',
                'Return date must be after pickup date.'
            );

            $this->back();
            return;
        }

        if ($pickupDate < date('Y-m-d')) {
            $this->flash(
                'danger',
                'Pickup date cannot be in the past.'
            );

            $this->back();
            return;
        }

        // Prevent double booking
        if ($this->bookingModel->hasOverlap(
            $carId,
            $pickupDate,
            $returnDate,
            $driverId
        )) {
            $this->flash(
                'danger',
                'Selected car or driver is unavailable.'
            );

            $this->back();
            return;
        }

        $car = $this->carModel->find($carId);

        if (!$car) {
            $this->flash('danger', 'Car not found.');
            $this->redirect('cars');
            return;
        }

        $totalDays = (int) ceil(
            (strtotime($returnDate) - strtotime($pickupDate)) / 86400
        );

        $carPrice = $car['daily_price'] * $totalDays;

        $driverPrice = $driverId
            ? ($car['driver_price_per_day'] * $totalDays)
            : 0;

        $totalPrice = $carPrice + $driverPrice;

        $bookingId = $this->bookingModel->createBooking([
            'user_id'        => $user['id'],
            'car_id'         => $carId,
            'driver_id'      => $driverId,
            'pickup_date'    => $pickupDate,
            'return_date'    => $returnDate,
            'total_days'     => $totalDays,
            'car_price'      => $carPrice,
            'driver_price'   => $driverPrice,
            'total_price'    => $totalPrice,
            'payment_method' => $this->input('payment_method'),
            'notes'          => $this->input('notes'),
        ]);

        $booking = $this->bookingModel->getFullDetail($bookingId);

        if ($booking) {
            Mailer::sendBookingConfirmation($booking);
        }

        $this->flash(
            'success',
            'Booking created successfully!'
        );

        $this->redirect("customer/bookings/$bookingId");
    }

    // ----------------------------------------------------------------
    // Cancel booking
    // ----------------------------------------------------------------

    public function cancel(string $id): void
    {
        $this->verifyCsrf();

        $user = Session::get('user');

        if (!$user) {
            $this->json([
                'success' => false,
                'message' => 'Unauthorized.'
            ], 401);

            return;
        }

        $booking = $this->bookingModel->find((int)$id);

        if (!$booking) {
            $this->json([
                'success' => false,
                'message' => 'Booking not found.'
            ], 404);

            return;
        }

        if ((int)$booking['user_id'] !== (int)$user['id']) {
            $this->json([
                'success' => false,
                'message' => 'Unauthorized.'
            ], 403);

            return;
        }

        if (!in_array(
            $booking['status'],
            ['pending', 'waiting_payment']
        )) {
            $this->flash(
                'danger',
                'This booking cannot be cancelled.'
            );

            $this->back();
            return;
        }

        $this->bookingModel->updateStatus(
            (int)$id,
            Booking::STATUS_CANCELLED,
            [
                'cancelled_at' => date('Y-m-d H:i:s'),
                'cancellation_reason' => $this->input('reason', ''),
            ]
        );

        $this->flash(
            'success',
            'Booking cancelled successfully.'
        );

        $this->redirect('customer/bookings');
    }
}