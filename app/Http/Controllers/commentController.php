<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class commentController extends Controller
{
    public static function create(Request $request){
        $request->validate([
            "post_id" => "require|integer",
            "comment" => "require|string|max:1000",
        ]);
    }
}
