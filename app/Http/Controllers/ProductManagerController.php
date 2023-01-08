<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Products;

class ProductManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listProduct=Products::orderBy('updated_at', 'desc')->paginate(10);
        return view('admin/home', ['listProduct' => $listProduct]);
    }

    public function fetchData(Request $request)
    {
        if ($request->ajax()) {
    
            $listProduct = Products::where(function ($q) use ($request) {
                $q->when($request->filled('products_name'), function ($q) use ($request) {
                    $q->where('product_name', 'LIKE', '%' . $request->products_name . '%');
                });
            })->orderBy('updated_at', 'desc')->paginate(10)->appends($request->except(['page', '_token']));
            return view('admin/product-data', ['listProduct' => $listProduct])->render();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-product-admin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product=new Products();
        $product->product_name = $request->product_name;
        $product->product_price = $request->product_price;
        $product->description = $request->description;
        $product->save();
        return redirect()->route('list-product-admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Products::find($id);
        return view('admin/edit-product-admin', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductRequest $request,$id)
    {
        $product= Products::find($id);
        $product->product_name = $request->product_name;
        $product->product_price = $request->product_price;
        $product->description = $request->description;
        $product->save();
        return redirect()->route('list-product-admin');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::find($id);
        $product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Xóa thành công',
        ], 200);
    }
}
