@extends('shop.layout.markup')
@section('title')
	Shop | {{config('app.name')}}
@endsection
{{-- {{ dd($products) }} --}}
@section('page')
    <!-- page__header -->
    <div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <ol class="page__header-breadcrumbs breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shop</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- page__header / end -->
    <!-- page__body -->
    <div class="page__body">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-3 order-1 order-lg-0">
                    <div class="block">
                    @include('shop.layout.sidebar')
                    </div>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="block">
                        <div class="products-view">
                            <div class="products-view__options view-options">
                                <div class="view-options__legend">Showing {{$perpageitem}} of {{$totalitem}} products</div>
                                <div class="view-options__divider"></div>
                                <div class="view-options__control">
                                    <label class="view-options__control-label" for="view-options-sort">Sort By:</label>
                                    <div class="view-options__control-content">
                                        <select class="form-control form-control-sm" id="view-options-sort" onchange="javascript:location.href = this.value;">
                                            <option value="{{ route('shop') }}">Defult</a></option>

                                            <option value="{{ route('shop.filter', ['title', 'asc']) }}" @isset($filter) @if('titleasc' == $filter) selected="" @endif @endisset >Name (A-Z)</option>

                                            <option value="{{ route('shop.filter', ['avg_price', 'asc']) }}" @isset($filter) @if('avg_priceasc' == $filter) selected="" @endif @endisset>Price (Low > High)</option>

                                            <option value="{{ route('shop.filter', ['avg_price', 'desc']) }}" @isset($filter) @if('avg_pricedesc' == $filter) selected="" @endif @endisset>Price (High > Low)</option>

                                            <option value="{{ route('shop.filter', ['avg_rating', 'desc']) }}" @isset($filter) @if('avg_ratingdesc' == $filter) selected="" @endif @endisset>Rating (High > Low)</option>
                                            
                                            <option value="{{ route('shop.filter', ['avg_rating', 'asc']) }}" @isset($filter) @if('avg_ratingasc' == $filter) selected="" @endif @endisset>Rating (Low > High)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="products-view__list products-list products-list--layout--grid-3">
                                @foreach ($products as $product)
                                <div class="products-list__item">
                                    <div class="product-card product-card--layout--grid">
                                        @if(!empty($product->attribute[0]))
                                        <div class="product-card__badges-list">
                                            @if(empty(!$product->attribute[0]->discount_price) && $product->attribute[0]->discount_price !== 0)
                                                <div class="product-card__badge product-card__badge--style--sale">Sale</div>
                                            @endif
                                        </div>
                                        @endif
                                        <div class="product-card__image">
                                            <a href="{{ route('shop.product', [$product->id, Str::slug($product->title, '-')]) }}">
                                                <img src=" {{ asset('/upload/img').'/'.$product->image }} " alt="">
                                            </a>
                                        </div>
                                        <div class="product-card__info">
                                            <div class="product-card__category">
                                                <a href="{{ route('shop.category', [$product->category->id, $product->category->name]) }}"> {{$product->category->name}} </a>
                                            </div>
                                            <div class="product-card__name">
                                                <a href="{{ route('shop.product', [$product->id, Str::slug($product->title, '-')]) }}">
                                                    {{$product->title}}
                                                </a>
                                            </div>
                                            <div class="product-card__rating">
                                                <div class="product-card__rating-title"></div>
                                                <div class="product-card__rating-stars">
                                                    <div class="rating">
                                                        <div class="rating__body">
                                                        @foreach(range(1,5) as $i)
                                                            <span class="fa-stack" style="width:1em; line-height: 1em; padding: 0 0.6em;">
                                                                <i class="far fa-star fa-stack-1x rating__star"></i>
                                                                @if($product->avg_rating >0)
                                                                    @if($product->avg_rating >0.5)
                                                                        <i class="fas fa-star fa-stack-1x rating__fill"></i>
                                                                    @else
                                                                        <i class="fas fa-star-half fa-stack-1x rating__fill"></i>
                                                                    @endif
                                                                @endif
                                                                @php $product->avg_rating--; @endphp
                                                            </span>
                                                        @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(!empty($product->attribute[0]))
                                            <div class="product-card__prices-list">
                                                <div class="product-card__price">
                                                    @if(empty(!$product->attribute[0]->discount_price) && $product->attribute[0]->discount_price !== 0)
                                                    <del id="del_price" class="text-danger pr-1">{{$product->attribute[0]->price}} </del>
                                                    @endif
                                                    
                                                    @if(empty(!$product->attribute[0]->discount_price) && $product->attribute[0]->discount_price !== 0)
                                                        <span class="pl-1">{{$product->attribute[0]->discount_price}}</span>
                                                    @else
                                                        <span class="pl-1">{{$product->attribute[0]->price}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            <div class="product-card__buttons">
                                                <div class="product-card__buttons-list">
                                                    <a href="{{ route('shop.product', [$product->id, Str::slug($product->title, '-')]) }}">
                                                        <button class="btn btn-primary product-card__addtocart" type="button">Details</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="products-view__pagination">
                                <nav aria-label="Page navigation example">
                                @isset($pricerange)
                                    {{ $products->appends(['min' => $pricerange['min'], 'max' => $pricerange['max']])->links() }}
                                @else
                                    {{ $products->links() }}
                                @endisset
                                </nav>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- page__body / end -->
@endsection

@section('script')
    <script>
        // localStorage.removeItem("shopSort");
    </script>
@endsection