@extends('layouts.backend.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Sizes</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Sizes</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-body">
            <h3 class="box-title m-b-0 mb-3">New Size</h3>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <form action="{{ route('sizes.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Size Name</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="name" value="{{ old('name') }}" autocomplete="off">
                            @error('name') 
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
