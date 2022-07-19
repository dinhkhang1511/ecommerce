@extends('layouts.backend.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Categories</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Categories Table</h4>
                <div class="table-responsive">
                    <a href="{{ url('excel/categories') }}">
                        <button type="button" class="btn btn-primary mb-3">EXCEL</button>
                    </a>
                    <div class="form-group">
                        <input type="text" class="form-control" id="search" placeholder="Type to search" autofocus>
                    </div>
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Category Name</th>
                                <th>Category Image</th>
                                <th class="text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                   <img src="{{ $category->image_path }}" width="100" height="100" class="of-cover">
                                </td>
                                <td>
                                    <a href="{{ route('categories.edit', ['category' => $category->id ]) }}" 
                                        data-toggle="tooltip" data-original-title="Edit"> 
                                        <i class="fa fa-pencil text-inverse m-r-10"></i> 
                                    </a>
                                    <form action="{{ route('categories.destroy', ['category' => $category->id ]) }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn-none" type="submit" data-toggle="tooltip" data-original-title="Delete"> 
                                            <i class="fa fa-close text-danger"></i> 
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
