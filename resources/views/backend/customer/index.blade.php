@extends('layouts.backend.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Customers</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Customers</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    @foreach ($customers as $customer)
    <div class="col-md-6 col-lg-6 col-xlg-4">
        <div class="card card-body">
            <div class="row align-items-center">
                <div class="col-md-4 col-lg-3 text-center">
                    <a href="{{ route('customers.show', ['customer' => $customer->id ]) }}">
                        <img src="/{{ $customer->avatar }}" class="customer-avatar">
                    </a>
                </div>
                <div class="col-md-8 col-lg-9">
                    <h3 class="box-title m-b-0">
                        <a href="{{ route('customers.show', ['customer' => $customer->id ]) }}">
                            {{ $customer->name }}
                        </a>
                        <form action="{{ route('customers.destroy', ['customer' => $customer->id ]) }}" method="post" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="btn-lg btn-none" type="submit" data-toggle="tooltip" data-original-title="Delete"> 
                                <i class="fa fa-close text-danger"></i> 
                            </button>
                        </form>
                    </h3> 
                    Email : <small>{{ $customer->email }}</small>
                    <address>
                        Address : {{ $customer->address }}
                        <br/>
                        Phone : {{ $customer->phone }}
                    </address>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
{{ $customers->links() }}
@endsection
