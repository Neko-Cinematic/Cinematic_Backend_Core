<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    public function data(Request $request)
    {
        $data = Episode::where('id_movies', $request->id_movie)->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        Episode::create([
            'num_eps'   => $request->num_eps,
            'id_movies' => $request->id_movie,
            'url'       => $request->filename,
        ]);
        return response()->json([
            'status' => 1,
            'message' => 'Tạo mới thành công!'
        ]);
    }

    public function update(Request $request)
    {
        try {
            Episode::where("id", $request->id)->update([
                'num_eps' => $request->num_eps,
                'id_movies' => $request->id_movies,
                'url' => $request->url,
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
            $data = Episode::where("id", $request->id)->first();
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
