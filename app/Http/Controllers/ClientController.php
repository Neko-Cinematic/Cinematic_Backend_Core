<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Models\Author;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function data()
    {
        $data = Client::get();
        return response()->json([
            'create_clients_table'   => $data,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        try {
            Client::create([
                'name'                  => $request -> name,
                'email'                 => $request -> email,
                'password'              => bcrypt($request->password),
                'forget_password_token' => "",
                'email_verify_token'    => "",
            ]);
            return response()-> json([
                'message'           => 'thanh cong',
                'status'            => true,
            ]);
        } catch (\Throwable $th) {
            return response()-> json([
                'message'               => 'that bai',
                'status'                => false,
            ]);

        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateDataClient(Request $request)
    {
        try {
            $check_id = $request->id;
            $data = Client::where("id", $check_id)->update([
                'name'                  => $request -> name,
                'email'                 => $request -> email,
                'password'              => $request -> password,
                'forget_password_token' => $request -> forget_password_token,
                'email_verify_token'    => $request -> email_verify_token,
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
    public function destroy(Client $id){
        try {
            Client::where('id',$id)->delete();
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Xóa thành công!',
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi",$e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }

    public function login(Request $request){
        $check = Auth::guard('client')->attempt(['email' => $request->email, 'password' => $request->password]);
        if($check == true) {
            $user = Auth::guard('client')->user();
            return response()->json([
                'message'    => 'Đã đăng nhập!!!',
                'status'     => true,
                'token'      => $user->createToken('api-token')->plainTextToken,
            ]);
        } else {
            return response()->json([
                'status'     =>   false,
                'message'    =>   'Thai bai',
            ]);
        }
    }
}

