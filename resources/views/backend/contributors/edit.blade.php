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
                {!! Form::model($data['row'], ['route' => [$route.'update', $data['row']['id']],'enctype'=>'multipart/form-data']) !!}
                {!! Form::hidden('_method', 'PUT') !!}
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
                    {!! Form::label('github', 'Github: ',['class' => 'col-sm-2 col-form-label'],false); !!}
                    <div class="col-sm-10">
                        {!! Form::text('github', null,['class' => 'form-control','placeholder' => 'Enter github']) !!}
                        @error('github')
                        <span class="text text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('linkedin', 'Linkedin: ',['class' => 'col-sm-2 col-form-label'],false); !!}
                    <div class="col-sm-10">
                        {!! Form::text('linkedin', null,['class' => 'form-control','placeholder' => 'Enter linkedin']) !!}
                        @error('linkedin')
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
@section('jss')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
@endsection
