@extends('template')

@section('content')

    <style>
        .category {
            width: 100%;
        }
    </style>

    <div class="row">
        <h3>Edit pet</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ route('pets.edit', ['id' => $id]) }}">
            @csrf
            <div class="form-group mb-3">
                <label for="id">ID</label>
                <input type="text" class="form-control" id="id" name="id" placeholder="ID" value="{{ $id }}" disabled>
            </div>
            <div class="form-group mb-3" style="display:flex;">
                <div class="category me-3">
                    <label for="category_id">Category ID</label>
                    <input  type="text" class="form-control" id="category_id" name="category_id" placeholder="Category ID" value="@if(isset($pet['category']['id'])){{ $pet['category']['id'] }}@endif"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                    >
                </div>

                <div class="category">
                    <label for="category_name">Category Name</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Category Name" value="@if(isset($pet['category']['name'])){{ $pet['category']['name'] }}@endif">
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="id">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="@if(isset($pet['name'])){{ $pet['name'] }}@endif">
            </div>
            <div class="form-group mb-3">
                <label for="id">Status</label>
                <input type="text" class="form-control" id="status" name="status" placeholder="Status" value="@if(isset($pet['status'])){{ $pet['status'] }}@endif">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Zapisz">
        </form>
    </div>
@endsection
