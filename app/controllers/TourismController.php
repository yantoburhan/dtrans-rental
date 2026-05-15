<?php

/**
 * TourismController — Public tourism destinations
 */
class TourismController extends Controller
{
    public function index(): void
    {
        $tourismModel = new TourismDestination();
        $destinations = $tourismModel->getFeatured(20);

        $this->view('tourism.index', [
            'destinations' => $destinations,
            'pageTitle'    => 'Tourism Destinations',
        ]);
    }

    public function show(int $id): void
    {
        $tourismModel = new TourismDestination();
        $destination  = $tourismModel->getWithPhotos($id);

        if (!$destination) {
            $this->flash('danger', 'Tourism destination not found.');
            $this->redirect('tourism');
            return;
        }

        $this->view('tourism.show', [
            'destination' => $destination,
            'pageTitle'   => htmlspecialchars($destination['name']),
        ]);
    }
}
