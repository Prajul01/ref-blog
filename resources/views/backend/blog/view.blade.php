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
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{$panel}}-{{$title}}</h3>
            </div>
            <button class="button" onclick="history.back(-1)">Go-Back</button>
            <div class="card-body">

                <table class="table-bordered" height="100%" width="100%">

                    <tr>
                        <th>Title</th>
                        <td>{{$data['row']['title']}}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{!!$data['row']['description'] !!}</td>
                    </tr>
                    <tr>
                        <th>Excerpt</th>
                        <td>{{$data['row']['excerpt']}}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{$data['row']['category']['name']}}</td>
                    </tr>
{{--                    <tr>--}}
{{--                        <th>Image</th>--}}
{{--                        <td><img src="{{asset('uploads/images/blog/'.$data['row']->image)}}" class="image2" alt=""--}}
{{--                                 style="height: 200px; width: 200px; border: 15px solid white">--}}
{{--                        </td>--}}
{{--                    </tr>--}}

                </table>

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
