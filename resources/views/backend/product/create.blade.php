@extends('layouts.backend.app')
@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Products</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Products</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-body">
                <h3 class="box-title m-b-0 mb-3">New Product</h3>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" class="form-control" placeholder="Enter Name" name="name"
                                    value="{{ old('name') }}" autocomplete="off">
                                @error('name')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div>
                                <label class="mb-3">Product Attributes</label>
                                <button type="button" class="btn btn-dark btn-sm" id="addAttribute">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div> --}}

                            <input type="hidden" value="{{ old('sizes') ? count(old('sizes', [])) : 1 }}"
                                id="currentAttribute">
                            <input type="hidden" value="{{ $sizes->count() * $colors->count() }}" id="maxOfAttribute">

                            @if (count(old('sizes', [])) > 0)
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="d-flex align-items-center mb-3">
                                            <p class="card-title m-0 mr-3">Products Attributes</p>
                                            <button type="button" class="btn btn-dark btn-sm" id="addAttribute">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="table">
                                                <thead>
                                                    <tr>
                                                        <th>Sizes</th>
                                                        <th>Colors</th>
                                                        <th>Quantity</th>
                                                        <th>Image</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="attributeWrapper">
                                                    @foreach (old('sizes') as $index => $item)
                                                    <tr>
                                                        <td>
                                                            <select class="custom-select" name="sizes[]">
                                                                <option selected value="">Sizes</option>
                                                                @foreach ($sizes as $size)
                                                                    <option value="{{ $size->id }}" @if ($size->id == $item) selected @endif>
                                                                        {{ $size->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="custom-select" name="colors[]">
                                                                <option selected value="">Colors</option>
                                                                @foreach ($colors as $color)
                                                                    <option value="{{ $color->id }}" @if ($color->id == old('colors')[$index]) selected @endif>
                                                                        {{ $color->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control"
                                                                placeholder="Enter Quantity" name="quantity[]" value="{{ old('quantity.' . $loop->index) }}">
                                                        </td>
                                                        <td>
                                                            <div class="custom-file">
                                                                <input type="file" multiple class="custom-file-input"
                                                                    name="images{{ $index }}[]" accept="image/*">
                                                                <label class="custom-file-label">Choose images</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button class="btn-none deleteAttribute" data-toggle="tooltip"
                                                                data-original-title="Delete">
                                                                <i class="fa fa-close text-danger"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="d-flex align-items-center mb-3">
                                            <p class="card-title m-0 mr-3">Products Attributes</p>
                                            <button type="button" class="btn btn-dark btn-sm" id="addAttribute">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="table">
                                                <thead>
                                                    <tr>
                                                        <th>Size</th>
                                                        <th>Color</th>
                                                        <th>Quantity</th>
                                                        <th>Image</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="attributeWrapper">
                                                    <tr>
                                                        <td>
                                                            <select class="custom-select" name="sizes[]">
                                                                <option selected value="">Sizes</option>
                                                                @foreach ($sizes as $size)
                                                                    <option value="{{ $size->id }}">
                                                                        {{ $size->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="custom-select" name="colors[]">
                                                                <option selected value="">Colors</option>
                                                                @foreach ($colors as $color)
                                                                    <option value="{{ $color->id }}">
                                                                        {{ $color->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control"
                                                                placeholder="Enter Quantity" name="quantity[]" value="">
                                                        </td>
                                                        <td>
                                                            <div class="custom-file">
                                                                <input type="file" multiple class="custom-file-input"
                                                                    name="images0[]" accept="image/*">
                                                                <label class="custom-file-label">Choose images</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button class="btn-none deleteAttribute" data-toggle="tooltip"
                                                                data-original-title="Delete">
                                                                <i class="fa fa-close text-danger"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="error">Please choose images again</div>
                            @endif
                            @error('sizes.*')
                                <div class="error">The size field is required.</div>
                            @enderror
                            @error('colors.*')
                                <div class="error">The size field is required.</div>
                            @enderror
                            @error('quantity.*')
                                <div class="error">The quantity field is required.</div>
                            @enderror


                            <div class="form-group">
                                <h5 class="m-t-30">Select Sub Category</h5>
                                <select class="custom-select" name="sub_category_id">
                                    <option selected value="">Select sub-category</option>
                                    @foreach ($subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}" @if ($subCategory->id == old('sub_category_id')) selected @endif>
                                            {{ $subCategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sub_category_id')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Product Price</label>
                                <input type="number" class="form-control" placeholder="Enter Price" name="price"
                                    value="{{ old('price') }}">
                                @error('price')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Discount (%)</label>
                                <input type="number" class="form-control" placeholder="Enter Discount" name="discount"
                                    value="{{ old('discount', 0) }}" min="0" max="100">
                                @error('discount')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea id="summernote" name="description">{!! old('description') !!}</textarea>
                            </div>

                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
