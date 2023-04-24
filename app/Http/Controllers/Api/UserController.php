<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\UserServices;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $service;

    public function __construct(UserServices $userServices)
    {
        $this->service = $userServices;
    }

    public function register(Request $request)
    {
        $data = $this->service->register($request);
        return $data;
    }
}
