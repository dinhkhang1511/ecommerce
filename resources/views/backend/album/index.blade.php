@extends('layouts.backend.app')
@section('css')
    <link href="{{ asset('backend/lightbox/css/lightbox.css') }}" rel="stylesheet" />
@endsection
@section('script')
    <script src="{{ asset('backend/lightbox/js/lightbox.js') }}"></script>
    <script>
        lightbox.option({
            'resizeDuration': 10,
            'wrapAround': true,
            'disableScrolling': true
        })

    </script>
@endsection
@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Albums</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Albums</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-body">
                <h3 class="box-title m-b-0 mb-3">New Albums</h3>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <form action="{{ url('albums-images') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Album Title</label>
                                <input type="text" class="form-control" placeholder="Enter Title" required name="title"
                                    value="{{ old('title') }}" autocomplete="off">
                                @error('title')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description"
                                    rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Images (maximum 6 files)</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="images[]" multiple
                                            accept="image/*">
                                        <label class="custom-file-label">Choose images</label>
                                    </div>
                                </div>
                                @error('images')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                                @if ($errors->any())
                                    <div class="error">Please choose images again</div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @foreach ($albums as $item)
                @foreach ($item->images as $index => $image)
                    @if ($index == 0)
                        <div class="col-3 card">
                            <a href="/{{ $image->path }}" data-lightbox="album{{ $item->id }}">
                                <img src="/{{ $image->path }}" class="card-img-top album-image">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->title }}</h5>
                                <p class="card-text">{{ $item->description }}</p>
                                <div class="d-flex">
                                    @if ($item->display == 1)
                                        <form action="albums-images/{{ $item->id }}/un-display" method="post"
                                            class="mr-2">
                                            @method('patch')
                                            @csrf
                                            <button class="btn btn-success">Display <i class="fas fa-check"></i></button>
                                        </form>
                                    @else
                                        <form action="albums-images/{{ $item->id }}/display" method="post"
                                            class="mr-2">
                                            @method('patch')
                                            @csrf
                                            <button class="btn btn-success">Display</button>
                                        </form>
                                    @endif
                                    <form action="albums-images/{{ $item->id }}/delete" method="post">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="/{{ $image->path }}" data-lightbox="album{{ $item->id }}"></a>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
@endsection
