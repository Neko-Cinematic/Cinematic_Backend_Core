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
            'data'   => $data,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $pass_length = strlen($request->password);
            $pass = $request->password;

            if($pass_length < 5 ){
                return response()->json([
                    'message'               => 'Mật khẩu quá yếu',
                    'status'                => false,
                ]);
            }

            Client::create([
                'name'                  => $request->name,
                'email'                 => $request->email,
                'password'              => bcrypt($request->password),
                'forget_password_token' => "",
                'email_verify_token'    => "",
            ]);
            return response()->json([
                'message'           => 'Đăng ký thành công',
                'status'            => true,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'               => 'Đăng ký thất bại',
                'status'                => false,
            ]);
        }
    }

    public function show(Client $client)
    {
    }


    public function edit(Client $client)
    {
    }



    public function updateDataClient(Request $request)
    {
        try {
            $check_id = $request->id;
            $data = Client::where("id", $check_id)->update([
                'name'                  => $request->name,
                'email'                 => $request->email,
                'password'              => $request->password,
                'forget_password_token' => $request->forget_password_token,
                'email_verify_token'    => $request->email_verify_token,
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

    public function destroy(Request $request)
    {
        try {
            $data = Client::where("id", $request->id)->first();
            $data->delete();
            return response()->json([
                'status' => true,
                'message' => "Xóa thành công!",
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Xóa thất bại!',
            ]);
        }
    }

    public function login(Request $request)
    {
        $check = Auth::guard('client')->attempt(['email' => $request->email, 'password' => $request->password]);
        if ($check == true) {
            $user = Auth::guard('client')->user();
            return response()->json([
                'message'    => 'Đăng nhập thành công',
                'status'     => true,
                'token'      => $user->createToken('api-token')->plainTextToken,
            ]);
        } else {
            return response()->json([
                'status'     =>   false,
                'message'    =>   'Đăng nhập thất bại',
            ]);
        }
    }

    public function check(){
        $user = Auth::guard('sanctum')->user();

        try {
            if($user){
                return response()->json([
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => true
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'err' => $th,
                'status' => false
            ]);
        }
    }
}
