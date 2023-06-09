@extends('backend.layout.app')
@section('content')

    <div class="col-md-9">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{$panel}}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
                <form method="post" action="{{route($route.'store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        {!! Form::label('title', 'Title: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <div class="col-sm-10">
                            {!! Form::text('title', null,['class' => 'form-control','placeholder' => 'Enter Title','id'=>'titlel',]) !!}
                            @error('title')
                            <span class="text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('description', 'Description: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('description', null,['class' => 'form-control','placeholder' => 'Enter Excerpt','id'=>'summernote']) !!}
                            @error('description')
                            <span class="text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('excerpt', 'Excerpt: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('excerpt', null,['class' => 'form-control','placeholder' => 'Enter Excerpt']) !!}
                            @error('excerpt')
                            <span class="text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('client', 'Client: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('client', null,['class' => 'form-control','placeholder' => 'Enter client']) !!}
                            @error('client')
                            <span class="text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('image_file', 'Thumbnail: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <div class="col-sm-10">
                            {!! Form::file('image_file', null,['class' => 'form-control','placeholder' => 'Enter Github Link','id'=>'image_file','name'=>'image_file']) !!}
                            @error('image_file')
                            <span class="text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="img" class="col-sm-2 col-form-label"> Multiple Image</label>
                        <div class="col-sm-10">
                        <input type="file" name="img[]" id="img" class="form-control" multiple >
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="contributors" class="col-sm-2 col-form-label"> Contributors</label>
                        <div class="col-sm-10">

                        <select name="contributors_id[]" class="form-control" multiple>
                            @foreach ($contributors as $contributor)
                                <option value="{{ $contributor->id }}">{{ $contributor->name }}</option>
                            @endforeach
                        </select>
                        </div>

                    </div>
                    <div  style="display: flex" >
                        <div><h2>Links</h2></div>
<div class="col-sm-10" style="margin-left: 90px">
                    <table class="table table-striped table-bordered" id="link_wrapper">

                        <tr>
                            <th>URL</th>
                            <th>Playstore</th>
                            <th>App Store</th>
{{--                            <th>Action</th>--}}
                        </tr>
                        <tr>
                            <td><input type="text" name="link" class="form-control"/></td>
                            <td><input type="text" name="playstore" class="form-control"/></td>
                            <td><input type="text" name="appstore" class="form-control"/></td>

                        </tr>
                    </table>
</div>
                    </div>

                    <div  style="display: flex" >
                    <div ><h2>Contributors</h2></div>
                    </div>






                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </div>
@endsection

@section('csss')
    <style>
        .required{
            color: red;
        }
    </style>
@endsection
@section('script')
    <script>
        $(function () {
            // Summernote
            $('#summernote').summernote()

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>
    <script>
        // console.log('hi');
        var y = 1;
        var image_wrapper = $("#image_wrapper"); //Fields wrapper
        var add_button_image = $("#addMoreImage"); //Add button ID
        console.log(add_button_image);
        $(add_button_image).click(function (e) { //on add input button click
            var max_fields = 15; //maximum input boxes allowed
            e.preventDefault();
            if (y < max_fields) { //max input box allowed
                y++; //text box increment
                var id = 'remove_row' + y;
                $("#image_wrapper tr:last").after(
                    '<tr>'
                    + '<td><input type="text" name="contributor_name[]" class="form-control"/></td>'
                    + '<td><input type="text" name="contributor_facebook[]" class="form-control"/></td>'
                    + '<td><input type="text" name="contributor_linkedin[]" class="form-control"/></td>'
                    + '<td><input type="text" name="role[]" class="form-control"/></td>'
                    + '<td>'
                    + '<a class="btn btn-block btn-warning sa-warning remove_row"> <i class="fa fa-trash"></i></a>'
                    + '</td>'
                    + '</tr>');

            } else {
                alert("Max field reached. " + max_fields + " allowed");
            }
        });

        $(image_wrapper).on("click", ".remove_row", function (e) {
            e.preventDefault();
            $(this).parents("tr").remove();
            y--;
        });
    </script>
@endsection

