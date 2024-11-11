@extends('template')

@section('content')
<div class="row">
    <div class="input-group mb-3" style="align-items: center;">
        <label for="pet_id" style="margin-right: 10px;">Podaj ID elementu Pet: </label>
        <input type="text" class="form-control" placeholder="ID" aria-label="Username" aria-describedby="basic-addon1"
               id="pet_id" name="pet_id"
               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
    </div>

    <div class="btn-group" role="group" aria-label="Actions">
        <a href="#" class="btn btn-info" id="pet_show">Pokaż</a>
        <a href="" class="btn btn-warning" id="pet_edit">Edytuj</a>
        <a href="" class="btn btn-danger" id="pet_delete">Usuń</a>
    </div>

</div>
<div class="row mt-1">
    <div class="btn-group">
        <a href="" class="btn btn-success">Dodaj nowy element</a>
    </div>
</div>

@if(isset($pet))
    <div class="row mt-1">
        {{ $pet }}
    </div>
@endif

<script>
    const petId = document.getElementById('pet_id');

    const inputHandler = function(e) {
        var petShowUrl = "{{ route('pets.index', ['pet' => 1])  }}";
        petShowUrl = petShowUrl.slice(0, -1) + document.getElementById('pet_id').value;

        document.getElementById('pet_show').href=petShowUrl;
        document.getElementById('pet_edit').href="sradaraar";
        document.getElementById('pet_delete').href="sradaraar";
    }

    petId.addEventListener('input', inputHandler);
</script>

@endsection
