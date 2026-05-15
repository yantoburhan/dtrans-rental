<?php

/**
 * App — Core application bootstrap
 * Parses the URL and dispatches to the correct controller/method
 */
class App
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function run(): void
    {
        $this->router->dispatch();
    }
}
