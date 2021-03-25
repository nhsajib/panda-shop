@extends('shop.layout.markup')
@section('title')
	{{$product->title}} | {{config('app.name')}}
@endsection

@section('page')
<div class="page" id="page">
    <!-- page__header -->
    <div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <ol class="page__header-breadcrumbs breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$product->title}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- page__header / end -->
    <!-- page__body -->
    <div class="page__body">
        <!-- block -->
        <div class="block">
            <div class="product container">
                <div class="card product__info">
                    <div class="product__gallery">
                        <div class="product-gallery">
                            <div class="product-gallery__featured">
                                <div class="owl-carousel owl-loaded owl-drag" id="product-image">
                                    <div class="owl-stage-outer">
                                        <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1500px;">
                                        	@foreach($product->pimage as $image)
                                            <div class="owl-item" style="width: 500px;">
                                            	<img src="{{ asset('/upload/img').'/'.$image->image_url }}" alt="">
                                            </div>
                                            @endforeach

		                                </div>
		                            </div>
                        		</div>
                    		</div>
							<div class="product-gallery__carousel">
								<div class="owl-carousel owl-loaded owl-drag" id="product-carousel">
									<div class="owl-stage-outer">
										<div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 308px;">

											@foreach($product->pimage as $image)
											<div class="owl-item" style="width: 90.4px; margin-right: 12px;">
												<a href="" class="product-gallery__carousel-item product-gallery__carousel-item--active">
													<img class="product-gallery__carousel-image" src="{{ asset('/upload/img').'/'.$image->image_url }}" alt="">
												</a>
											</div>
											@endforeach

										</div>
									</div>
								</div>
							</div>
        				</div>
    				</div>
					<div class="product__details">
						<div class="product__categories-sku">
							<div class="product__categories">
                                <a href="{{ route('shop.category', [$product->category->id, $product->category->name]) }}">{{$product->category->name}}</a>
                            </div>
                            @if(count($product->attribute) !== 1)
                                <div class="product__sku" id="product__sku"></div>
                            @else
                                <div class="product__sku" id="product__sku">{{$product->attribute[0]->sku}}</div>
                            @endif
						</div>
						<div class="product__name">
							<h2 class="decor-header">{{$product->title}}</h2>
                            <input id="product_id" type="text" value="{{$product->id}}" hidden>
						</div>
                        <div class="product__rating">
                            <div class="product__rating-stars">
                                <div class="rating">
                                    <div class="rating__body">
                                    @foreach(range(1,5) as $i)
                                        <span class="fa-stack" style="width:1em; line-height: 1em; padding: 0 0.6em;">
                                            <i class="far fa-star fa-stack-1x rating__star"></i>
                                            @if($avg_review >0)
                                                @if($avg_review >0.5)
                                                    <i class="fas fa-star fa-stack-1x rating__fill"></i>
                                                @else
                                                    <i class="fas fa-star-half fa-stack-1x rating__fill"></i>
                                                @endif
                                            @endif
                                            @php $avg_review--; @endphp
                                        </span>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="product__rating-links">
                                <a href="#">({{count($reviews)}})</a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;<a href="#">Write A Review</a>
                            </div>
                        </div>
						<div class="product__description">
							{{strip_tags(Str::words($product->description, 50))}}
						</div>

                        {{-- For None Attribute Products --}}
                        @if(count($product->attribute) == 1)
                            @if($product->attribute[0]->stock <= 0)
                                <div class="product__actions-item mt-4">
                                    <button id="addcart" class="btn btn-primary btn-lg" disabled>Out of Stock</button>
                                </div>
                            @else
                            <div class="product__price" id="product__price">
                                @if(empty($product->attribute[0]->discount_price) && $product->attribute[0]->discount_price == 0)
                                    <span class="product__price-new">&#2547;{{$product->attribute[0]->price}}</span>
                                @endif
                                @if(empty(!$product->attribute[0]->discount_price) && $product->attribute[0]->discount_price !== 0)
                                    <span class="product__price-new">&#2547;{{$product->attribute[0]->discount_price}}</span>
                                @endif
                                @if(empty(!$product->attribute[0]->discount_price) && $product->attribute[0]->discount_price !== 0)
                                    <span class="product__price-old">&#2547;{{$product->attribute[0]->price}}</span>
                                @endif
                            </div>
                            <form class="product__options" onsubmit="return false">
                                <input type="hidden" id="attrselect" value="{{$product->attribute[0]->id}}">
                                <div class="form-group">
                                    <label class="product__option-label">Quantity</label>
                                    <div class="product__actions">
                                        <div class="product__actions-item">
                                            <div class="form-control-number product__quantity">
                                                <input id="cartqty" class="form-control form-control-lg form-control-number__input" type="number" value="1" min="1" max="{{$product->attribute[0]->stock}}">
                                                <div class="form-control-number__add"></div>
                                                <div class="form-control-number__sub"></div>
                                            </div>
                                        </div>
                                        <div class="product__actions-item">
                                            <button id="addcart" class="btn btn-primary btn-lg">Add to cart</button>
                                        </div>
                                        <div class="product__actions-item">
                                            <button type="button" class="btn btn-secondary btn-svg-icon btn-lg product__wishlist">
                                                <svg class="product-card__action-icon" width="16px" height="16px"><use xlink:href="images/sprite.svg#wishlist-16"></use></svg>
                                            </button>
                                        </div>
                                        <div class="product__actions-item">
                                            <button type="button" class="btn btn-secondary btn-svg-icon btn-lg product__compare">
                                                <svg class="product-card__action-icon" width="16px" height="16px"><use xlink:href="images/sprite.svg#compare-16"></use></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @endif
                        @else
                            <div class="product__price" id="product__price">
                                <span style="font-size: 1rem">Starting from</span>
                                @if(empty($product->attribute[0]->discount_price) && $product->attribute[0]->discount_price == 0)
                                    <span class="product__price-new">&#2547;{{$product->attribute[0]->price}}</span>
                                @endif
                                @if(empty(!$product->attribute[0]->discount_price) && $product->attribute[0]->discount_price !== 0)
                                    <span class="product__price-new">&#2547;{{$product->attribute[0]->discount_price}}</span>
                                @endif
                                @if(empty(!$product->attribute[0]->discount_price) && $product->attribute[0]->discount_price !== 0)
                                    <span class="product__price-old">&#2547;{{$product->attribute[0]->price}}</span>
                                @endif
                            </div>
                            <form class="product__options" onsubmit="return false">
                                <div class="form-group">
                                    <label class="product__option-label" id="attr_name">{{$product->attr_opt_name}}</label>
                                    <div class="radio-select">
                                        <select id="attrselect" class="form-control col-md-6">
                                            <option value="" disabled selected>Select {{$product->attr_opt_name}}</option>
                                            @foreach($product->attribute as $attr)
                                              <option value="{{$attr->id}}">{{$attr->attr_opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="product__option-label">Quantity</label>
                                    <div class="product__actions">
                                        <div class="product__actions-item">
                                            <div class="form-control-number product__quantity">
                                                <input id="cartqty" class="form-control form-control-lg form-control-number__input" type="number" value="1" min="1" max="0">
                                                <div class="form-control-number__add"></div>
                                                <div class="form-control-number__sub"></div>
                                            </div>
                                        </div>
                                        <div class="product__actions-item">
                                            <button id="addcart" class="btn btn-primary btn-lg">Add to cart</button>
                                        </div>
                                        <div class="product__actions-item">
                                            <button type="button" class="btn btn-secondary btn-svg-icon btn-lg product__wishlist">
                                                <svg class="product-card__action-icon" width="16px" height="16px"><use xlink:href="images/sprite.svg#wishlist-16"></use></svg>
                                            </button>
                                        </div>
                                        <div class="product__actions-item">
                                            <button type="button" class="btn btn-secondary btn-svg-icon btn-lg product__compare">
                                                <svg class="product-card__action-icon" width="16px" height="16px"><use xlink:href="images/sprite.svg#compare-16"></use></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif

						<div class="product__share-links share-links">
							<ul class="share-links__list">
								<li class="share-links__item share-links__item--type--like"><a href="">Like</a></li>
								<li class="share-links__item share-links__item--type--tweet"><a href="">Tweet</a></li>
								<li class="share-links__item share-links__item--type--pin"><a href="">Pin It</a></li>
								<li class="share-links__item share-links__item--type--counter"><a href="">4K</a></li>
							</ul>
						</div>
					</div>

</div>
<div class="card product__tabs tabs tabs--product">
    <div class="tabs__list">
    	<a href="#tab-description" class="tabs__tab">Description</a>
    	<a href="#tab-specification" class="tabs__tab">Specification</a>
    	<a href="#tab-reviews" class="tabs__tab tabs__tab--active">Reviews</a></div>
    <div class="tabs__tab-content tabs__tab-content--active"
        id="tab-description">
        <div class="product__tab-description">
            <div class="typography">
                <h2>Description</h2>
                	@php echo $product->description@endphp
            </div>
        </div>
    </div>
    <div class="tabs__tab-content" id="tab-specification">
        <div class="product__tab-specification">
            <div class="spec">
                <h2 class="spec__header decor-header">Specification</h2>
                <div class="spec__section">
                	@foreach($product->spec as $spec)
                    <div class="spec__row">
                        <div class="spec__name">{{$spec->spec_name}}</div>
                        <div class="spec__value">{{$spec->spec_details}}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="tabs__tab-content" id="tab-reviews">
        <div class="product__tab-reviews">
            <div class="reviews-view">
                @if(count($reviews) > 0)
                <div class="reviews-view__list">
                    <h2 class="reviews-view__header decor-header">Customer Reviews</h2>
                    <div class="reviews-list">
                        <ol class="reviews-list__content">
                            @foreach($reviews as $review)
                            <li class="reviews-list__item">
                                <div class="review">
                                    <div class="review__avatar"><img srcset="images/avatars/avatar1.jpg, images/avatars/avatar1@2x.jpg 2x" src="images/avatars/avatar1.jpg" alt=""></div>
                                    <div class="review__content">
                                        <div class="review__author">USER ID -> Name</div>
                                        <div class="review__rating">
                                            <div class="rating">
                                                <div class="rating__body">
                                                    @foreach(range(1,5) as $i)
                                                        <span class="fa-stack" style="width:1em; line-height: 1em; padding: 0 0.6em;">
                                                            <i class="far fa-star fa-stack-1x rating__star"></i>

                                                            @if($review->rating >0)
                                                                @if($review->rating >0.5)
                                                                    <i class="fas fa-star fa-stack-1x rating__fill"></i>
                                                                @else
                                                                    <i class="fas fa-star-half fa-stack-1x rating__fill"></i>
                                                                @endif
                                                            @endif
                                                            @php $review->rating--; @endphp
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="review__text">
                                            {{$review->comment}}
                                        </div>
                                        <div class="review__date">{{$review->created_at->format('j F, Y')}}</div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ol>
                        <div class="reviews-list__pagination">
                            <nav aria-label="Page navigation example">
                                {{ $reviews->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
                @else
                <p>This product has no reviews yet.</p>
                @endif

                <form id="feedbackform" class="reviews-view__form" action="{{ route('product.review') }}" method="POST">
                    @csrf
                    <h2 class="reviews-view__header decor-header">Write A Review</h2>
                    <div class="row">
                        <div class="col-12 col-lg-9 col-xl-8">
                            <div class="form-row">
                                <label for="review-text" style="padding-left: 5px">Your Rating</label>
                                <input id="rattingval" name="rating" type="number" step="0.1" hidden />
                                <input name="product_id" type="number" step="0.1" value="{{$product->id}}" hidden />
                                <p class="font-weight-bold">&nbsp;<kbd><span id="rattingview">0</span> <span>/5</span></kbd></p>
                            </div>
                                @if($errors->has('rating'))
                                    <div class="text-danger">Please select rating by clicking stars.</div>
                                @endif
                            <div id="rateYo" class="mb-3"></div>
                            <div class="form-group">
                                <label for="review-text">Your Review</label>
                                <textarea name="comment" class="form-control" id="review-text" rows="6" required></textarea>
                            </div>
                            <div class="form-group">
                                <button id="reviewsubmit" type="submit" class="btn btn-primary btn-lg">Post Your Review</button>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- block / end -->
<!-- block-products-carousel -->
@if(!count($reletad_product) == 0)
<div class="block block-products-carousel">
    <div class="container">
        <div class="block__title">
            <h2 class="decor-header decor-header--align--center">Related Products</h2>
        </div>
        <div class="block-products-carousel__slider slider slider--with-arrows">
            <div class="owl-carousel owl-loaded owl-drag">
                <div class="owl-stage-outer">
                    <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 4510px; padding-left: 7px; padding-right: 7px;">
                        
                        @foreach($reletad_product as $rproduct)
                        <div class="owl-item" style="width: 267px; margin-right: 14px;">
                            <div class="product-card product-card--layout--grid">
                                <div class="product-card__actions">
                                    <div class="product-card__actions-list">
                                        <button class="btn btn-light btn-svg-icon btn-sm" type="button">
                                            <svg width="16px" height="16px"><use xlink:href="images/sprite.svg#quickview-16"></use></svg>
                                        </button>
                                        <button class="btn btn-light btn-svg-icon btn-sm" type="button"><svg width="16px" height="16px"><use xlink:href="images/sprite.svg#wishlist-16"></use></svg>
                                        </button>
                                        <button class="btn btn-light btn-svg-icon btn-sm" type="button"><svg width="16px" height="16px"><use xlink:href="images/sprite.svg#compare-16"></use></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="product-card__image">
                                    <a href="{{ route('shop.product', [$rproduct->id, Str::slug($rproduct->title, '-')]) }}">
                                        {{-- <img src="{{ asset('/upload/img').'/'.$product->image }}" alt=""> --}}
                                        <img src="{{ asset('/upload/img/'.$rproduct->image) }}" alt="">
                                    </a>
                                </div>
                                <div class="product-card__info">
                                    <div class="product-card__category"><a href="">{{$rproduct->category->name}}</a></div>
                                    <div class="product-card__name">
                                        <a href="{{ route('shop.product', [$rproduct->id, Str::slug($rproduct->title, '-')]) }}">{{$rproduct->title}}</a>
                                    </div>
                                    <div class="product-card__rating">
                                        <div class="product-card__rating-title">Reviews (15)</div>
                                        <div class="product-card__rating-stars">
                                            <div class="rating">
                                                <div class="rating__body"><svg class="rating__star rating__star--active" width="13px" height="12px"><g class="rating__fill"><use xlink:href="images/sprite.svg#star-normal"></use></g><g class="rating__stroke"><use xlink:href="images/sprite.svg#star-normal-stroke"></use></g></svg>                                                    <svg class="rating__star rating__star--active" width="13px" height="12px"><g class="rating__fill"><use xlink:href="images/sprite.svg#star-normal"></use></g><g class="rating__stroke"><use xlink:href="images/sprite.svg#star-normal-stroke"></use></g></svg>                                                    <svg class="rating__star rating__star--active" width="13px" height="12px"><g class="rating__fill"><use xlink:href="images/sprite.svg#star-normal"></use></g><g class="rating__stroke"><use xlink:href="images/sprite.svg#star-normal-stroke"></use></g></svg>                                                    <svg class="rating__star" width="13px" height="12px"><g class="rating__fill"><use xlink:href="images/sprite.svg#star-normal"></use></g><g class="rating__stroke"><use xlink:href="images/sprite.svg#star-normal-stroke"></use></g></svg>                                                    <svg class="rating__star" width="13px" height="12px"><g class="rating__fill"><use xlink:href="images/sprite.svg#star-normal"></use></g><g class="rating__stroke"><use xlink:href="images/sprite.svg#star-normal-stroke"></use></g></svg></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-card__description">
                                        {{$rproduct->description}}
                                    </div>
                                    @if(!empty($rproduct->attribute[0]))
                                    <div class="product-card__prices-list">
                                        @if(!empty($rproduct->attribute[0]->discount_price))
                                        <div class="product-card__price product_price">{{$rproduct->attribute[0]->discount_price}}</div>
                                        @else
                                        <div class="product-card__price product_price">{{$rproduct->attribute[0]->price}}</div>
                                        @endif
                                    </div>
                                    @endif
                                    <div class="product-card__buttons">
                                        <div class="product-card__buttons-list">
                                            <button class="btn btn-primary product-card__addtocart" type="button">Add To Cart</button>
                                            <button class="btn btn-light btn-svg-icon product-card__wishlist" type="button"><svg width="16px" height="16px"><use xlink:href="images/sprite.svg#wishlist-16"></use></svg>
                                            </button>
                                            <button class="btn btn-light btn-svg-icon product-card__compare" type="button"><svg width="16px" height="16px"><use xlink:href="images/sprite.svg#compare-16"></use></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
                <div class="owl-nav">
                    <button type="button" role="presentation" class="owl-prev disabled"><svg width="8px" height="13px"><use xlink:href="images/sprite.svg#arrow-left-8x13"></use></svg>
                    </button>
                    <button type="button" role="presentation" class="owl-next"><svg width="8px" height="13px"><use xlink:href="images/sprite.svg#arrow-right-8x13"></use></svg>
                    </button>
                </div>
                <div class="owl-dots disabled"></div>
        </div>
    </div>
</div>
</div>
@endif
<!-- block-products-carousel / end -->
</div>
<!-- page__body / end -->
</div>
@endsection
@section('script')
<script>
</script>
@endsection