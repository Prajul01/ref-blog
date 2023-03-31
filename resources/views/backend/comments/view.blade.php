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
                        <th>Name</th>
                        <td>{{$data['row']['fname']}} {{$data['row']['lname']}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$data['row']['email']}} </td>
                    </tr>
                    <tr>
                        <th>Blog</th>
                        <td>{{$data['row']['blog']['title']}} </td>
                    </tr>
                    <tr>
                        <th>Comment</th>
                        <td>{{$data['row']['comments']}} </td>
                    </tr>
                </table>

            </div>
        </div>
        <!-- /.card -->
    </div>
@endsection

