@extends('backend.layout.app')
@section('content')
            @if(Session::has('success'))
                <p class="alert alert-success">{{Session::get('success')}}</p>
            @endif
            @if(Session::has('error'))
                <p class="alert alert-danger">{{Session::get('danger')}}</p>
            @endif
            @if(Session::has('warning'))
                <p class="alert alert-warning">{{Session::get('warning')}}</p>
            @endif
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
                            {!! Form::text('name', null,['class' => 'form-control','placeholder' => 'Enter name']) !!}

                          @error('name')
                            <span class="text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('role', 'Role: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <div class="col-sm-10">
                            {!! Form::text('role', null,['class' => 'form-control','placeholder' => 'Enter Role']) !!}

                            @error('role')
                            <span class="text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('github', 'Github: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <div class="col-sm-10">
                            {!! Form::text('github', null,['class' => 'form-control','placeholder' => 'Enter github']) !!}
                            @error('github')
                            <span class="text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('linkedin', 'Linkedin: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <div class="col-sm-10">
                            {!! Form::text('linkedin', null,['class' => 'form-control','placeholder' => 'Enter linkedin']) !!}
                            @error('linkedin')
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
