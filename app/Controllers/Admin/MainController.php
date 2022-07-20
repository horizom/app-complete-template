<?php

namespace App\Controllers\Admin;

use Psr\Http\Message\ResponseInterface;

class MainController
{
    public function index(): ResponseInterface
    {
        return response()->view('admin.main.index');
    }
}
