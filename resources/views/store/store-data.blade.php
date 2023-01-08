{{$listStore->links('pagination')}}
<!-- Bang du lieu -->
<table style="margin:10px;" class="table table-striped" id="table2">
    <thead>
        <tr class="table-danger" style="--bs-table-bg: red; color:white">
            <th scope="col">#</th>
            <th scope="col">Tên cửa hàng</th>
            <th scope="col">Địa chỉ</th>
            <th scope="col">Loại</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody id="product_body">
        <?php $i = ($listStore->currentpage() - 1) * $listStore->perpage() + 1; ?>
        @forelse ($listStore as $store)
        <tr>
            <th scope="row">{{$i++}}</th>
            <td>
                <div class="hover_container">
                    <div class="text">
                      <a class="text" id="{{$store->id}}" href="{{ route('list-product', $store->id)}}">{{ $store->store_name}}</a>
                    </div>
                </div>
            </td>
            <td>{!!strlen($store->store_address)>50? substr($store->store_address,0,50).'...':$store->store_address !!}</td>
            <td class="text-success">{{ $store->type}}</td>
            <td>
                <a id="edit" data-toggle="modal" data-target="#editForm" data-url="{{ route('edit-store').'&id='.$store->id}}"><i class="fas fa-pencil-alt"></i></a>
                <a class="_delete_user" id="{{$store->id}}" data-url="{{ route('delete-store', $store->id).'&name='.$store->store_name }}"><i class="fa fa-trash" style="color:red"></i></a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align: center;">Không có dữ liệu</td>
        </tr>
        @endforelse
    </tbody>
</table>
