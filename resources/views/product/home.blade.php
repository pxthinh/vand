@extends("layout/layout")
@section("name-page")
<title>Product</title>
@endsection

@section("name-content")
<h3>Danh sách sản phảm</h3>
@endsection

@section("main-content")
<form style="margin:10px;" id="formSearchProduct" method="get" action="">
    @csrf
    <div class="row">
        <div class="col">
            <label for="products_name" class="form-label">Tên sản phẩm</label>
            <div style="display:flex;gap:20px;">
            <input type="text" class="form-control" id="products_name" placeholder="Nhập tên sản phẩm" name="product_name">
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
    @include('product/product-data')
</div>

<input id="hidden_page" value="1" type="hidden" name="hidden_page">

<!-- modal add store -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="alert alert-danger" id="error_messege_create" style="display:none"></div>
            <div class="modal-header">
                <h5 class="modal-title">Chọn sản phẩm cần thêm</h5>
            </div>
            <div class="modal-body">

                <form method="" action="" id="formAddProduct" style="padding:10px">
                    @csrf
                    <input hidden type="text" class="form-control" id="addIdProduct" name="id" readonly>
                    <div class="form-group row">
                        <label for="product_select" class="col-sm-2 col-form-label">Chọn sản phẩm</label>
                        <div class="col">
                            <select id="product_select" class="form-control" name="product_select">
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
                <form method="" action="" id="formEditProduct" style="padding:10px">
                    @csrf
                    <input hidden type="text" class="form-control" id="editIdStore" name="idStore" readonly>
                    <input hidden type="text" class="form-control" id="editIdProd" name="idProd" readonly>
                    <div class="form-group row">
                        <label for="edit_product_select" class="col-sm-2 col-form-label">Loại</label>
                        <div class="col">
                            <select id="edit_product_select" class="form-control" name="edit_product_select">
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

        $(document).on('click', '#create_product', function(event) {
            var id = window.location.href.split('/')[4].split('?')[0];
            $.ajax({
            type: "GET",
            url: '/list-products/'+id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                   let html = ''
                   if(data.status==="success"){
                       data.data.forEach((item)=>{
                            html += `<option value="${item.id}" >${item.product_name}</option>`;
                       });
                   }
                   $("#addIdProduct").val(id);
                   $("#product_select").append(html);
                }
            }); 
        });

        $('#formAddProduct').on('submit', function(event) {
            event.preventDefault();
            var formData = $('#formAddProduct').serialize();
            addProduct(formData);
        });

        $(document).on('click', '#edit', function(event) {
            document.getElementById("error_messege_edit").style.display = "none";
            $('#error_messege_edit').html('');

            var idProd = $(this).data('url').split('&id=')[1];
            var id = window.location.href.split('/')[4].split('?')[0];
            $.ajax({
            type: "GET",
            url: '/list-edit-products/'+id+`?id=`+idProd,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                   let html = ''
                   if(data.status==="success"){
                       data.data.forEach((item)=>{
                            html += `<option value="${item.id}" >${item.product_name}</option>`;
                       });
                   }
                   $("#editIdStore").val(id);
                   $("#editIdProd").val(idProd);
                   $("#edit_product_select").append(html);
                   $("div.col #edit_product_select").val(idProd).change();
                   console.log(data,idProd)
                }
            }); 
        });

        $('#formEditProduct').on('submit', function(event) {
            event.preventDefault();
            var id = $('#id').val();
            var formData = $('#formEditProduct').serialize();
            editProduct(formData, id);
        });

        $(document).on('click', '._delete_product', function() {
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
            var products_name = $('#products_name').val();
            var id = window.location.href.split('/')[4].split('?')[0];
            fetchData(page, products_name,id);
        });
        $(document).on('click', '.delete-search a', function(event) {
            event.preventDefault();
            var page = 1
            $("#products_name").val("");
            var id = window.location.href.split('/')[4].split('?')[0];
            fetchData(page, "",id);
        });
        $('#formSearchProduct').on('submit', function(event) {
            event.preventDefault();
            var formData = $('#formSearchProduct').serialize();
            var products_name = $('#products_name').val();
            var page = 1;
            var id = window.location.href.split('/')[4].split('?')[0];
            fetchData(page, products_name,id);
        });
    });

    function fetchData(page, products_name,id) {
        $.ajax({
            url: "{{route('fetch-data-product')}}" + "?page=" + page + "&products_name=" + products_name+ "&id=" + id,
            success: function(data) {
                $('#table_data').html('');
                $('#table_data').html(data);
            }
        });
    }

    function addProduct(formData) {
        $.ajax({
            type: "POST",
            url: "{{route('add-product')}}",
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

    function editProduct(formData, idUser) {
        $.ajax({
            type: "POST",
            url: "{{route('edit-product')}}",
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

