@extends('shop.layout.markup')
@section('title')
    Order Thanks | {{config('app.name')}}
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
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- page__header / end -->
    <!-- page__header / end --><!-- page__body -->
    <div class="page__body" id="pagecart">
        <div class="block">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-8 d-flex">
                      <div class="card text-center">
                        <div class="card-body">
                          <h4 class="card-title text-success">Thank you for your order.</h4>
                          <p class="card-text">Thank you for choosing {{ config('app.url') }}. We hope you had a good experience! We always strive to keep improving the services we offer. Our highest priority is to ensure that thes services meet your expectations.</p>
                          <p class="card-text text-info">Please payment within 24 hours to confirm the order..</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-4 d-flex">
                      <div class="card">
                        <div class="card-body">
                            <table class="table table-borderless">
                              <tbody>
                                <tr class="">
                                  <th colspan="2" class="text-center bg-secondary text-white">Order No #</th>
                                </tr>
                                <tr>
                                  <th class="text-left">Purchased Item (1)</th>
                                  <td class="text-right">Mark</td>
                                </tr>
                                <tr class="text-left">
                                  <th>Shipping Charge</th>
                                  <td class="text-right">Mark</td>
                                </tr>
                                <tr class="bg-dark text-white">
                                  <th class="text-left text-bold">Total</th>
                                  <td class="text-right">Mark</td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="row">
{{--                     <div class="col-lg-6 d-flex">
                        <div class="card mb-lg-0 flex-grow-1">
                            <div class="card__header">
                                <h4 class="decor-header">Shipping Address</h4>
                            </div>
                            <div class="card__content">
                                <div class="form-group">
                                    <input id="name" value=" {{$shippinginfo['name']}} " type="text" class="form-control" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <input id="mobile" value=" {{$shippinginfo['mobile']}} " type="text" class="form-control" placeholder="Mobile Number">
                                </div>
                                <div class="form-group">
                                    <input id="address_1" value=" {{$shippinginfo['address_1']}} " type="text" class="form-control" placeholder="Address Line 1">
                                </div>
                                <div class="form-group">
                                    <input id="address_2" value=" {{$shippinginfo['address_2']}} " type="text" class="form-control" placeholder="Address Line 2 (Optional)">
                                </div>
                                <div class="form-group">
                                    <input id="city" value=" {{$shippinginfo['city']}} " type="text" class="form-control" placeholder="City">
                                </div>
                                <div class="form-group">
                                    <input id="state" value=" {{$shippinginfo['state']}} " type="text" class="form-control" placeholder="State / District">
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-lg-6 d-flex">
                        <div class="card mb-lg-0 flex-grow-1">
                            <div class="card__header">
                                <h4 class="decor-header">Billing Address</h4>
                            </div>
                            <div class="card__content">
                                <div class="form-group">
                                    <input id="customer_name" type="text" class="form-control" name="name" placeholder="Name" required>
                                </div>
                                <div class="form-group">
                                    <input id="mobile" type="text" class="form-control" name="mobile" placeholder="Mobile Number" required>
                                </div>
                                <div class="form-group">
                                    <input id="address" type="text" class="form-control" name="address_1" placeholder="Address Line 1">
                                </div>
                                <div class="form-group">
                                    <input id="address_2" type="text" class="form-control" name="address_2" placeholder="Address Line 2 (Optional)">
                                </div>
                                <div class="form-group">
                                    <input id="city" type="text" class="form-control" name="city" placeholder="City">
                                </div>
                                <div class="form-group">
                                    <input id="state" type="text" class="form-control" name="state" placeholder="State / District">
                                </div>
                            </div>
                        </div>
                  </div>
                </div>
            </div>
        </div>
      </div>
</div>

@endsection

@section('script')

@endsection
