<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DropController extends Controller
{
    public function drop()
    {
        $options = [
            'title' => 'Posts',
            
        ];
        return view('posts.drop', compact('options'));
    }
}
