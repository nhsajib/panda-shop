@extends('shop.layout.markup')
@section('title')
	Orders | {{config('app.name')}}
@endsection

@section('page')
<div class="page">
    
    <!-- page__header -->
    <div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <ol class="page__header-breadcrumbs breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Orders</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- page__header / end -->
    <!-- page__header / end --><!-- page__body -->
    @if($orders->isEmpty())
    <div class="page__body">
        <div class="block">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4 class="text-center text-danger">You do not have any order.</h4>
                        <h4 class="text-center text-info">Please click <a href="{{ route('shop.cart') }}">here</a> to go Shoping Cart page.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else

    <div class="page__body" id="pagecart">
        <div class="block">
        <div class="row justify-content-center" style="font-size: 0.8em">
            <div class="col-md-7">
            <h2 class="page__header-title decor-header decor-header--align--center mb-4">Orders</h2>   
              <table class="table table-sm table-hover">
                <thead>
                  <tr class="table-warning text-center">
                    <th>Order ID</th>
                    <th>Payment Status</th>
                    <th>Order Status</th>
                    <th>Payment</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                  <tr class="text-center">
                    <td>#{{$order->id}}</td>
                    <td>{{$order->payment_status}}</td>
                    {{-- <td>{{$order->order_status}}</td> --}}
                    <td><button type="button" class="btn btn-info btn-sm">{{$order->order_status}}</button></td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                            Make Payment
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item btn-sm" href="">20% Payment</a>
                                <a class="dropdown-item btn-sm" href="#">Full Payment</a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                            Action
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item btn-sm" href="{{ route('invoice.download', [$order->id]) }}">Download Invoice</a>
                            </div>
                        </div>
                    </td>
                  </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
        </div>
        </div>
    </div>
    <!-- page__body / end -->
    @endif
</div>

@endsection

@section('script')

@endsection