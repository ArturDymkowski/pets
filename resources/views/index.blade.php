@extends('template')

@section('content')
    <div class="row">
        <div class="input-group mb-3" style="align-items: center;">
            <label for="pet_id" style="margin-right: 10px;">Podaj ID elementu Pet: </label>
            <input type="text" class="form-control" placeholder="ID" aria-label="Username"
                   aria-describedby="basic-addon1"
                   id="pet_id" name="pet_id"
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                   value="@if(isset($id)){{ $id }}@endif"
            >
        </div>

        <div class="btn-group" role="group" aria-label="Actions">
            <a href="@if(isset($id)) {{ route('pets.index', ['id' => $id]) }} @else # @endif" class="btn btn-info" id="pet_show">Pokaż</a>
            <a href="@if(isset($id)) {{ route('pets.edit', ['id' => $id])  }} @else # @endif" class="btn btn-warning" id="pet_edit">Edytuj</a>
            <a href="@if(isset($id)) {{ route('pets.delete', ['id' => $id])  }} @else # @endif" class="btn btn-danger" id="pet_delete" onclick="return confirm('Jesteś pewien że chcesz usunąć ten element?');">Usuń</a>
        </div>

    </div>
    <div class="row mt-1">
        <div class="btn-group">
            <a href="{{ route('pets.add') }}" class="btn btn-success">Dodaj nowy element</a>
        </div>
    </div>

    @if(isset($deleteMessage))
        {!! $deleteMessage !!}
    @endif

    @if(isset($pet))
        <div class="row mt-5">
            <table class="table">
                <tbody>
                @if(isset($pet['code']))
                    <p class="text-danger">Wystąpił błąd!</p>
                    <tr>
                        <td>Code:</td>
                        <td><strong>{{ $pet['code'] }}</strong></td>
                    </tr>
                    @if(isset($pet['type']))
                        <tr>
                            <td>Type:</td>
                            <td><strong>{{ $pet['type'] }}</strong></td>
                        </tr>
                    @endif
                    @if(isset($pet['message']))
                        <tr>
                            <td>Message:</td>
                            <td><strong>{{ $pet['message'] }}</strong></td>
                        </tr>
                    @endif
                @else
                    <p class="text-success">Sukces!</p>
                    @if(isset($pet['id']))
                        <tr>
                            <td>ID:</td>
                            <td><strong>{{ $pet['id'] }}</strong></td>
                        </tr>
                    @endif
                    @if(isset($pet['category']))
                        <tr>
                            <td>Category:</td>
                            <td>
                                ID: <strong>{{ $pet['category']['id'] }}</strong> <br>
                                Name: <strong>{{ $pet['category']['name'] }}</strong>
                            </td>
                        </tr>
                    @endif
                    @if(isset($pet['name']))
                        <tr>
                            <td>Name:</td>
                            <td><strong>{{ $pet['name'] }}</strong></td>
                        </tr>
                    @endif
                    @if(!empty($pet['photoUrls']))
                        <tr>
                            <td>PhotoUrls:</td>
                            <td>
                                @foreach($pet['photoUrls'] as $photoUrl)
                                    <a href="{{ $photoUrl }}" target="_blank"><img src="{{ $photoUrl }}" alt="{{ $photoUrl }}"
                                                                                   width="250" height="250"></a>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    @if(!empty($pet['tags']))
                        <tr>
                            <td>Tags:</td>
                            <td>
                                @foreach($pet['tags'] as $tag)
                                    ID: <strong>{{ $tag['id'] }}</strong> <br>
                                    Name: <strong>{{ $tag['name'] }}</strong>
                                    <br><br>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    @if(!empty($pet['status']))
                        <tr>
                            <td>Status:</td>
                            <td><strong>{{ $pet['status'] }}</strong></td>
                        </tr>
                    @endif
                @endif
                </tbody>
            </table>
        </div>
    @endif

    <script>
        const petId = document.getElementById('pet_id');

        const inputHandler = function (e) {
            var petShowUrl = "{{ route('pets.index', ['id' => 1])  }}";
            petShowUrl = petShowUrl.slice(0, -1) + document.getElementById('pet_id').value;
            var petEditUrl = "{{ route('pets.edit', ['id' => 1])  }}";
            petEditUrl = petEditUrl.slice(0, -1) + document.getElementById('pet_id').value;
            var petDeleteUrl = "{{ route('pets.delete', ['id' => 1])  }}";
            petDeleteUrl = petDeleteUrl.slice(0, -1) + document.getElementById('pet_id').value;

            document.getElementById('pet_show').href = petShowUrl;
            document.getElementById('pet_edit').href = petEditUrl;
            document.getElementById('pet_delete').href = petDeleteUrl;
        }

        petId.addEventListener('input', inputHandler);
    </script>
@endsection
