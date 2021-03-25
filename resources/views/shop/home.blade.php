@extends('shop.layout.markup')
@section('title')
	{{config('app.name')}}
@endsection

@section('page')
    <!-- Hero Slider -->
    <div class="block block-slider block-slider--featured">
        <div class="container">
            <div class="slider slider--with-dots">
                <div class="owl-carousel owl-loaded owl-drag">
                    <div class="owl-stage-outer">
                        <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 3330px;">
                            @foreach($heroslider as $slide)
                                <div class="owl-item active" style="width: 1110px;">
                                    <a href="shop-grid.html">
                                        <picture>
                                            <img src="{{ asset('/upload/img').'/'.$slide->img }}" alt="">
                                        </picture>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="owl-nav disabled">
                        <button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button>
                        <button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Slider End -->

    <!-- Product carousel -->
    <div class="block block-products-carousel">
        <div class="container">
            <div class="block__title">
                <h2 class="decor-header decor-header--align--center">Featured Products</h2>
            </div>
            <div class="block-products-carousel__slider slider slider--with-arrows">
                <div class="owl-carousel">
                    @foreach($featured as $product)
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
                                    <img src="{{ asset('/upload/img').'/'.$product->image }}" alt="">
                                </a>
                            </div>
                            <div class="product-card__info">
                                <div class="product-card__category">
                                    <a href="{{ route('shop.category', [$product->category->id, $product->category->name]) }}">{{$product->category->name}}</a>
                                </div>
                                <div class="product-card__name">
                                    <a href="{{ route('shop.product', [$product->id, Str::slug($product->title, '-')]) }}">{{$product->title}}</a>
                                </div>
                                <div class="product-card__rating">
                                    <div class="product-card__rating-title">Reviews (15)</div>
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Product Carousel End -->

    <!-- Collerctons Section -->
    <div class="block block-collections">
        <div class="container">
            <div class="block__title">
                <h2 class="decor-header decor-header--align--center">Latest Collections</h2></div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="block-collections__item block-collections__item--start">
                        <div class="block-collections__info block-collections__info--top-start">
                            <div class="block-collections__name">{{$lcollection[0]->option1}}</div>
                            <div class="block-collections__description">{{$lcollection[0]->text}}</div>
                            <div class="block-collections__button">
                                <a href="{{$lcollection[0]->url}}" class="btn btn-primary">{{$lcollection[0]->option2}}</a>
                            </div>
                        </div>
                        <div class="block-collections__image">
                            <a href="shop-grid.html">
                                <picture>
                                    <img src="{{ asset('/upload/img').'/'.$lcollection[0]->img }}" class="img-thumbnail" alt="">
                                </picture>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-7 pt-5 pt-md-0">
                    <div class="block-collections__item block-collections__item--end">
                        <div class="block-collections__image">
                            <a href="shop-grid.html">
                                <picture>
                                    <img src="{{ asset('/upload/img').'/'.$lcollection[1]->img }}" class="img-thumbnail" alt="">
                                </picture>
                            </a>
                        </div>
                        <div class="block-collections__info block-collections__info--bottom-end">
                            <div class="block-collections__name">{{$lcollection[1]->option1}}</div>
                            <div class="block-collections__description">{{$lcollection[1]->text}}</div>
                            <div class="block-collections__button">
                                <a href="{{$lcollection[1]->url}}" class="btn btn-primary">{{$lcollection[1]->option2}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Collection Section End -->

    <!-- Popular Category -->
    <div class="block block-shop-categories">
        <div class="container">
            <div class="block__title">
                <h2 class="decor-header decor-header--align--center">Popular Categories</h2></div>
            <div class="categories-list">

                @foreach($p_categories as $cat)
                <div class="card category-card">
                    <a href="#">
                        <div class="category-card__image">
                            <img src="{{ asset('/upload/img').'/'.$cat->img }}" alt="">
                        </div>
                        <div class="category-card__name">{{$cat->name}}</div>
                        <div class="category-card__products">{{ count($cat->products) }} Products</div>
                    </a>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    <!-- Popular Category End -->
@endsection