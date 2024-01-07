<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CountryController extends Controller
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
            Country::create([
                'name'                  => $request -> name,
            ]);
            return response()-> json([
                'message'           => 'thanh cong',
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
        $data = Country::get();
        return response()->json([
            'create_countries_table'   => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
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
            $data = Country::where("id", $check_id)->update([
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
    public function destroy(Country $id){
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
}
