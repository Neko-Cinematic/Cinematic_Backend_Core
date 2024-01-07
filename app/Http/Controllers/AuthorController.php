<?php //moi

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{

    public function index()
    {
        //
    }

    public function data()
    {
        $data = Author::join('images','images.id', 'authors.id_images')->select('images.url','authors.*')->get();
        return response()->json([
            'create_authors_table'   => $data,
        ]);
    }

    public function store(Request $request)
    {

        $img = Image::create([
            'url'            =>$request->url_avatar,
        ]);
        Author::create([
            'name'           => $request->name,
            'id_images'       => $img->id   ,
        ]);
        return response()->json([
            'status'            =>   true,
            'message'           =>   'Đã tạo mới tác giả thành công!',
        ]);

    }

    public function update(Request $request)
    {
        try {
            $check_id = $request->id;
            $data = Author::where("id", $check_id)->update([
                'name'      => $request->name,
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


    public function destroy(Request $request){
        try {
            Author::where('id',$request->id)->delete();
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
