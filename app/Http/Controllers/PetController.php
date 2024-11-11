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

    public function delete(int $id)
    {
        $response = Http::delete('https://petstore.swagger.io/v2/pet/' . $id);
        $content = $response->json();

        if (is_null($content)) {
            $deleteMessage = '<p class="text-danger">Element o podanym ID nie istnieje!</p>';
        }
        else {
            $deleteMessage = '<p class="text-success">Pomyślnie usunięto element o ID ' . $id . '</p>';
        }

        return view('index', [
            'deleteMessage' => $deleteMessage,
            'id' => $id
        ]);
    }

    public function edit(Request $request, int $id)
    {
        $pet = $this->getPet($id);
        $contentForPhotoUrlsRepeater = "";
        $contentForTagsRepeater = "";

        if (isset($pet['photoUrls'])) {
            foreach ($pet['photoUrls'] as $photoUrl) {
                $contentForPhotoUrlsRepeater .= "<div class='container'>";
                $contentForPhotoUrlsRepeater .= "<input class='form-control' name='photoUrls[]' type='text' value='$photoUrl'>";
                $contentForPhotoUrlsRepeater .= "<button class='btn btn-danger' type='button' id='remove'>-</button>";
                $contentForPhotoUrlsRepeater .= '</div>';
            }
        }

        if (isset($pet['tags'])) {
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
        }

        if ($request->submit) {
            $data = $request->all();

            $request->validate([
                'category_id' => 'numeric',
            ]);

            $tags = $this->getTags($data);

            Http::put("https://petstore.swagger.io/v2/pet", [
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

    public function add(Request $request)
    {
        if ($request->submit) {
            $data = $request->all();

            $request->validate([
                'category_id' => 'numeric',
                'id' => 'numeric',
            ]);
            $tags = $this->getTags($data);

            Http::post("https://petstore.swagger.io/v2/pet", [
                'id' => $data['id'],
                'name' => $data['name'] ?? '',
                'status' => $data['status'] ?? '',
                'photoUrls' => $data['photoUrls'] ?? [],
                'category' => [
                    'id' => $data['category_id'] ?? '',
                    'name' => $data['category_name'] ?? '',
                ],
                'tags' => $tags
            ]);

            return redirect()->route('pets.index', ['id' => $data['id']]);
        }

        return view('add');
    }

    private function getTags(array $content)
    {
        $tags = [];

        if (isset($content['tags'])) {
            for ($i=0; $i<=count($content['tags']['id'])-1; $i++) {
                $tags[] = [
                    'id' => $content['tags']['id'][$i],
                    'name' => $content['tags']['name'][$i],
                ];
            }
        }

        return $tags;
    }
}
