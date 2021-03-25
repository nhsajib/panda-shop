                        <aside class="sidebar">
                            <!-- widget-categories -->
                            <div class="widget widget--card">
                                <div class="widget__title">
                                    <h4 class="decor-header">Categories</h4>
                                </div>
                                <div class="widget__body">
                                    <div class="widget-categories" data-collapse data-collapse-open-class="widget-categories__item--open">
                                        <ul class="widget-categories__list">
                                            @foreach($topcarteories as $topcat)
                                            <li class="widget-categories__item" data-collapse-item data-collapse-trigger>
                                                <button class="widget-categories__arrow">
                                                    <svg width="4px" height="8px">
                                                        <use xlink:href="images/sprite.svg#arrow-light-left-4x8"></use>
                                                    </svg>
                                                </button>

                                                <a href="#" class="widget-categories__link">
                                                    {{$topcat->name}}
                                                </a>

                                                <div class="widget-categories__sublist" data-collapse-content>
                                                    <ul class="widget-categories__list">
                                                        @foreach($topcat->cartories as $cat)
                                                        <li class="widget-categories__item" data-collapse-item>
                                                            <a href="{{ route('shop.category', [$cat->id, $cat->name]) }}" class="widget-categories__link">
                                                                {{$cat->name}}
                                                            </a>
                                                        </li>
                                                        @endforeach

                                                    </ul>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- widget-categories / end -->

                            <!-- widget-filters -->
                            <div class="widget widget-filters widget--card">
                                <div class="widget__title">
                                    <h4 class="decor-header">Filters</h4>
                                </div>
                                <div class="widget__body">
                                    <div class="widget-filters__content">
                                        <div class="widget-filters__filter">
                                            <div class="widget-filters__filter-name">Price Range</div>
                                            <div class="widget-filters__filter-body">
                                                <div class="widget-filters__filter-content">
                                                    <form action="{{ route('shop.pricerange') }}" method="GET">
                                                        @isset($pricerange)
                                                        <div class="row ">
                                                            <div class="col">
                                                                <label for="min" class="text-center">Min</label>
                                                                <input type="number" name="min" class="form-control" value="{{$pricerange['min']}}" id="min" min="{{$min_price}}" max="{{$max_price}}">
                                                            </div>
                                                            <div class="col">
                                                                <label for="max">Max</label>
                                                                <input type="number" name="max" class="form-control" value="{{$pricerange['max']}}" id="max" min="{{$min_price}}" max="{{$max_price}}">
                                                            </div>
                                                        </div>
                                                        @else
                                                        <div class="row ">
                                                            <div class="col">
                                                                <label for="min" class="text-center">Min</label>
                                                                <input type="number" name="min" class="form-control" value="{{$min_price}}" id="min" min="{{$min_price}}" max="{{$max_price}}">
                                                            </div>
                                                            <div class="col">
                                                                <label for="max">Max</label>
                                                                <input type="number" name="max" class="form-control" value="{{$max_price}}" id="max" min="{{$min_price}}" max="{{$max_price}}">
                                                            </div>
                                                        </div>
                                                        @endisset

                                                        <div class="row mt-2">
                                                            <button type="submit" class="btn btn-warning btn-sm btn-block">Apply</button>
                                                            <a href="{{ route('shop') }}" type="button" class="btn btn-secondary btn-sm btn-block">Clear</a></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- widget-filters / end -->

                            <!-- widget-banner -->
                            <div class="widget">
                                <a href="#" class="widget-sidebar-banner">
                                    <picture>
                                        <img src="images/banners/sidebar-banner.jpg" alt="">
                                    </picture>
                                </a>
                            </div>
                            <!-- widget-banner / end -->

                            <!-- widget-products-list -->
                            <div class="widget widget--card">
                                <div class="widget__title">
                                    <h4 class="decor-header">Bestsellers</h4>
                                </div>
                                <div class="widget__body">
                                    <ul class="widget-products-list">
                                        <li class="widget-products-list__item">
                                            <div class="widget-products-list__image">
                                                <a href="#">
                                                    <img src="images/products/product1-1-thumbnail.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="widget-products-list__info">
                                                <div class="widget-products-list__category">
                                                    <a href="#">Chandeliers</a>
                                                </div>
                                                <div class="widget-products-list__name">
                                                    <a href="#">Aluminum Chandelier</a>
                                                </div>
                                                <div class="widget-products-list__price">$249.00</div>
                                            </div>
                                        </li>
                                        <li class="widget-products-list__item">
                                            <div class="widget-products-list__image">
                                                <a href="#">
                                                    <img src="images/products/product1-1-thumbnail.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="widget-products-list__info">
                                                <div class="widget-products-list__category">
                                                    <a href="#">Chandeliers</a>
                                                </div>
                                                <div class="widget-products-list__name">
                                                    <a href="#">Aluminum Chandelier</a>
                                                </div>
                                                <div class="widget-products-list__price">$249.00</div>
                                            </div>
                                        </li>
                                        <li class="widget-products-list__item">
                                            <div class="widget-products-list__image">
                                                <a href="#">
                                                    <img src="images/products/product1-1-thumbnail.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="widget-products-list__info">
                                                <div class="widget-products-list__category">
                                                    <a href="#">Chandeliers</a>
                                                </div>
                                                <div class="widget-products-list__name">
                                                    <a href="#">Aluminum Chandelier</a>
                                                </div>
                                                <div class="widget-products-list__price">$249.00</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- widget-products-list / end -->
                        </aside>