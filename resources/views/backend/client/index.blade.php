@extends('backend.layout.app')
@section('csss')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

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

    <div class="card" style="margin: 10px">


    <!-- /.card-header -->
        <div class="card-body">


            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>

                    <th>SN</th>
                    <th>Name</th>
                    <th>Image</th>


                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['row'] as $i=>$event)
                    <tr>

                        <td> {{$i+1}}</td>
                        <td>{{$event['name']}}</td>

                        <td>
                            <img src="{{asset('uploads/images/clients/'.$event->image)}}" class="image2" alt=""
                                 style="height: 100px; width: 100px; border: 15px solid white">

                        </td>

                        <td>
                            <a href="{{route($route.'show',$event['id'])}}" class="btn btn-sm btn-primary">
                                <i class="fa fa-eye"></i>

                            </a>
                            <a href="{{route($route.'edit',$event['id'])}}" class="btn btn-sm btn-warning"> <i class="fa fa-pencil-alt"></i></a>
                            <form class="d-inline" action="{{route($route.'destroy',$event['id'])}}" method="post">
                                <input type="hidden" name="_method" value="delete"/>
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger "><i class="fa fa-trash"></i></button>

                            </form>


                        </td>

                        @endforeach
                    </tr>


                </tbody>
            </table>
        </div>

        <!-- /.card-body -->
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": true, "autoWidth": true,
               // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>


    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('backend/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('backend/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('backend/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
@endsection
