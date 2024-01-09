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
use App\Models\TypeRel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\File;

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
                'movies.*',
                DB::raw('CONCAT("' . env('APP_URL') . '", images.url) as url'),
                'authors.name as author_name',
                'countries.name as country_name',
                'employees.name as user_name',
                'languages.name as language_name',
                DB::raw("DATE_FORMAT(movies.date, '%d/%m/%Y') as date")
            )->get();

        foreach ($data as $movie) {
            $movie['list_type'] = '';
            $movie['list_actor'] = '';
            $list_type = TypeRel::join('types', 'type_rels.id_type', 'types.id')
                ->where('type_rels.id_movie', $movie->id)->select('types.name')->get();
            if ($list_type !== null) {
                foreach ($list_type as $type) $movie['list_type'] .= $type->name . ',';
            }
            $list_actor = ActorRel::join('actors', 'actors.id', 'actor_rels.id_actor')
                ->where('actor_rels.id_movie', $movie->id)
                ->select('actors.name')->get();
            if ($list_actor !== null) {
                foreach ($list_actor as $actor) $movie['list_actor'] .= $actor->name . ',';
            }
            $movie['list_type'] = rtrim($movie['list_type'], ',');
            $movie['list_actor'] = rtrim($movie['list_actor'], ',');
        }
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        try {
            $image = Image::create([
                'url' => $request->filename
            ]);

            $movie = Movie::create([
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

            $list_actor_rels = ActorRel::where('id_movie', 0)->get();
            $list_type_rels = TypeRel::where('id_movie', 0)->get();

            foreach ($list_type_rels as $type) {
                $type->update(['id_movie' => $movie->id]);
            }

            foreach ($list_actor_rels as $actor) {
                $actor->update(['id_movie' => $movie->id]);
            }

            return response()->json([
                'status'    => true,
                'message'   => "Tạo mới thành công!",
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
            $image = Image::where('id', $request->id_image)->first();
            $arr = explode('/', $image->url);
            if (Storage::disk('public/images')->exists($arr[2])) {
                return response()->json('Có');
                Storage::disk('public/images')->delete($arr[2]);
            }
            // $image->delete();
            // Movie::where("id", $request->id)->delete();
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
