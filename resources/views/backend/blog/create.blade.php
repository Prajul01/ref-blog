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
                            {!! Form::text('title', null,['class' => 'form-control','placeholder' => 'Enter Title']) !!}
                            @error('title')
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
                        {!! Form::label('description', 'Description: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('description', null,['class' => 'form-control','placeholder' => 'Enter Excerpt','id'=>'summernote']) !!}
                            @error('description')
                            <span class="text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
{{--                    <div class="form-group row">--}}
{{--                        {!! Form::label('github', 'GitHub: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}--}}
{{--                        <div class="col-sm-10">--}}
{{--                            {!! Form::text('github', null,['class' => 'form-control','placeholder' => 'Enter Github Link','id'=>'github',]) !!}--}}
{{--                            @error('github')--}}
{{--                            <span class="text text-danger">{{$message}}</span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
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
                            {!! Form::file('image_file',['class' => 'form-control','placeholder' => 'Enter Github Link','id'=>'image_file','name'=>'image_file']) !!}
                            @error('image_file')
                            <span class="text text-danger">{{$message}}</span>
                            @enderror
                        </div>
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
@endsection

