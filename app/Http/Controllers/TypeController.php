<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Http\Controllers\Controller;
use Exception;
use FFI\CType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        try {
            Type::create([
                'name'                  => $request -> name,
                'email'                 => $request -> email,
                'password'              => $request -> password,
                'forget_password_token' => $request -> forget_password_token,
                'email_verify_token'    => $request -> email_verify_token,
            ]);
            return response()-> json([
                'message'           => 'Tạo mới thể loại thành công!',
                'status'            => true,
            ]);
        } catch (\Throwable $th) {
            return response()-> json([
                'message'           => 'that bai',
                'status'             => false,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getData(Request $request)
    {
        $data = Type::get();
        return response()->json([
            'create_clients_table'   => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $check_id = $request->id;
            $data = Type::where("id", $check_id)->update([
                'name'                  => $request -> name,
            ]);
            return response()->json([
                'status' => true,
                'message' => "update thành công !",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "update không thành công !",
                'err' => $th
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request){
        try {
            Type::where('id',$request->id)->delete();
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Xóa thể loại thành công!',
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi",$e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }
}
