<?php

namespace App\Controllers\Web;

use Psr\Http\Message\ResponseInterface;

class MainController
{
    public function index(): ResponseInterface
    {
        return response()->view('web.main.index');
    }
}
