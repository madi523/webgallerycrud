@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <h2 class="card-header w-100 m-1 text-center">Create new Image</h2>
    </div>
    <div class="row justify-content-center">
        <form class="m-2" method="post" action="{{ route('image.store') }}" enctype="multipart/form-data">
            @csrf   
            <div class="form-group">
                <label for="name">File Name</label>
                <input type="text" class="form-control" id="title" placeholder="Enter file Name" name="title">
            </div>
             <div class="form-group">
                <label for="name">Description</label>
                <textarea type="text" class="form-control" id="description" placeholder="Enter file Name" name="description"></textarea> 
            </div>
            <div class="form-group">
                <label for="name">Category</label>
                <select class="form-control" id="category" name="category">
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="image">Choose Image</label>
                <input id="image" type="file" name="image">
            </div>
            <button type="submit" class="btn btn-dark d-block w-75 mx-auto">Upload</button>
        </form>
    </div>
    <div class="row justify-content-center">
        <a class="btn btn-dark" href="/adminPanel">go to Admin Panel</a>
    </div>
    
</div>
@endsection
