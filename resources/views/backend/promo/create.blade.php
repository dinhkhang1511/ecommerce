@extends('layouts.backend.app')
@section('content')
@php $errors = session('errors', []);@endphp
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Promos</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Promos</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-body">
            <h3 class="box-title m-b-0 mb-3">New Promo</h3>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <form action="{{ route('promos.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Promo Discount (%)</label>
                            <input type="number" class="form-control" placeholder="Enter Discount" required
                            name="discount" value="{{ old('discount', 0) }}" autocomplete="off">
                            @if(isset($errors->discount))
                                @foreach($errors->discount as $error)
                                    <div class="error">{{$error}}</div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Promo Code</label>
                            <input type="text" class="form-control" placeholder="Enter Code" required
                            name="code" value="{{ old('code', '')}}" maxlength="10" size="10">
                            @if(isset($errors->code))
                                @foreach($errors->code as $error)
                                    <div class="error">{{$error}}</div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Promo Description</label>
                            <textarea class="form-control" name="description" rows="3" required>{{ old('description') }}</textarea>
                            @if(isset($errors->description))
                                @foreach($errors->description as $error)
                                    <div class="error">{{$error}}</div>
                                @endforeach
                            @endif
                        </div>

                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
