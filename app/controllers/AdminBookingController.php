<?php

/**
 * AdminBookingController — Manage bookings from the admin panel
 */
class AdminBookingController extends Controller
{
    private Booking $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new Booking();
    }

    public function index(): void
    {
        $bookings = $this->bookingModel->getAllAdminBookings();

        $this->view('admin.bookings.index', [
            'bookings'  => $bookings,
            'pageTitle' => 'Bookings',
        ], 'admin');
    }

    public function show(string $id): void
    {
        $booking = $this->bookingModel->getFullDetail((int) $id);

        if (!$booking) {
            $this->flash('danger', 'Booking not found.');
            $this->redirect('admin/bookings');
            return;
        }

        $this->view('admin.bookings.show', [
            'booking' => $booking,
            'csrf'    => $this->generateCsrf(),
            'pageTitle' => 'Booking Detail',
        ], 'admin');
    }

    public function approve(string $id): void
    {
        $this->verifyCsrf();

        $booking = $this->bookingModel->find((int) $id);
        if (!$booking) {
            $this->flash('danger', 'Booking not found.');
            $this->redirect('admin/bookings');
            return;
        }

        $this->bookingModel->updateStatus((int) $id, Booking::STATUS_APPROVED);
        $this->flash('success', 'Booking approved successfully.');
        $this->redirect("admin/bookings/$id");
    }

    public function reject(string $id): void
    {
        $this->verifyCsrf();

        $booking = $this->bookingModel->find((int) $id);
        if (!$booking) {
            $this->flash('danger', 'Booking not found.');
            $this->redirect('admin/bookings');
            return;
        }

        $this->bookingModel->updateStatus((int) $id, 'rejected');
        $this->flash('success', 'Booking rejected successfully.');
        $this->redirect("admin/bookings/$id");
    }

    public function complete(string $id): void
    {
        $this->verifyCsrf();

        $booking = $this->bookingModel->find((int) $id);
        if (!$booking) {
            $this->flash('danger', 'Booking not found.');
            $this->redirect('admin/bookings');
            return;
        }

        $this->bookingModel->updateStatus((int) $id, Booking::STATUS_COMPLETED);
        $this->flash('success', 'Booking marked as completed.');
        $this->redirect("admin/bookings/$id");
    }
}
