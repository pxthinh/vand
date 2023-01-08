{{$listProduct->links('pagination')}}
<!-- Bang du lieu -->
<table style="margin:10px;" class="table table-striped" id="table2">
    <thead>
        <tr class="table-danger" style="--bs-table-bg: red; color:white">
            <th scope="col">#</th>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Giá</th>
            <th scope="col">Mô tả</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody id="product_body">
    <?php $i = ($listProduct->currentpage() - 1) * $listProduct->perpage() + 1; ?>
        @forelse ($listProduct as $product)
        <tr>
            <th scope="row">{{$i++}}</th>
            <td>
                <div class="hover_container">
                    <div class="text">{{ $product->product_name}}</div>
                </div>
            </td>
            <td class="text-success">{{number_format( $product->product_price, 0, '', ',')}} VNĐ</td>
            <td>{!!strlen($product->description)>50? substr($product->description,0,50).'...':$product->description !!}</td>
            <td>
                <a id="edit" data-toggle="modal" data-target="#editForm" data-url="{{ route('edit-product').'&id='.$product->id}}"><i class="fas fa-pencil-alt"></i></a>
                <a class="_delete_product" id="{{$product->id}}" data-url="{{ route('delete-product', ['store_id'=>$id ,'id'=>$product->id]).'&name='.$product->product_name }}"><i class="fa fa-trash" style="color:red"></i></a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align: center;">Không có dữ liệu</td>
        </tr>
        @endforelse
    </tbody>
</table>
