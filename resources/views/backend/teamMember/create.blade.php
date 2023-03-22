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
                        {!! Form::label('name', 'Name: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', null,['class' => 'form-control','placeholder' => 'Enter Name','id'=>'name',]) !!}
                            @error('name')
                            <span class="text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('designation', 'Designation: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <div class="col-sm-10">
                            {!! Form::text('designation', null,['class' => 'form-control','placeholder' => 'Enter Designation','id'=>'designation',]) !!}
                            @error('designation')
                            <span class="text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('github', 'GitHub: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <div class="col-sm-10">
                            {!! Form::text('github', null,['class' => 'form-control','placeholder' => 'Enter Github Link','id'=>'github',]) !!}
                            @error('github')
                            <span class="text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('linkedin', 'Linkedin: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <div class="col-sm-10">
                            {!! Form::text('linkedin', null,['class' => 'form-control','placeholder' => 'Enter Github Link','id'=>'linkedin',]) !!}
                            @error('linkedin')
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

