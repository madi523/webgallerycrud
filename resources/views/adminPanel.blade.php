@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <h2 class="card-header w-100 m-1 text-center">Admin Panel</h2>
    </div>
    <div class="row justify-content-left m-2">
        <a class="btn btn-dark" href="{{ route('image.create') }}">Create</a>
    </div>
    <div class="row justify-content-center">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="cs-p-1">Name</th>
                    <th class="cs-p-1">Picture</th>
                    <th class="cs-p-1">Description</th>
                    <th class="cs-p-1">Operations</th>
                </tr>
            </thead>

            @foreach ($images as $image)
                <tr>
                    <td class="cs-p-1">{{ $image->title }}</td>
                    <td class="cs-p-1"><img class="small-image" style="width: 100px;" src="{{ asset('/storage/'.$image->url) }}"></td>
                    <td class="cs-p-1">{{ $image->description }}</td>
                    <td class="cs-p-1">
                        <a class="btn btn-dark" href="{{ route('image.edit', $image->id) }}">edit</a>
                        <form action="{{ route('image.destroy', $image->id)}}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger" type="submit">delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    
    
</div>
@endsection