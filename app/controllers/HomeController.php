<?php

class HomeController extends Controller
{
    public function index(): void
    {
        $carModel     = new Car();
        $driverModel  = new Driver();
        $tourismModel = new TourismDestination();

        $this->view('home', [
            'featuredCars'    => $carModel->getAvailableCars(),
            'bestDrivers'     => $driverModel->getBestDrivers(4),
            'destinations'    => $tourismModel->getFeatured(6),
            'pageTitle'       => 'Home',
        ]);
    }
}
