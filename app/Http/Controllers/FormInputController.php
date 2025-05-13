<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormInputController extends Controller
{
public function index()
{
    return view('admin.farmers.view');
}
}
