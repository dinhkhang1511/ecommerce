@extends('layouts.backend.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Statistics</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">statistics</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Revenue statistics</h4>
                <div class="table-responsive">
                        <div class="float-left">
                            <a href="http://localhost:8888/api/excel/orders">
                                <button type="button" class="btn btn-primary mb-3">EXCEL</button>
                            </a>
                        </div>
                        <div class="float-right">
                            <div class="dropdown ">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Create date
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <a class="dropdown-item" href="#">
                                    <form action="{{route('statistic-orders')}}" method="GET" >
                                        <input class="input form-control" style="width:150px"type="date" data-date-format="YYYY-MM-DD"  placeholder="From" name="from">
                                        <input class="input form-control" style="width:150px"type="date"  data-date-format="YYYY-MM-DD" placeholder="To" name="to">
                                        <button type="submit" class="btn btn-primary">Ok</button>
                                    </form>
                                  </a>
                                </div>
                            </div>
                        </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="search" placeholder="Type to search" autofocus>
                    </div>
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Orders</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groupOrder as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td class="txt-oflo">{{ $item->date }}</td>
                                    <td class="txt-oflo">{{ money($item->total) }}</td>
                                    <td class="txt-oflo">{{ $item->orders }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <nav aria-label="...">
                    <ul class="pagination">
                      <li class="page-item {{$page == '1' ? 'disabled' : ''}} ">
                        <a class="page-link" href="{{route('orders.index')}}?page={{$page-1}}{{request('limit') ? '&limit='.request('limit') : ''}}" tabindex="-1">Previous</a>
                      </li>
                      <li class="page-item {{$page == $data->meta->last_page ? 'disabled' : ''}}" >
                        <a class="page-link" href="{{route('orders.index')}}?page={{$page+1}}{{request('limit') ? '&limit='.request('limit') : ''}}" >Next</a>
                      </li>
                    </ul>
                </nav> --}}
            </div>
        </div>
    </div>
</div>
@endsection
