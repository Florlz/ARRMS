<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        helper(['form', 'url']);
        return view('login');
    }

    public function studentView(): string
    {
        return view('student_dashboard');
    }

    public function registerUser(): string
    {
        return view('register_user');
    }

}
