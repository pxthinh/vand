@extends("layout/layout")
@section("name-page")
<title>Product</title>
@endsection

@section("name-content")
<h3>Danh sách sản phảm</h3>
@endsection

@section("main-content")
<form style="margin:10px;" id="formSearchProductAdmin" method="get" action="">
    @csrf
    <div class="row">
        <div class="col">
            <label for="products_name" class="form-label">Tên sản phẩm</label>
            <div style="display:flex;gap:20px;">
            <input type="text" class="form-control" id="products_name" placeholder="Nhập tên sản phẩm" name="products_name">
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
            <a class="btn btn-primary" id="create_product" href="{{route('add-product-admin')}}" ><i class="fa fa-user-plus"></i>Thêm mới</a>
        </div>

    </div>
</form>
<div id="table_data">
    @include('admin/product-data')
</div>

<input id="hidden_page" value="1" type="hidden" name="hidden_page">
@endsection
@section("js-content")
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {

        $(document).on('click', '._delete_data', function() {
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
            fetchData(page, products_name);
        });
        $(document).on('click', '.delete-search a', function(event) {
            event.preventDefault();
            var page = 1
            $("#products_name").val("");
            fetchData(page, "");
        });
        $('#formSearchProductAdmin').on('submit', function(event) {
            event.preventDefault();
            var formData = $('#formSearchProductAdmin').serialize();
            var products_name = $('#products_name').val();
            var page = 1;
            fetchData(page, products_name);
        });
    });

    function fetchData(page, products_name) {
        $.ajax({
            url: "{{route('fetch-data-product-admin')}}" + "?page=" + page + "&products_name=" + products_name,
            success: function(data) {
                $('#table_data').html('');
                $('#table_data').html(data);
            }
        });
    }

</script>
@endsection

