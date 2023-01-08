<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stores;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StoreController extends BaseUserController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $listStore = Stores::where('user_id',Auth::guard('user')->id())->orderBy('updated_at', 'desc')->paginate(10);
        return view('store/home', ['listStore' => $listStore]);
    }

    public function fetchData(Request $request)
    {
        if ($request->ajax()) {
            $listStore = Stores::where('user_id',Auth::guard('user')->id())->where(function ($q) use ($request) {
                $q->when($request->filled('store_name'), function ($q) use ($request) {
                    $q->where('store_name', 'LIKE', '%' . $request->store_name . '%');
                });
            })->orderBy('updated_at', 'desc')->paginate(10)->appends($request->except(['page', '_token']));
            return view('store/store-data', ['listStore' => $listStore])->render();
        }
    }

    public function addStore(Request $request){
        $messages = [
            'store_name.required' => 'Tên cửa hàng không được để trống',
            'store_address.required' => 'Địa chỉ không được để trống',
        ];
        $validator = Validator::make($request->all(), [
            'store_name' => 'required',
            'store_address' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'errors',
                'message' => $validator->errors()->all(),
            ]);
        }
     
        $store = new Stores();
        $store->user_id=Auth::id();
        $store->store_name=$request->store_name;
        $store->store_address = $request->store_address;
        $store->type = empty($request->type) ? 'A' : 'S';
        $store->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Thêm thành công',
        ]);
    }

    public function detailStore($id){
        $store = Stores::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $store,
        ]);
    }

    public function editStore(Request $request){
        $messages = [
            'store_name.required' => 'Tên cửa hàng không được để trống',
            'store_address.required' => 'Địa chỉ không được để trống',
        ];
        $validator = Validator::make($request->all(), [
            'store_name' => 'required',
            'store_address' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'errors',
                'message' => $validator->errors()->all(),
            ]);
        }
     
        $store = Stores::find($request->id);
        $store->store_name = $request->store_name;
        $store->store_address = $request->store_address;
        $store->type = empty($request->type) ? 'A' : 'S';
        $store->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Thay đổi thành công',
        ]);
    }

    public function deleteStore($id)
    {
        $store = Stores::find($id);
        $store->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Xóa thành công',
        ], 200);
    }
}
