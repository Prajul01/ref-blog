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
                {!! Form::model($data['row'], ['route' => [$route.'update', $data['row']->id ],'enctype'=>'multipart/form-data']) !!}
                {!! Form::hidden('_method', 'PUT') !!}
{{--                <form method="post" action="{{route($route.'update',$data['row']->id)}}" enctype="multipart/form-data">--}}
{{--                    <input type="hidden" name="_method" value="PUT">--}}
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
                        {!! Form::label('thumbnail', 'Thumbnail: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                        <div class="col-sm-10">
                            {!! Form::text('thumbnail', null,['class' => 'form-control','placeholder' => 'Enter Thumbnail','id'=>'thumbnail',]) !!}
                            @error('thumbnail')
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
                    <div class="col-sm-10" style="float: right">

                        <table class="table table-striped table-bordered" id="link_wrapper">
                            <h2>links</h2>
                            <tr>
                                <th>URL</th>
                                <th>Playstore</th>
                                <th>App Store</th>
                                {{--                            <th>Action</th>--}}
                            </tr>
                            <tr>
                                @foreach(json_decode($data['row']->links) as $test)
                                    <td><input type="text" name="link"  value="{{ $test->link }}" class="form-control"/></td>
                                    <td><input type="text" name="playstore" value="{{ $test->playstore }}" class="form-control"/></td>
                                    <td><input type="text" name="appstore" value="{{ $test->appstore }}" class="form-control"/></td>

                                @endforeach
{{--                                    @foreach(json_decode($data['row']->links) as $test)--}}
{{--                                        <td>--}}
{{--                                            --}}{{--                                <p></p>--}}
{{--                                            <p>URL: </p>--}}
{{--                                            <p>Playstore: </p>--}}
{{--                                            <p>AppStore: </p>--}}

{{--                                        </td>--}}
{{--                                    @endforeach--}}
                            </tr>
                        </table>
                    </div>
{{--                       <table class="table table-striped table-bordered" id="image_wrapper">--}}

{{--                                                    <h2>contributors</h2>--}}
{{--                            <tr>--}}
{{--                                <th>Name</th>--}}
{{--                                <th>Github</th>--}}
{{--                                <th>Linkedin</th>--}}
{{--                                <th>Role</th>--}}
{{--                                <th>Action</th>--}}
{{--                                --}}{{--                            <th>Action</th>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                           @foreach(json_decode($data['row']->contributors) as $contributor)--}}
{{--                               @for($i = 0; $i < count($contributor->name); $i++)--}}
{{--                                   <tr>--}}
{{--                                       <td><input type="text" name="contributor_name[]" class="form-control" value="{{$contributor->name[$i]}}"></td>--}}
{{--                                       <td><input type="text" name="contributor_facebook[]" value="{{$contributor->github[$i]}}" class="form-control"/></td>--}}
{{--                                       <td><input type="text" name="contributor_linkedin[]" value="{{$contributor->linkedin[$i]}}" class="form-control"/></td>--}}
{{--                                       <td><input type="text" name="role[]" value="{{$contributor->role[$i]}}" class="form-control"/></td>--}}
{{--                                       <td>--}}
{{--                                           @if($i == 0)--}}
{{--                                               <button class="btn btn-info" type="button" id="addMoreImage"style="margin-bottom: 20px"> <i class="fa fa-plus"></i> Add</button>--}}

{{--                                           @else--}}
{{--                                               <a class="btn btn-block btn-warning sa-warning remove_row"> <i class="fa fa-trash"></i></a>--}}
{{--                                           @endif--}}
{{--                                       </td>--}}
{{--                                   </tr>--}}
{{--                                   @endfor--}}
{{--                                   @endforeach--}}


{{--                            </tr>--}}
{{--                        </table>--}}
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
