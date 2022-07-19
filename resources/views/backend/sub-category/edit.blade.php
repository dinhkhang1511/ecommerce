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
        <div class="card card-body">
            <h3 class="box-title m-b-0 mb-3">Edit Sub Category</h3>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <form action="{{ route('sub-categories.update', ['sub_category' => $subCategory->id]) }}" method="post">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label>Sub Category Name</label>
                            <input type="text" class="form-control" placeholder="Enter Name" 
                            name="name" value="{{ old('name', $subCategory->name) }}" autocomplete="off">
                            @error('name') 
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <h5 class="m-t-30">Select Category</h5>
                            <select class="custom-select" name="category_id">
                                <option selected value="">Select category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        @if(old('name', $subCategory->category_id) == $category->id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') 
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-danger"> <i class="fa fa-pencil"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
