@extends('layouts.app')

@section('content')
    <div class="col-6 mx-auto pt-5">
        <form action="{{ route('user.posts.store') }}" method="POST">
            @csrf
            <div class="media align-middle">
                <div>
                    <img src="https://i.ibb.co/8DF4DNM/Nuovo-progetto.png" class="mr-3 d-block" alt="...">
                    <div class="mt-3">
                        <p>Image URL:</p>
                        <input type="url" name="image" value="">
                    </div>
                </div>
                <div class="media-body">
                    <div>
                        <label for="title" class="mr-5 fs-5">Title:</label>
                        <input type="text" id="title" name="title" class="ml-5" value="">
                    </div>
                    <div class="formfield">
                        <label for="content" class="mr-3 fs-5">Post Content:</label>
                        <textarea name="content" id="content" cols="30" rows="10"></textarea>
                    </div>
                </div>

                <div class="media-body col-2">
                    <label for="category">Category</label>
                    <select name="category_id" id="category">
                        <option value="">Seleziona una Categoria...</option>
                        @foreach ($categories as $category)
                            <option value=" {{ $category->id }} ">
                                {{ $category->label }}</option>
                        @endforeach
                    </select>

                    <p class="pt-5">Tags:</p>
                    @foreach ($tags as $tag)
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" id="tag-{{ $tag->id }}"
                                value="{{ $tag->id }}" name="tags[]" @if (in_array($tag->id, old('tags', []))) checked @endif>
                            <label for="tag-{{ $tag->id }}" class="form-check-label"
                                style="color: {{ $tag->color }}">{{ $tag->label }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="pt-5 text-center">
                <button type="submit" class="btn btn-success fs-4">Save</button>
            </div>
        </form>
    </div>
@endsection
