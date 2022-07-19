@extends('layouts.backend.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Sub Categories</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Sub Categories</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Sub Categories Table</h4>
                <div class="table-responsive">
                    <a href="{{ url('excel/sub-categories') }}">
                        <button type="button" class="btn btn-primary mb-3">EXCEL</button>
                    </a>
                    <div class="form-group">
                        <input type="text" class="form-control" id="search" placeholder="Type to search" autofocus>
                    </div>
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th class="text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subCategories as $subCategory)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $subCategory->name }}</td>
                                <td>{{ $subCategory->category->name }}</td>
                                <td>
                                    <a href="{{ route('sub-categories.edit', ['sub_category' => $subCategory->id ]) }}" 
                                        data-toggle="tooltip" data-original-title="Edit"> 
                                        <i class="fa fa-pencil text-inverse m-r-10"></i> 
                                    </a>
                                    <form action="{{ route('sub-categories.destroy', ['sub_category' => $subCategory->id ]) }}" method="post" class="d-inline">
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
                {{ $subCategories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
