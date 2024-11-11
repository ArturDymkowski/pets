<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PetController extends Controller
{
    private function getPet(int $id)
    {
        $response = Http::get('https://petstore.swagger.io/v2/pet/' . $id);
        $content = $response->json();

        return $content;
    }

    public function index(int $id)
    {
        $pet = $this->getPet($id);

        return view('index', [
            'pet' => $pet,
            'id' => $id
        ]);
    }

    public function edit(Request $request, int $id)
    {
        $pet = $this->getPet($id);

        if ($request->submit) {
            $data = $request->all();
            $request->validate([
                'category_id' => 'numeric',
            ]);

            $response = Http::put("https://petstore.swagger.io/v2/pet", [
                'id' => $id,
                'name' => $data['name'],
                'status' => $data['status'],
                'category' => [
                    'id' => $data['category_id'],
                    'name' => $data['category_name'],
                ]
            ]);

            return redirect()->route('pets.edit', ['id' => $id]);
        }

        return view('edit', [
            'id' => $id,
            'pet' => $pet
        ]);
    }
}
