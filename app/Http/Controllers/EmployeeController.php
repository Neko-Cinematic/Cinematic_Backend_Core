<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
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
            Employee::create([
                'name'              => $request -> name,
                'email'             => $request -> email,
                'password'          => $request -> nampassworde,
                'id_permissons'     => $request -> id_permissons,
            ]);
            return response()->json([
                'status'  => true,
                'message' => "Tạo mới nhân viên thành công",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => "Tạo mới nhân viên thất bại",
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getData()
    {
        $data = Employee::get();
        return response()->json([
            'create_employees_table'   => $data,
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateDataEmployee(Request $request)
    {
        try {
            $check_id = $request->id;
            $data = Employee::where("id", $check_id)->update([
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
    public function destroy(Employee $id){
        try {
            Employee::where('id',$id)->delete();
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
}
