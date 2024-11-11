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
        $contentForPhotoUrlsRepeater = "";
        $contentForTagsRepeater = "";

        foreach ($pet['photoUrls'] as $photoUrl) {
            $contentForPhotoUrlsRepeater .= "<div class='container'>";
            $contentForPhotoUrlsRepeater .= "<input class='form-control' name='photoUrls[]' type='text' value='$photoUrl'>";
            $contentForPhotoUrlsRepeater .= "<button class='btn btn-danger' type='button' id='remove'>-</button>";
            $contentForPhotoUrlsRepeater .= '</div>';
        }

        foreach ($pet['tags'] as $tag) {
            $tagId = $tag['id'];
            $tagName = $tag['name'];
            $contentForTagsRepeater .= "<div class='tags-container mb-1' style='display: flex;'>";
            $contentForTagsRepeater .= '<label>ID</label>';
            $contentForTagsRepeater .= "<input class='form-control' name='tags[id][]' type='text' value='$tagId'>";
            $contentForTagsRepeater .= '<label>Name</label>';
            $contentForTagsRepeater .= "<input class='form-control' name='tags[name][]' type='text' value='$tagName'>";
            $contentForTagsRepeater .= "<button class='btn btn-danger' type='button' id='remove-tag'>-</button>";
            $contentForTagsRepeater .= '</div>';
        }

        if ($request->submit) {
            $data = $request->all();

            $request->validate([
                'category_id' => 'numeric',
                'tags[id]' => 'numeric',
            ]);
            $tags = [];

            if (isset($data['tags'])) {
                for ($i=0; $i<=count($data['tags']['id'])-1; $i++) {
                    $tags[] = [
                        'id' => $data['tags']['id'][$i],
                        'name' => $data['tags']['name'][$i],
                    ];
                }
            }

            $response = Http::put("https://petstore.swagger.io/v2/pet", [
                'id' => $id,
                'name' => $data['name'] ?? '',
                'status' => $data['status'] ?? '',
                'photoUrls' => $data['photoUrls'] ?? [],
                'category' => [
                    'id' => $data['category_id'] ?? '',
                    'name' => $data['category_name'] ?? '',
                ],
                'tags' => $tags
            ]);

            return redirect()->route('pets.edit', ['id' => $id]);
        }

        return view('edit', [
            'id' => $id,
            'pet' => $pet,
            'contentForPhotoUrlsRepeater' => $contentForPhotoUrlsRepeater,
            'contentForTagsRepeater' => $contentForTagsRepeater
        ]);
    }
}
