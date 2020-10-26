<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Image;
use App\Category;
use App\Tag;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::all();
        return view('adminPanel', ['images'=>$images]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories = Category::all();
        return view('create', ['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         if ($request->hasFile('image')) {
            //  Let's do everything here
            if ($request->file('image')->isValid()) {
                //
                $validated = $request->validate([
                    'title' => 'string|max:40',
                    'image' => 'mimes:jpeg,png|max:1014',
                ]);
                $extension = $request->image->extension();
                $request->image->storeAs('/public', $validated['title'].".".$extension);
                $url = $validated['title'].".".$extension;
                $image = Image::create([
                   'title' => $validated['title'],
                    'url' => $url,
                    'description' => $request->get('description'),
                    'categoryId' => $request->get('category'),
                ]);
                Session::flash('success', "Success!");
                return \Redirect::back();
            }
        }
        abort(500, 'Could not upload image :('); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $image = Image::find($id);
        $categoryId = $image->categoryId;
        $categoryId = Category::find($categoryId);
        $categories = Category::all();
        return view('/edit', compact('image', 'categoryId', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        if ($request->hasFile('image')) {
            
            if ($request->file('image')->isValid()) {
                //
                $validated = $request->validate([
                    'title' => 'string|max:40',
                    'image' => 'mimes:jpeg,png|max:1014',
                ]);
                $imageOld = Image::find($id);
                $urlOld = $imageOld->url;
                unlink('../storage/app/public/'.$urlOld);
                $extension = $request->image->extension();
                $request->image->storeAs('/public', $validated['title'].".".$extension);
                $url = $validated['title'].".".$extension;
                $update = ['title' => $request->title, 'url' => $url,'description' => $request->description, 'categoryId' => $request->category,];
                Image::where('id',$id)->update($update);
                return redirect('adminPanel')->with('success', 'Image updated!');
            }
        } 
        $update = ['title' => $request->title, 'description' => $request->description, 'categoryId' => $request->category,];
        Image::where('id',$id)->update($update);

        return redirect('adminPanel')->with('success', 'Image updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::find($id);
        $url = $image->url;
        
        if(file_exists('../storage/app/public/'.$url)){
            unlink('../storage/app/public/'.$url);
            $image->delete();
            return redirect('adminPanel')->with('success', 'Image deleted!');
            
        }else{
            return view('adminPanel')->with('not found image');
        }
        
        
    }
}
