<?php

namespace App\Http\Controllers;
use App\Models\Stores;
use App\Models\Products;
use App\Models\StoresAndProducts;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($id)
    {
        $store = Stores::where('user_id',Auth::id())->where('id',$id)->first();
        $listProduct =$store->products()->paginate(10);
        return view('product/home', ['listProduct' => $listProduct,'id' => $id]);
    }

    public function fetchData(Request $request)
    {
        if ($request->ajax()) {
            $listProductofStore = StoresAndProducts::where('store_id',$request->id)->get();
            $listProduct = Products::whereIn('id',$listProductofStore->pluck('product_id')->toArray())
            ->where('product_name','LIKE', '%' . $request->products_name . '%')
            ->paginate(10)->appends($request->except(['page', '_token']));

            return view('product/product-data', ['listProduct' => $listProduct,'id' => $request->id])->render();
        }
    }

    public function addProduct(Request $request){
        $store = new StoresAndProducts();
        $store->store_id=$request->id;
        $store->product_id=$request->product_select;
        $store->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Thêm thành công',
        ]);
    }

    public function listProduct($store_id){

        $listProductofStore = StoresAndProducts::where('store_id',$store_id)->get();

        $products = Products::whereNotIn('id',$listProductofStore->pluck('product_id')->toArray())->get();

        return response()->json([
            'status' => 'success',
            'data' => $products,
        ]);
    }

    public function listEditProduct(Request $request,$store_id){
        $listProductofStore = StoresAndProducts::where('store_id',$store_id)->get();
        $arrayListStore = $listProductofStore->pluck('product_id')->toArray();
        foreach($arrayListStore as $k=>$arrayStore){
            if($arrayStore==$request->id){
                unset($arrayListStore[$k]);
            }
        }
        $products = Products::whereNotIn('id',$arrayListStore)->get();
        return response()->json([
            'status' => 'success',
            'data' => $products,
        ]);
    }

    public function detailProduct($id){
        $store = Stores::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $store,
        ]);
    }

    public function editProduct(Request $request){
        $store =StoresAndProducts::where('store_id',$request->idStore)->where('product_id',$request->idProd)->first();
        $store->product_id=$request->edit_product_select;
        $store->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Thay đổi thành công',
        ]);
    }

    public function deleteProduct($store,$id)
    {
        $store_product = StoresAndProducts::where('store_id',$store)->where('product_id',$id)->first();
        $store_product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Xóa thành công',
        ], 200);
    }
}
