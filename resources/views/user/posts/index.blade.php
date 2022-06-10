@extends('layouts.app')

@section('scripts')
    <script defer src="{{ asset('js/deleteForm.js') }}"></script>
@endsection

@section('content')
    @if (session('message-delete'))
        <div class="alert alert-success fs-5">
            <span>Il post</span>
            <span class="text-uppercase text-primary">{{ session('message-delete') }}</span>
            <span>è stato eliminato con successo</span>
        </div>
    @elseif(session('message-create'))
        <div class="alert alert-success fs-5">
            <span>Il post</span>
            <span class="text-uppercase text-primary">{{ session('message-create') }} </span>
            <span>è stato creato con successo</span>
        </div>
    @endif

    <div class="bg-dark">
        <div class="d-flex justify-content-between">
            <a href="{{ route('user.posts.create') }}" class="btn btn-success fs-5 my-3 ml-3">New Post</a>
            <form class="form-inline mr-3" method="GET" action="{{ route('user.posts.index') }}">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" name="title">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>

        @if ($posts->count() > 0)
            <table class="mb-0 pb-3 table table-hover table-dark">
                <thead class="table-head">
                    <tr>
                        <th scope="col">Author</th>
                        <th scope="col">Title</th>
                        <th scope="col">Content</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Category</th>
                        <th scope="col">Image</th>
                        <th scope="col">Tags</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr class="table-row">
                            <th scope="row">{{ $post->User->name }}</th>
                            <td>{{ $post->title }}</td>
                            <td class="col-3">{{ $post->content }}</td>
                            <td>{{ $post->slug }}</td>
                            <td class="col-1">
                                @if ($post->Category)
                                    <span class="badge badge-pill badge-{{ $post->Category->color }}"
                                        style="font-size: 1rem">{{ $post->Category->label }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td><img src="{{ $post->image }}" alt="" width="80px"></td>
                            <td>
                                @forelse ($post->Tags as $tag)
                                    <span class="badge"
                                        style="background-color: {{ $tag->color }}">{{ $tag->label }}</span>
                                @empty
                                    Non ci sono tag abbinati
                                @endforelse
                            </td>
                            <td class="col-2">
                                <a href="{{ route('user.posts.show', $post->id) }}" class="btn btn-primary mr-2">View</a>
                                <a href="{{ route('user.posts.edit', $post->id) }}" class="btn btn-warning mr-2">Edit</a>
                                <form action="{{ route('user.posts.destroy', $post->id) }}" method="POST"
                                    class="d-inline delete-form" data-name="{{ $post->title }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Delete" class="btn btn-danger">
                                </form>
                            </td>
                        </tr>
                    @empty
                        Non ci sono post!
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>
    <div class="bg-dark py-3 pl-5">
        @if ($posts->hasPages())
            {{ $posts->links() }}
        @endif
    </div>
@endsection
