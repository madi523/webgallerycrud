@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <h2 class="card-header w-100 m-1 text-center">Update Image</h2>
    </div>
    <div class="row justify-content-center">
        <form class="m-2" method="post" action="{{ route('image.update', $image->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">File Name</label>
                <input type="text" class="form-control" id="title" value="{{ $image->title }}" name="title">
            </div>
             <div class="form-group">
                <label for="name">Description</label>
                <textarea type="text" class="form-control" id="description" name="description">{{ $image->description }}</textarea> 
            </div>
            <div class="form-group">
                <label for="name">Category</label>
                <select class="form-control" id="category" name="category">
                	<option selected value="{{ $categoryId->id }}">{{ $categoryId->category }}</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                    @endforeach
                </select>
            </div>
             <div class="form-group">
                <img src="{{ asset('/storage/'.$image->url) }}">
            </div>
            <div class="form-group">
                <label for="image">Choose Image</label>
                <input id="image" type="file" name="image">
            </div>
            <button type="submit" class="btn btn-dark d-block w-75 mx-auto">Update</button>
        </form>
    </div>
    <div class="row justify-content-center">
        <a class="btn btn-dark" href="/adminPanel">go to Admin Panel</a>
    </div>
    
</div>
@endsection