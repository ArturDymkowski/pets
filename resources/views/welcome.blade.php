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
            <a href="@if(isset($id)) {{ route('pets.index', ['id' => $id])  }} @else # @endif" class="btn btn-warning" id="pet_edit">Edytuj</a>
            <a href="@if(isset($id)) {{ route('pets.index', ['id' => $id])  }} @else # @endif" class="btn btn-danger" id="pet_delete">Usuń</a>
        </div>

    </div>
    <div class="row mt-1">
        <div class="btn-group">
            <a href="" class="btn btn-success">Dodaj nowy element</a>
        </div>
    </div>

    @if(isset($content))
        <div class="row mt-5">
            <table class="table">
                <tbody>
                @if(isset($content['code']))
                    <p class="text-danger">Wystąpił błąd!</p>
                    <tr>
                        <td>Code:</td>
                        <td><strong>{{ $content['code'] }}</strong></td>
                    </tr>
                    @if(isset($content['type']))
                        <tr>
                            <td>Type:</td>
                            <td><strong>{{ $content['type'] }}</strong></td>
                        </tr>
                    @endif
                    @if(isset($content['message']))
                        <tr>
                            <td>Message:</td>
                            <td><strong>{{ $content['message'] }}</strong></td>
                        </tr>
                    @endif
                @else
                    <p class="text-success">Sukces!</p>
                    @if(isset($content['id']))
                        <tr>
                            <td>ID:</td>
                            <td><strong>{{ $content['id'] }}</strong></td>
                        </tr>
                    @endif
                    @if(isset($content['category']))
                        <tr>
                            <td>Category:</td>
                            <td>
                                ID: <strong>{{ $content['category']['id'] }}</strong> <br>
                                Name: <strong>{{ $content['category']['name'] }}</strong>
                            </td>
                        </tr>
                    @endif
                    @if(isset($content['name']))
                        <tr>
                            <td>Name:</td>
                            <td><strong>{{ $content['name'] }}</strong></td>
                        </tr>
                    @endif
                    @if(!empty($content['photoUrls']))
                        <tr>
                            <td>PhotoUrls:</td>
                            <td>
                                @foreach($content['photoUrls'] as $photoUrl)
                                    <a href="{{ $photoUrl }}" target="_blank"><img src="{{ $photoUrl }}" alt="{{ $photoUrl }}"
                                                                                   width="250" height="250"></a>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    @if(!empty($content['tags']))
                        <tr>
                            <td>Tags:</td>
                            <td>
                                @foreach($content['tags'] as $tag)
                                    ID: <strong>{{ $tag['id'] }}</strong> <br>
                                    Name: <strong>{{ $tag['name'] }}</strong>
                                    <br><br>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    @if(!empty($content['status']))
                        <tr>
                            <td>Status:</td>
                            <td><strong>{{ $content['status'] }}</strong></td>
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

            document.getElementById('pet_show').href = petShowUrl;
            document.getElementById('pet_edit').href = "sradaraar";
            document.getElementById('pet_delete').href = "sradaraar";
        }

        petId.addEventListener('input', inputHandler);
    </script>
@endsection
