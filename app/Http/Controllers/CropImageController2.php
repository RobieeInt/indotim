<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CropImageController2 extends Controller
{
    public function getdata() {
        if(request()->ajax()) {
            $data = Picture::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('crop-image-upload2');
    }
    public function index()
    {
       if(request()->ajax()) {
        $query = Picture::query();

        return DataTables::of($query)
            ->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('crop-image-upload2');

    }



    /**
     * Write code on Method
     *
     * @return response()
     */
    public function uploadCropImage(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'name' => 'required',
        ]);
        $folderPath = public_path('upload/');

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $imageName = uniqid() . '.png';

        $imageFullPath = $folderPath.$imageName;

        file_put_contents($imageFullPath, $image_base64);



        $saveFile = Picture::create([
            'email' => $request->email,
            'name' => $request->name,
            'status' => 'active',
            'path' => $imageName,
        ]);

        //  $saveFile = new Picture;
        //  $saveFile->path = $imageName;
        //  $saveFile->save();

        return response()->json(['success'=>'Data Berhasil Tersimpan']);
    }
}
