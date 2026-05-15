<?php

/**
 * DriverController — Public driver listings
 */
class DriverController extends Controller
{
    public function publicIndex(): void
    {
        $driverModel = new Driver();
        $drivers     = $driverModel->getBestDrivers(12);

        $this->view('drivers.index', [
            'drivers'   => $drivers,
            'pageTitle' => 'Our Drivers',
        ]);
    }
}
