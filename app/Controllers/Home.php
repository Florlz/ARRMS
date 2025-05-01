<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('login');
    }

    public function studentView(): string
    {
        return view('student_dashboard');
    }
}
