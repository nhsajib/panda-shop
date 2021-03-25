@extends('shop.layout.markup')
@section('title')
	Shop | {{config('app.name')}}
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
                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- page__header / end -->
    <!-- page__header / end --><!-- page__body -->
    <div class="page__body" id="pagecart">
        @if(!session()->exists('cart'))
        <div class="block">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4 class="text-center text-danger">Your Shopping Cart is Empty</h4>
                        <h4 class="text-center text-info">Click <a href="{{ route('shop') }}">here</a> to continue shopping.</h4>
                    </div>
                </div>
            </div>
        </div>

        @else

        <div class="block">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="cart">
                            <form action="{{ route('updatecart') }}" method="POST">
                                @csrf
                            <table class="cart__table">
                                <thead class="cart__header">
                                    <tr>
                                        <td class="cart__column cart__column--image">Image</td>
                                        <td class="cart__column cart__column--info">Product</td>
                                        <td class="cart__column cart__column--price">Price</td>
                                        <td class="cart__column cart__column--quantity">Quantity</td>
                                        <td class="cart__column cart__column--total">Total</td>
                                        <td class="cart__column cart__column--remove"></td>
                                    </tr>
                                </thead>

                                <tbody class="cart__body">
                                    @foreach($usercartitems as $cartitem)
                                        <tr>
                                            <td class="cart__column cart__column--image">
                                                <img src="{{ asset('upload/img/'.$cartitem->product->image) }}" alt="" />
                                            </td>
                                            <td class="cart__column cart__column--info">
                                                <div class="cart__product-name">
                                                    <a href="{{ route('shop.product', [$cartitem->product->id, Str::slug($cartitem->product->title, '-')]) }}" target="_blank">{{$cartitem->product->title}}</a>
                                                </div>
                                                <ul class="cart__product-options">
                                                    @if(!empty($cartitem->product->attr_opt_name))
                                                        <li>{{$cartitem->product->attr_opt_name}}: {{$cartitem->attr->attr_opt}}</li>
                                                    @endif
                                                    <li>SKU: {{$cartitem->attr->sku}}</li>
                                                </ul>
                                            </td>
                                            <td id="price{{$cartitem->id}}" class="cart__column cart__column--price" data-title="Price">
                                                @if($cartitem->attr->discount_price <= 0)
                                                    {{$cartitem->attr->price}}
                                                @else
                                                    {{$cartitem->attr->discount_price}}
                                                @endif
                                            </td>
                                            <td class="cart__column cart__column--quantity" data-title="Quantity">
                                                <label for="quantity0" class="sr-only">Quantity</label>
                                                <div class="form-control-number">
                                                
                                                @if($cartitem->attr->discount_price <= 0)
                                                    <input name="item_id[]" value="{{$cartitem->id}}" hidden>

                                                    <input name="qty[]" id="quantity0" class="cartitemqty form-control form-control-number__input" type="number" min="1" max="{{$cartitem->attr->stock}}" value="{{$cartitem->qty}}" placeholder="" data-item-price="{{$cartitem->attr->price}}" data-attr-id="{{$cartitem->id}}"/>
                                                @else
                                                    <input name="item_id[]" value="{{$cartitem->id}}" hidden>

                                                    <input name="qty[]" id="quantity0" class="cartitemqty form-control form-control-number__input" type="number" min="1" max="{{$cartitem->attr->stock}}" value="{{$cartitem->qty}}" data-item-price="{{$cartitem->attr->discount_price}}" data-attr-id="{{$cartitem->id}}"/>
                                                @endif

                                                <div class="form-control-number__add"></div>
                                                <div class="form-control-number__sub"></div>
                                                </div>
                                            </td>
                                            <td id="total{{$cartitem->id}}" class="cart__column cart__column--total itemtotal">{{$cartitem->total_price}}</td>
                                            <td class="cart__column cart__column--remove">
                                                <button type="button" class="button-remove button-remove--lg" title="Remove Item">
                                                    <a href="{{ route('cart.remove', [$cartitem->id]) }}"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="cart__footer">
                                    <tr>
                                        <td colspan="3" class="cart__column"><a href="{{ route('home') }}" class="btn btn-secondary">Back To Shop</a></td>
                                        <td colspan="3" class="cart__column text-right"><button type="submit" class="btn btn-primary">Update Cart</button></td>
                                    </tr>
                                </tfoot>
                            </table>
                            </form>
                        </div>
                    </div>
                </div>

                <form action="{{ route('shop.order') }}" method="POST">
                    @csrf
                <div class="row mb-4">
                    <div class="col-lg-6 d-flex">
                        <div class="card mb-lg-0 flex-grow-1">
                            <div class="card__header">
                                <h4 class="decor-header">Shipping Address</h4>
                            </div>
                            <div class="card__content">
                                <div class="form-group">
                                    <input id="name" type="text" class="form-control @error('ship_name') is-invalid @enderror" name="ship_name" placeholder="Name">

                                    @error('ship_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="mobile" type="text" class="form-control @error('ship_mobile') is-invalid @enderror" name="ship_mobile" placeholder="Mobile Number">

                                    @error('ship_mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="address_1" type="text" class="form-control @error('ship_address_1') is-invalid @enderror" name="ship_address_1" placeholder="Address Line 1">

                                    @error('ship_address_1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="ship_address_2" type="text" class="form-control @error('ship_address_2') is-invalid @enderror" name="ship_address_2" placeholder="Address Line 2 (Optional)">

                                    @error('ship_address_2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="city" type="text" class="form-control @error('ship_city') is-invalid @enderror" name="ship_city" placeholder="City">

                                    @error('ship_city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="state" type="text" class="form-control @error('ship_state') is-invalid @enderror" name="ship_state" placeholder="State / District">

                                    @error('ship_state')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex">
                        <div class="card mb-0 flex-grow-1">
                            <div class="card__header">
                                <h4 class="decor-header">Cart Totals</h4>
                            </div>
                            <div class="card__content cart-totals">
                                <table class="cart-totals__table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Subtotal</th>
                                            <th>Shipping</td>
                                            <th class="text-center">Total</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="carttotalprice" class="text-center"></td>
                                            <td>
                                                <select id="shipping" name="shipping" class="form-control col-md-8 @error('shipping') is-invalid @enderror">
                                                    <option value="" selected disabled>Select Shipping Method</option>
                                                    @foreach($shippins as $shipping)
                                                    <option class="form-control" value="{{$shipping->price}}">{{$shipping->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('shipping')
                                                    <span class="invalid-feedback text-left" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                            <td id="nettotal" class="text-center">00.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @auth
                                <button type="submit" class="btn btn-primary btn-lg cart-totals__button">Place order</button>
                                @endauth
                                @guest
                                <div class="alert alert-danger" role="alert">
                                    <p class="alert-heading">Thanks for using {{config('app.name')}} !</p>
                                    <p>Please <a href="{{ route('login') }}" class="alert-link">Login</a> or <a href="{{ route('register') }}" class="alert-link">Register</a> to Place Order.</p>
                                    <hr>
                                    <p class="mb-0">If you are facing any problem to place order please call +8801773280001</p>
                                </div>
                                @endguest
                            </div>
                        </div>
                    </div>
{{--                     <div class="col-lg-6 d-flex">
                        <div class="card mb-lg-0 flex-grow-1">
                            <div class="card__header">
                                <h4 class="decor-header">Billing Address</h4>
                            </div>
                            <div class="card__content">
                                <div class="form-group">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="bill_name" placeholder="Name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="bill_mobile" placeholder="Mobile Number">

                                    @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="address_1" type="text" class="form-control @error('address_1') is-invalid @enderror" name="bill_address_1" placeholder="Address Line 1">

                                    @error('address_1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="address_2" type="text" class="form-control @error('address_2') is-invalid @enderror" name="bill_address_2" placeholder="Address Line 2 (Optional)">

                                    @error('address_2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="bill_city" placeholder="City">

                                    @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="bill_state" placeholder="State / District">

                                    @error('state')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                </form>
            </div>
        </div>
    
        @endif

    </div>
    <!-- page__body / end -->
</div>

@endsection

@section('script')

@endsection