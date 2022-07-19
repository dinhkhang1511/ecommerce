@extends('layouts.backend.app')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Dashboard</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Contact Message</h5>
                </div>
                <div class="comment-widgets">
                    @foreach ($contacts as $item)
                    <div class="d-flex no-block comment-row">
                        <div class="comment-text w-100">
                            <h5 class="font-medium">{{ $item->name }} - {{ $item->email }}</h5>
                            <p class="m-b-10 text-muted">{{ $item->message }}</p>
                            <div class="comment-footer">
                                <span class="text-muted pull-right ml-auto">{{ $item->created_at->format('d F, Y') }}</span> 
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            {{ $contacts->links() }}
        </div>
    </div>
@endsection
