@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <h1 class="mt-3 mb-3">Change</h1>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.posts.update', ['post' => $post->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="titolo">Title</label>
                        <input type="text" name="title" class="form-control" id="titolo" placeholder="Titolo post" value="{{ old('title', $post->title) }}">
                    </div>
                    <div class="form-group">
                        <label for="testo">Article</label>
                        <textarea type="text" name="content" class="form-control" id="testo" placeholder="Scrivi qualcosa...">{{ old('content', $post->content) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="img">Cover image</label>
                        <input type="file" name="image" class="form-control-file">
                        @if ( $post->cover_image)
                            <img src="{{ asset('storage/' . $post->cover_image)}}">
                            @else
                                <p>Image not available</p>
                        @endif

                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" class="form-control" name="category_id">
                            <option value="">Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id'), ($post->category->id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                    @foreach ($tags as $tag)
                        <div class="form-check">
                            <label class="form-check-label">
                                <input
                                @if ($errors->any())
                                    {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}

                                @else
                                    {{ $post->tags->contains($tag) ? 'checked' : ''}}

                                @endif

                                 type="checkbox" name="tags[]" value="{{ $tag->id}}" class="form-check-input">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
