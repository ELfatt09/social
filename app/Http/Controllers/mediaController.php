<?php

namespace App\Http\Controllers;

use App\Models\media;
use Illuminate\Support\Facades\Storage;

class mediaController extends Controller
{
    public static function store($file, $foreignKey, $foreignKeyValue){
        $filename = time().'_'.$file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $filename, 'public');

        Media::create([
            $foreignKey => $foreignKeyValue,
                'file_type' => $file->getClientOriginalExtension(),
                'file_name' => $filename,
                'file_path' => '/storage/'.$filePath,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
    }
    public static function update($file, $foreignKey, $foreignKeyValue){
        Media::updateOrCreate(
            [$foreignKey => $foreignKeyValue],
            [
                'file_type' => $file->getClientOriginalExtension(),
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $file->store('uploads', 'public'),
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]
        );
    }
    public static function delete($file){
    Storage::disk('public')->delete(str_replace('/storage/', '', $file->file_path));
}
}
