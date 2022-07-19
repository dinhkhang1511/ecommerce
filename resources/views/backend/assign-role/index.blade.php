@extends('layouts.backend.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Roles</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Roles</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Assign role {{ $role->name }} to users</h4>
                <form action="{{ route('assign-roles.store', ['role' => $role->id ]) }}" method="post" class="d-inline">
                @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th class="text-nowrap">Assign</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check{{ $user->id }}" value="{{ $user->id }}"
                                             name="users[]" @if($assignedUsers->contains($user->id)) checked @endif>
                                            <label class="custom-control-label" for="check{{ $user->id }}">Yes</label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary" btn-lg btn-block">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
