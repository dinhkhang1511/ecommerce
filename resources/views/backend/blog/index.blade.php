@extends('layouts.backend.app')
@section('content')
@php
 $page = $data->meta->current_page;
@endphp
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Blogs</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Blogs</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Blogs Table</h4>
                <div class="table-responsive">
                    <div class="form-group">
                        <input type="text" class="form-control" id="search" placeholder="Type to search" autofocus>
                    </div>
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>Blog Title</th>
                                <th class="text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($data->blogs))
                            @foreach ($data->blogs as $blog)
                            <tr>
                                <td>{{ $blog->title }}</td>
                                <td>
                                    <a href="{{ route('blogs.show', ['blog' => $blog->id ]) }}"
                                        data-toggle="modal" data-target="#modelId{{$blog->id}}">
                                        <i class="fa fa-eye m-r-15" aria-hidden="true"></i>
                                    </a>
                                    <div class="modal fade" id="modelId{{$blog->id}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Blog Details</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="font-weight-bold">
                                                        @foreach ($blog->tags as $tag)
                                                            #{{ $tag->name }} &nbsp;
                                                        @endforeach
                                                    </div>
                                                    <div class="font-weight-bold mt-3">{{ $blog->title }}</div>
                                                    <div>{!! $blog->body !!}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('blogs.edit', ['blog' => $blog->id ]) }}"
                                        data-toggle="tooltip" data-original-title="Edit">
                                        <i class="fa fa-pencil text-inverse m-r-10"></i>
                                    </a>
                                    <form action="{{ route('blogs.destroy', ['blog' => $blog->id ]) }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn-none" type="submit" data-toggle="tooltip" data-original-title="Delete">
                                            <i class="fa fa-close text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <h3>Nothing to show</h3>
                            @endif
                        </tbody>
                    </table>
                </div>
                <nav aria-label="...">
                    <ul class="pagination">
                      <li class="page-item {{$page == '1' ? 'disabled' : ''}} ">
                        <a class="page-link" href="{{route('blogs.index')}}?page={{$page-1}}{{request('limit') ? '&limit='.request('limit') : ''}}" tabindex="-1">Previous</a>
                      </li>
                      <li class="page-item {{$page == $data->meta->last_page ? 'disabled' : ''}}" >
                        <a class="page-link" href="{{route('blogs.index')}}?page={{$page+1}}{{request('limit') ? '&limit='.request('limit') : ''}}" >Next</a>
                      </li>
                    </ul>
                  </nav>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"></script>
@endsection
