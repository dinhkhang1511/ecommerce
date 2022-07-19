@extends('layouts.backend.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">System Setting</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">System Setting</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-body">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <form action="{{ route('system-setting.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{-- <div class="form-group">
                            <label>Favicon</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('favicon') is-invalid @enderror" name="favicon" accept="image/*">
                                    <label class="custom-file-label">Choose image</label>
                                </div>
                            </div>
                            @error('favicon') 
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Logo</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('logo') is-invalid @enderror" name="logo" accept="image/*">
                                    <label class="custom-file-label">Choose image</label>
                                </div>
                            </div>
                            @error('logo') 
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="form-group">
                            <label>Shop Name</label>
                            <input type="text" class="form-control" placeholder="Enter Name" 
                            name="shop_name" value="{{ $setting->shop_name }}" autocomplete="off">
                            @error('shop_name') 
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Site Title</label>
                            <input type="text" class="form-control" placeholder="Enter Title" 
                            name="site_title" value="{{ $setting->site_title }}" autocomplete="off">
                            @error('site_title') 
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Copyright Text</label>
                            <input type="text" class="form-control" placeholder="Enter Copyright Text" 
                            name="copyright_text" value="{{ $setting->copyright_text }}" autocomplete="off">
                            @error('copyright_text') 
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" placeholder="Enter Phone" 
                            name="phone" value="{{ $setting->phone }}" autocomplete="off">
                            @error('phone') 
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" placeholder="Enter Address" 
                            name="address" value="{{ $setting->address }}" autocomplete="off">
                            @error('address') 
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <p>Province</p>
                            <select class="custom-select" name="province_id" id="province">
                                <option selected>Select Province</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}" 
                                        @if($province->id == $setting->province_id) selected @endif>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('province_id') 
                                <div class="error error-nice-select">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <p>District</p>
                            <select class="custom-select" name="district_id" id="district">
                                @if ($setting->province_id != null)
                                    @foreach ($setting->province->load('districts')->districts as $district)
                                        <option value="{{ $district->id }}" 
                                            @if($district->id == $setting->district_id) selected @endif>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option selected>Select District</option>
                                @endif
                            </select>
                            @error('district_id') 
                                <div class="error error-nice-select">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <p>Ward</p>
                            <select class="custom-select" name="ward_id" id="ward">
                                @if ($setting->district_id != null)
                                    @foreach ($setting->district->load('wards')->wards as $ward)
                                        <option value="{{ $ward->id }}" 
                                            @if($ward->id == $setting->ward_id) selected @endif>
                                            {{ $ward->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option selected>Select Ward</option>
                                @endif
                            </select>
                            @error('ward_id') 
                                <div class="error error-nice-select">{{ $message }}</div>
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
