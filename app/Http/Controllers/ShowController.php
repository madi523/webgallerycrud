<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\Category;
use App\Tag;

class ShowController extends Controller
{
    public function index()
    {
        $images = Image::all();
        $categories = Category::all();
        $tags = Tag::all();
        return view('welcome', ['images'=>$images, 'categories'=>$categories, 'tags'=>$tags]);
    }
}
