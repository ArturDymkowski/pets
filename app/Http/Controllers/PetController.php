<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index(int $id)
    {
        return view('welcome', [
            'pet' => $id
        ]);
    }
}
