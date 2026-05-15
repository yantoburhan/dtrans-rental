<?php

class CustomerController extends Controller
{
    public function dashboard(): void
    {
        $this->view('customer/dashboard', [
            'pageTitle' => 'Customer Dashboard',
        ]);
    }

    public function profile(): void
    {
        $this->view('customer/profile', [
            'pageTitle' => 'My Profile',
            'csrf' => $this->generateCsrf(),
        ]);
    }

    public function updateProfile(): void
    {
        // Handle profile update
        $this->flash('success', 'Profile updated successfully.');
        $this->redirect('customer/profile');
    }
}