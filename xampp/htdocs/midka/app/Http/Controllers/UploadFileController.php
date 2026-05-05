<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    
    public function showUploadFile(Request $request) {
   $file = $request->file('image'); 
   
   $destinationPath = 'uploads';
   $file->move($destinationPath, $file->getClientOriginalName());
   
   return "Файл успешно загружен в папку public/uploads!";
}
}
