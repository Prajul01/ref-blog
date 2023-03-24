@extends('backend.layout.app')

@section('csss')
    <style>

        .button {
            transition-duration: 0.4s;
            width: 20%;
            border: 5px solid white
        }

        .button:hover {
            background-color: #4CAF50; /* Green */
            color: white;
        }

    </style>
    <style>
        .required{
            color: red;
        }
    </style>
@endsection

@section('content')
    <div class="col-md-9">
        @if(Session::has('success'))
            <p class="alert alert-success">{{Session::get('success')}}</p>
        @endif
        @if(Session::has('error'))
            <p class="alert alert-danger">{{Session::get('danger')}}</p>
    @endif
    <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" >{{$panel}}-{{$title}}</h3>
            </div>
            <button class="button" onclick="history.back(-1)">Go-Back</button>
            <div class="card-body">
                {!! Form::model($data['row'], ['route' => [$route.'update', $data['row']->id ],'enctype'=>'multipart/form-data']) !!}
                {!! Form::hidden('_method', 'PUT') !!}
                @csrf
{{--                <form method="post" action="{{route($route.'update',$data['row']->id)}}" enctype="multipart/form-data">--}}
{{--                    <input type="hidden" name="_method" value="PUT">--}}
{{--                    @csrf--}}
                    <div class="form-group row">
                        {!! Form::label('title', 'Title: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <br>
                        <div class="col-sm-10">
                            {!! Form::text('title', null, [ 'class'=>'form-control', 'placeholder'=>'Enter name']); !!}
                            @error('title')
                            <p class="text-danger">{{$message}}</p>
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
                        {!! Form::label('description', 'Description: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('description',null,['class' => 'form-control','placeholder' => 'Enter Excerpt','id'=>'summernote']) !!}
                            @error('description')
                            <span class="text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('category_id', 'Category: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <div class="col-sm-10">
                            {!! Form::select('category_id', $data['category'], null,['class' => 'form-control','placeholder' => 'Select Category']) !!}
                            @error('category_id')
                            <span class="text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                <div class="form-group row">
                    {!! Form::label('image_file', 'Image: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                    <div class="col-sm-10">
                        {!! Form::file('image_file', null,['class' => 'form-control','placeholder' => 'Enter Github Link','id'=>'image_file','name'=>'image_file']) !!}
                        @error('image_file')
                        <span class="text text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </div>
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
@endsection

