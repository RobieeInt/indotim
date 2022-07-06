<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;

class CropImageController extends Controller
{
     public function index()
    {
        return view('crop-image-upload');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function uploadCropImage(Request $request)
    {
        $message = [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'name.required' => 'Nama harus diisi',
            'name.regex' => 'Nama Harus Huruf',
            'image.required' => 'Foto harus diisi',
        ];
        $this->validate($request, [
            'email' => 'required|email',
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'image' => 'required',
        ], $message);
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
