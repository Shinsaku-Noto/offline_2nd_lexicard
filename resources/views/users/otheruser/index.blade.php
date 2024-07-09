@extends('layouts.app')

@section('title', 'other user category list')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-10 m-auto">
            {{-- sort --}}
            <div class="my-5">
                <p class="bg-second text-yellow text-center p-2 fs-4">Sort</p>
                <div class="row justify-content-evenly">
                    <div class="col-5">
                        <button type="submit" name="liked" class="btn btn-outline-second border rounded-4 mt-4 fs-5 w-100 text-second">Most Liked</button>
                    </div>
                    <div class="col-5">
                        <button type="submit" name="recent" class="btn btn-outline-second border rounded-4 mt-4 fs-5 w-100 text-second">Recently Added</button>
                    </div>
                </div>
                <div class="row justify-content-evenly">
                    <div class="col-5">
                        <form action="#" method="post" class="my-3">
                            @csrf
                            @method('GET')
                            <p class="text-second">Search from Username</p>
                            <div class="input-group my-2">
                                <input type="text" name="word" class="form-control rounded-start-4 p-2">
                                <button class="btn btn-search rounded-end-4" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-5">
                        <form action="#" method="post" class="my-3">
                            @csrf
                            @method('GET')
                            <p class="text-second">Search from Category name</p>
                            <div class="input-group my-2">
                                <input type="text" name="word" class="form-control rounded-start-4 p-2">
                                <button class="btn btn-search rounded-end-4" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="my-5">
            {{-- category list --}}
            @foreach($categories as $category)
                <div class="row bg-yellow border rounded-4 p-3 mx-2 my-3 align-items-center">
                    <div class="col-4">
                        {{-- if the category is from other user, it will display avatar and username --}}
                        <a href="{{ route('profile.profile.show', $category->user->id) }}" class="text-second fs-5 text-decoration-none"><i class="fa-solid fa-circle-user fs-3"></i> {{ $category->user->name }}</a>
                    </div>
                    <div class="col-4 text-center">
                        <a href="{{ route('category.category.show', $category) }}" class="text-second text-decoration-none fw-bold fs-3">{{ $category->name }}</a>
                    </div>
                    <div class="col-2 justify-content-end d-flex align-items-center">
                        @if($category->isliked())
                            <form action="{{ route('like.destroy', $category->id) }}" method="post" class="mb-0 me-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn p-0 text-danger"><i class="fa-solid fa-heart"></i></button>
                            </form>
                        @else
                            <form action="{{ route('like.store') }}" method="post" class="mb-0 me-2">
                                @csrf
                                <input type="hidden" value="{{ $category->id }}" name="category_id">
                                <button type="submit" class="btn p-0 text-second"><i class="fa-regular fa-heart"></i></button>
                            </form>
                        @endif
                        <p class="text-second">{{ $category->like->count() }}</p>
                    </div>
                    <div class="col-2 justify-content-end d-flex align-items-center">
                        <p class="text-second text-end ms-3">{{ $category->categoryWord->count() }}  Words</p>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
