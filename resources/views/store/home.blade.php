@extends("layout/layout")
@section("name-page")
<title>Store</title>
@endsection

@section("name-content")
<h3>Danh sách cửa hàng</h3>
@endsection

@section("main-content")
<form style="margin:10px;" id="formSearchStore" method="get" action="">
    @csrf
    <div class="row">
        <div class="col">
            <label for="stores_name" class="form-label">Tên cửa hàng</label>
            <div style="display:flex;gap:20px;">
            <input type="text" class="form-control" id="stores_name" placeholder="Nhập tên cửa hàng" name="product_name">
            <div class="col">
                    <button type="submit" class="btn btn-labeled btn-primary">
                        <i class="fa fa-search"></i>Tìm kiếm</button>
                </div>
                <div class="col-4 delete-search">
                    <a class="btn btn-success">
                        <i class="fa fa-times"></i>Xóa tìm</a>
                </div>
            </div>
           
        </div>

    </div>
    <br>
    <div class="row">
        <div class="col">
            <a class="btn btn-primary" id="create_product" href=""  data-toggle="modal" data-target="#exampleModal"><i class="fa fa-user-plus"></i>Thêm mới</a>
        </div>

    </div>
</form>
<div id="table_data">
    @include('store/store-data')
</div>

<input id="hidden_page" value="1" type="hidden" name="hidden_page">

<!-- modal add store -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="alert alert-danger" id="error_messege_create" style="display:none"></div>
            <div class="modal-header">
                <h5 class="modal-title">Thêm mới</h5>
            </div>
            <div class="modal-body">

                <form method="" action="" id="formAddStore" style="padding:10px">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Tên</label>
                        <div class="col">
                            <input type="text" class="form-control" id="name" name="store_name" placeholder="Tên cửa hàng">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Địa chỉ</label>
                        <div class="col">
                            <input type="text" class="form-control" id="name" name="store_address" placeholder="Địa chỉ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="type" class="col-sm-2 col-form-label">Loại</label>
                        <div class="col">
                            <select id="type" class="form-control" name="type">
                            <option value="" selected>Chọn loại</option>
                                <option value="S">S</option>
                                <option value="A">A</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col" style="display: flex;justify-content: flex-end;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-danger" style="margin-left:20px">Lưu</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- modal edit store -->
<div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="alert alert-danger" id="error_messege_edit" style="display:none"></div>
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa</h5>
            </div>
            <div class="modal-body">
                <form method="" action="" id="formEditStore" style="padding:10px">
                    @csrf
                    <input hidden type="text" class="form-control" id="editID" name="id" readonly>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Tên</label>
                        <div class="col">
                            <input type="text" class="form-control" id="store_name" name="store_name" placeholder="Tên cửa hàng">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Địa chỉ</label>
                        <div class="col">
                            <input type="text" class="form-control" id="store_address" name="store_address" placeholder="Địa chỉ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="type" class="col-sm-2 col-form-label">Loại</label>
                        <div class="col">
                            <select id="type" class="form-control" name="type">
                                <option value="" selected>Chọn loại</option>
                                <option value="S">S</option>
                                <option value="A">A</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col" style="display: flex;justify-content: flex-end;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-danger" style="margin-left:20px">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section("js-content")
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $('#formAddStore').on('submit', function(event) {
            event.preventDefault();
            var formData = $('#formAddStore').serialize();
            addStore(formData);
        });

        $(document).on('click', '#edit', function(event) {
            document.getElementById("error_messege_edit").style.display = "none";
            $('#error_messege_edit').html('');

            var id = $(this).data('url').split('&id=')[1];

            $.ajax({
            type: "GET",
            url: '/detail-store/'+id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $("#editID").val(data.data.id);
                $("#store_name").val(data.data.store_name);
                $("#store_address").val(data.data.store_address);
                $("div.col #type").val(data.data.type).change();
                }
            }); 
        })

        $('#formEditStore').on('submit', function(event) {
            event.preventDefault();
            var id = $('#id').val();
            var formData = $('#formEditStore').serialize();
            editStore(formData, id);
        });

        $(document).on('click', '._delete_user', function() {
            var id = $(this).data("id");
            var url = $(this).data('url').split('&name=')[0];
            var name = $(this).data('url').split('name=')[1];
            var token = $("meta[name='csrf-token']").attr("content");
            swal({
                title: "Nhắc nhở",
                text: "Bạn có chắc muốn xóa cửa hàng " + name.toUpperCase() + " không",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "Green",
                confirmButtonText: "Ok",
                closeOnConfirm: false
            }).then(isConfirmed => {
                if (isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function(data) {
                            if (data.status) {
                                swal({
                                    title: data.message,
                                    type: data.status,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    position: 'center',
                                    timer: 1500,
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else {
                                console.log(data.status);
                                swal("Delete!", data.message, "error");
                            }
                        }
                    });
                }
            });
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $("#hidden_page").val(page);
            var store_name = $('#stores_name').val();
            fetchData(page, store_name);
        });
        $(document).on('click', '.delete-search a', function(event) {
            event.preventDefault();
            var page = 1
            $("#stores_name").val("");
            fetchData(page, "");
        });
        $('#formSearchStore').on('submit', function(event) {
            event.preventDefault();
            var formData = $('#formSearchStore').serialize();
            var store_name = $('#stores_name').val();
            var page = 1;
            fetchData(page, store_name);
        });
    });

    function fetchData(page, store_name) {
        $.ajax({
            url: "{{route('fetch-data-store')}}" + "?page=" + page + "&store_name=" + store_name,
            success: function(data) {
                $('#table_data').html('');
                $('#table_data').html(data);
            }
        });
    }

    function addStore(formData) {
        $.ajax({
            type: "POST",
            url: "{{route('add-store')}}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            success: function(data) {
                if (data.status == "errors") {
                    $('.alert-danger').html('');

                    $.each(data.message, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<li>' + value + '</li>');
                    });
                } else {
                    swal({
                        title: data.message,
                        type: data.status,
                        showCancelButton: false,
                        showConfirmButton: false,
                        position: 'center',
                        timer: 1500,
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        });
    }

    function editStore(formData, idUser) {
        $.ajax({
            type: "POST",
            url: "{{route('edit-store')}}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            success: function(data) {
                if (data.status == "errors") {
                    $('.alert-danger').html('');

                    $.each(data.message, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<li>' + value + '</li>');
                    });
                } else {
                    swal({
                        title: data.message,
                        type: data.status,
                        showCancelButton: false,
                        showConfirmButton: false,
                        position: 'center',
                        timer: 1500,
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>
@endsection

