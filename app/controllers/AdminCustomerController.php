<?php

/**
 * AdminCustomerController — Manage customers in admin panel
 */
class AdminCustomerController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index(): void
    {
        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $customers = $this->userModel->getCustomers($page, 20);

        $this->view('admin.customers.index', [
            'customers'   => $customers['data'],
            'pagination'  => $customers,
            'pageTitle'   => 'Customers',
        ], 'admin');
    }

    public function show(int $id): void
    {
        $customer = $this->userModel->findCustomer($id);
        if (!$customer) {
            $this->flash('danger', 'Customer not found.');
            $this->redirect('admin/customers');
            return;
        }

        $this->view('admin.customers.show', compact('customer'), 'admin');
    }
}
