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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Stichoza\GoogleTranslate\GoogleTranslate;

class MovieController extends Controller
{
    public function data()
    {
        $data = Movie::join('languages', 'movies.id_language_original', 'languages.id')
            ->join('countries', 'countries.id', 'movies.id_contries')
            ->join('employees', 'employees.id', 'movies.id_user_upload')
            ->join('images', 'images.id', 'movies.id_image')
            ->join('authors', 'authors.id', 'movies.id_author')
            ->select(
                'movies.id',
                'movies.description',
                'movies.original_name',
                DB::raw('CONCAT("' . env('APP_URL') . '", images.url) as url'),
                'authors.name as author_name',
                'countries.name as country_name',
                'employees.name as user_name',
                'languages.name as language_name',
                DB::raw("DATE_FORMAT(movies.date, '%d/%m/%Y') as date")
            )->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        try {
            $image = Image::create([
                'url' => $request->filename
            ]);

            Movie::create([
                'original_name' => $request->original_name,
                'vietnamese_name' => $this->translateToVietnamese($request->original_name),
                'id_image' => $image->id,
                'description' => $request->description,
                'rating' => 0,
                'id_contries' => $request->id_contries,
                'id_author' => $request->id_author,
                'id_user_upload' => $request->id_user_upload,
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

    public function translateToVietnamese($text)
    {
        $translator = new GoogleTranslate('vi'); // Đặt ngôn ngữ đích là tiếng Việt

        // Dịch văn bản từ tiếng Anh sang tiếng Việt
        return $translator->translate($text);
    }
}
