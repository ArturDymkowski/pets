<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PetController extends Controller
{
    public function index(int $id)
    {
        $response = Http::get('https://petstore.swagger.io/v2/pet/' . $id);
        $content = $response->json();

        return view('welcome', [
            'content' => $content,
            'id' => $id
        ]);
    }
}
