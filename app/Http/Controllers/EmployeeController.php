<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    public function login(Request $request)
    {
        $check = Auth::guard('employee')->attempt(['email' => $request->email, 'password' => $request->password]);
        if ($check == true) {
            $user = Auth::guard('employee')->user();
            return response()->json([
                'message'    => 'Đăng nhập thành công',
                'status'     => true,
                'token'      => $user->createToken('api-token-employee')->plainTextToken,
            ]);
        } else {
            return response()->json([
                'status'     =>   false,
                'message'    =>   'Đăng nhập thất bại',
                'email' => $request->email,
                'pass' => $request->password,
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
