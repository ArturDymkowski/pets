@extends('template')

@section('content')

    <style>
        .category {
            width: 100%;
        }

        .parent-container{
            height:auto;
        }

        .container{
            position:relative;
        }

        .container > input {
            display:block;
            margin:5px 0;
        }

        .parent-container .container > button {
            position: absolute;
            margin-top: -42px;
            right: -35px;
        }

        .tags-parent-container .container > button {
            position: absolute;
            margin-top: 0;
            right: -35px;
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
            <div class="form-group mb-3">
                <label>Photos Urls</label>
                    <div class="parent-container">
                        {!! $contentForPhotoUrlsRepeater !!}
                    </div>
                <button type='button' class='btn btn-success' id='add'>+</button>
            </div>
            <div class="form-group mb-3">
                <label>Tags</label>
                <div class="tags-parent-container">
                    {!! $contentForTagsRepeater !!}
                </div>
                <button type='button' class='btn btn-success' id='add-tag'>+</button>
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Zapisz">
        </form>
    </div>

    <script>
        var content = "<div class='container'>" +
            "<input class='form-control' name='photoUrls[]' type='text' required>" +
            "<button class='btn btn-danger' type='button' id='remove'>-</button>"
            "</div>";

        var tagsContent = "<div class='tags-container mb-1' style='display: flex;'>" +
            "<label>ID</label>" +
            "<input class='form-control' name='tags[id][]' type='text' required>" +
            "<label>Name</label>" +
            "<input class='form-control' name='tags[name][]' type='text' required>" +
            "<button class='btn btn-danger' type='button' id='remove-tag'>-</button>"
        "</div>";

        // $(".parent-container").html(content);

        // Photos
        $("#add").on("click", function(){
            if($(".parent-container").children().length < 5){
                $(".parent-container").append(content);
            }
            if($(".parent-container").children().length == 5){
                $("#add").hide();
            }
        });

        $(".parent-container").on("click", "#remove", function(){
            $(this).parent().remove();
            $("#add").show();
        });

        //Tags
        $("#add-tag").on("click", function(){
            if($(".tags-parent-container").children().length < 5){
                $(".tags-parent-container").append(tagsContent);
            }
            if($(".tags-parent-container").children().length == 5){
                $("#add-tag").hide();
            }
        });

        $(".tags-parent-container").on("click", "#remove-tag", function(){
            $(this).parent().remove();
            $("#add-tag").show();
        });

    </script>
@endsection
