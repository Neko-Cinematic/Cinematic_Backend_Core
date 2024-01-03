<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    public function data()
    {
        $data = Actor::select()->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {
            Actor::create([
                'name' => $request->name,
                'id_image' => $request->id_image,
            ]);
            return response()->json([
                'status' => true,
                'message' => "Tạo mới thành công!",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Tạo mới không thành công!",
            ]);
        }
    }

    public function update(Request $request)
    {
        try {
            $check_id = $request->id;
            $data = Actor::where("id", $check_id)->update([
                'name' => $request->name,
                'id_image' => $request->id_image,
            ]);
            return response()->json([
                'status' => true,
                'message' => "Cập nhật thành công!",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Cập nhật không thành công!",
            ]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = Actor::where("id", $request->id)->first();
            $data->delete();
            return response()->json([
                'status' => true,
                'message' => "Xóa thành công!",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Xóa không thành công!",
            ]);
        }
    }
}
