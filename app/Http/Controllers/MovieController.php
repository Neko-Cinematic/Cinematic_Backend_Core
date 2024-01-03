<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Controllers\Controller;
use App\Models\Actor;
use App\Models\ActorRel;
use App\Models\Author;
use App\Models\Country;
use App\Models\Episode;
use App\Models\Image;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    public function data()
    {
        $data = Movie::join("languages", "id_language_original", "languages.id")
            ->select(
                "name",
                "movies.*"
            )->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {
            $movie = Movie::create([
                'original_name' => $request->original_name,
                'vietnamese_name' => $request->vietnamese_name,
                'id_image' => $request->id_image,
                'description' => $request->description,
                'rating' => 0,
                'id_contries' => $request->id_contries,
                'id_author' => $request->id_author,
                'id_user_upload' => 1,
                'id_language_original' => $request->id_language_original,
                'date' => $request->date,
                'views' => 0,
            ]);
            return response()->json([
                'status' => true,
                'message' => "Tạo mới thành công!",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Tạo mới không thành công!",
                'err' => $th
            ]);
        }
    }

    public function update(Request $request)
    {
        try {
            $movie = Movie::where("id", $request->id)->update([
                'original_name' => $request->original_name,
                'vietnamese_name' => $request->vietnamese_name,
                'id_image' => $request->id_image,
                'description' => $request->description,
                'id_contries' => $request->id_contries,
                'id_author' => $request->id_author,
                'id_language_original' => $request->id_language_original,
                'date' => $request->date,
            ]);

            return response()->json([
                'status' => true,
                'message' => "Cập nhật thành công!",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Cập nhật không thành công!",
                'err' => $th
            ]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = Movie::where("id", $request->id)->first();
            $data->delete();
            return response()->json([
                'status' => true,
                'message' => "Xóa thành công!",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Xóa không thành công!",
                'err' => $th
            ]);
        }
    }
}
