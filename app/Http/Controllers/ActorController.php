<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Http\Controllers\Controller;
use App\Models\ActorRel;
use App\Models\Image;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActorController extends Controller
{
    public function data()
    {
        $data = Actor::join('images','actors.id_image' ,'images.id')
        ->select("actors.id", 'images.url', "actors.name")
        ->get();

        foreach($data as $actor) {
            $list = ActorRel::join('movies', 'movies.id', 'actor_rels.id_movie')
            ->where('actor_rels.id_actor', $actor->id)
            ->select('movies.vietnamese_name as name')->get();
            if(!$list) break;
            $actor['list_phim'] = '';
            foreach ($list as $value) {
                $actor['list_phim'] .= $value->name . ',';
            }
            $actor['list_phim'] = rtrim($actor['list_phim'], ',');
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {
            $image = Image::create([
                'url' => $request->url,
            ]);

               Actor::create([
                'name' => $request->name,
                'id_image' => $image->id,
            ]);
            return response()->json([
                'status' => true,
                'message' => "Tạo mới thành công!",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Tạo mới không thành công!",
                "err" => $th,
            ]);
        }

    }

    public function update(Request $request)
    {
        try {
         Actor::where('id', $request->id)->update([
                'name' => $request->name,
            ]);


            Image::where('id',$request->id)->update([
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
                'err' => $th
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
                'id' =>  $request->id,
                'err' => $th
             ]);
        }
    }
}
