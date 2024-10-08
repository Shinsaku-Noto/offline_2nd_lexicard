@extends('layouts.app')

@section('content')
<div class="container">
    <div class="p-2 border rounded-3 mx-3">
        <div class="row">
            <div class="col-6">
                @if ($classroom->image)
                    <img src="{{ $classroom->image }}" alt="" class="w-100 logo-xl">
                @else
                    <img src="{{ asset('images/classroom.jpg') }}" alt="" class="w-100 logo-xl">
                @endif
            </div>
            <div class="col-6 p-4">
                <h1 class="text-second fs-2">
                    {{ $classroom->name }}
                    @if($classroom->status_id == 1)
                        <i class="fa-solid fa-unlock"></i>
                    @else
                        <i class="fa-solid fa-lock"></i>
                    @endif
                </h1>
                <p class="text-second">{{ $classroom->userClassroom->count() }} students</p>
                <p class="text-second fs-5 pb-5 mt-3 h-50">{{ $classroom->description }}</p>
                @if($classroom->isJoined())
                    <form action="{{ route('classroom.leave', $classroom->id) }}" method="post" class="text-center">
                        @csrf
                        @method('GET')
                        <button type="submit" class="btn btn-yellow w-50 text-center p-2 border border-second rounded-4 my-3">Leave</button>
                    </form>
                @else
                    @if($classroom->status_id == 1)
                        <form action="{{ route('classroom.join', $classroom->id) }}" method="post" class="text-center">
                            @csrf
                            @method('GET')
                            <button type="submit" class="btn btn-yellow w-50 text-center p-2 border border-second rounded-4 my-3">Join</button>
                        </form>
                    @else
                        @if($classroom->isWaiting())
                            <form action="{{ route('classroom.apply.cancel', $classroom->id) }}" method="post" class="text-center">
                                @csrf
                                @method('GET')
                                <button type="submit" class="btn btn-yellow w-50 text-center p-2 border border-second rounded-4 my-3">Requested</button>
                            </form>
                        @else
                            <form action="{{ route('classroom.apply', $classroom->id) }}" method="post" class="text-center">
                                @csrf
                                @method('GET')
                                <button type="submit" class="btn btn-yellow w-50 text-center p-2 border border-second rounded-4 my-3">Apply</button>
                            </form>
                        @endif
                    @endif
                @endif
            </div>
        </div>
    </div>


    <div class="row">
    {{-- category list --}}
        <div class="col-8">
            @if(isset($categories))
                @forelse($categories as $category)
                    <div class="row bg-yellow border rounded-4 p-3 mx-2 my-3 align-items-center">
                        <div class="col-4">
                        </div>
                        <div class="col-4 text-center">
                            <a href="{{ route('classroom.category', $category->id) }}" class="text-second text-decoration-none fw-bold fs-3">{{ $category->name }}</a>
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
                @empty
                    <p class="text-second text-center p-5">No categories</p>
                @endforelse
            @else
                @forelse($classroom->categories as $category)
                    <div class="row bg-yellow border rounded-4 p-3 mx-2 my-3 align-items-center">
                        <div class="col-4">
                        </div>
                        <div class="col-4 text-center">
                            @if($classroom->isJoined() || $classroom->status_id == 1)
                                <a href="{{ route('classroom.category', $category->id) }}" class="text-second text-decoration-none fw-bold fs-3">{{ $category->name }}</a>
                            @else
                                <p class="text-second text-decoration-none fw-bold fs-3">{{ $category->name }}</p>
                            @endif
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
                @empty
                    <p class="text-second text-center p-5">No categories yet.</p>
                @endforelse
            @endif
        </div>
        {{-- side bar --}}
        <div class="col-4">
            @if($classroom->isJoined() || $classroom->status_id == 1)
                {{-- Quiz --}}
                <a href="{{ route('classroom.quiz.index', $classroom->id) }}" class="btn btn-yellow w-100 p-3 fs-5 border border-second rounded-4 my-3">
                    Quiz
                </a>
                {{-- Sort Category --}}
                <div class="my-3 border border-second text-center">
                    <p class="bg-second text-yellow fs-3 p-2">Sort</p>
                    <ul class="list-unstyled">
                        <a href="{{ route('classroom.classroom.show', $classroom->id) }}" class="btn border rounded-4 mt-4 fs-5 w-75 text-second {{ \Route::is('classroom.classroom.show')?'btn-yellow':'btn-outline-second' }}">All</a>
                        <a href="{{ route('classroom.liked', $classroom->id) }}" class="btn border rounded-4 mt-4 fs-5 w-75 text-second {{ \Route::is('classroom.liked')?'btn-yellow':'btn-outline-second' }}">Liked</a>
                        <a href="{{ route('classroom.popular', $classroom->id) }}" class="btn border rounded-4 mt-4 fs-5 w-75 text-second {{ \Route::is('classroom.popular')?'btn-yellow':'btn-outline-second' }}">Popular</a>
                    </ul>
                </div>
            @endif
            {{-- Admin --}}
            <button type="button" class="btn btn-yellow w-100 p-3 fs-5 border border-second rounded-4 my-3" data-bs-toggle="modal" data-bs-target="#adminPasswordModal-{{ $classroom->id }}">
                Admin
            </button>
            @if(isset($error))
                <p class="text-danger text-center">{{ $error }}</p>
            @endif
        </div>

    </div>



</div>

{{-- Admin Password Modal --}}
<div class="modal fade" id="adminPasswordModal-{{ $classroom->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header justify-content-center">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Enter the Password</h1>
        </div>
        <div class="modal-body">
          <form action="{{ route('classroom.admin.index', $classroom->id) }}" method="post" class="w-75 m-auto">
            @csrf
            @method('GET')
            <input type="text" name="password" class="form-control my-4" required>
            <div class="row justify-content-between my-4">
                <div class="col-5">
                    <button type="button" class="btn btn-cancel w-100" data-bs-dismiss="modal">Close</button>
                </div>
                <div class="col-5">
                    <button type="submit" class="btn btn-yellow w-100">Submit</button>
                </div>
            </div>
          </form>

        </div>
      </div>
    </div>
</div>

@endsection
