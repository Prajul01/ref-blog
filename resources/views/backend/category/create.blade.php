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
                    <table class="table table-striped table-bordered" id="image_wrapper">
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td><input type="text" name="name[]" class="form-control"/></td>
                            <td>
                                <button class="btn btn-info" type="button" id="addMoreImage"style="margin-bottom: 20px"> <i class="fa fa-plus"></i> Add</button>

                            </td>
                        </tr>
                    </table>



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
@section('jss')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
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
                    + ' <td><input type="text" name="name[]" class="form-control" /></td>'
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

