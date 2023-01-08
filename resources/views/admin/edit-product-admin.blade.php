@extends("layout/layout")
@section("name-page")
<title>Product</title>
@endsection
@section("name-content")
<h3>Chi tiết sản phẩm</h3>
@endsection
@section("main-content")
<form style="margin:30px;" method="POST" action="{{route('edit-product-admin',['id' => $product->id])}}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col">
            <div class="form-group row">
                <label for="product_name" class="col-sm-2 col-form-label">Tên sản phẩm</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Nhập tên sản phẩm" value="{{$product->product_name}}">
                    @error('product_name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="product_price" class="col-sm-2 col-form-label">Giá bán</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Nhập giá bán" value="{{$product->product_price}}">
                    @error('product_price')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="product_description" class="col-sm-2 col-form-label">Mô tả</label>
                <div class="col-sm-6">
                    <textarea class="ckeditor form-control" name="description" id="product_description" placeholder="Mô tả sản phẩm" rows="7">{!!$product->description !!}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col" style="margin-left: 900px;">
            <a class="btn btn-secondary" href="{{route('list-product-admin')}}">Hủy</a>
            <button type="submit" class="btn btn-labeled btn-danger">Lưu</button>
        </div>
    </div>
    </div>
</form>
@endsection
