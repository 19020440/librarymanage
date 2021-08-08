<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function index(Request $request)
    {
        request()->validate([
            'file'  => 'required|max:20480',
        ]);
        if ($files = $request->file('file')) {
            //store file into document folder
            $file = $request->file->store('public/images');
            $ext = pathinfo($file, PATHINFO_EXTENSION);

            $file2 = md5(basename($file)) . ".$ext";
            $oldFile =   base_path() . "/storage/app/" . $file;
            $newFile =   base_path() . "/storage/app/public/images/" . $file2;
            rename($oldFile, $newFile);
            return Response()->json([
                "success" => true,
                "url" => url("/storage/images/" . baseName($newFile)),
                "fileName" => basename($file2),
                "fileUrl" => url("/storage/images/" . baseName($newFile))
            ]);
        }

        return Response()->json([
            "success" => false,
            "file" => ''
        ]);
    }
}
