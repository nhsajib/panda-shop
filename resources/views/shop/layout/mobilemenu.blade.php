    <div class="mobilemenu">
        <div class="mobilemenu__backdrop"></div>
        <div class="mobilemenu__container">
            <div class="mobilemenu__header">
                <div class="mobilemenu__title">Menu</div>
                <button class="mobilemenu__close" type="button">
                    <span>
                        <i class="fas fa-times"></i>
                    </span>
                </button>
            </div>
            <div class="mobilemenu__body">
                <ul class="mobilemenu__links mobilemenu__links--level--1" data-collapse data-collapse-open-class="mobilemenu__item--open">
                    <li class="mobilemenu__item" data-collapse-item>
                        <a class="mobilemenu__link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="mobilemenu__item mobilemenu__item--has-children" data-collapse-item>
                        <a class="mobilemenu__link" href="#">Categories </a>
                        <button type="button" class="mobilemenu__arrow mobilemenu__expander" data-collapse-trigger>
                            <span>
                                <i class="fas fa-caret-down"></i>
                            </span>
                        </button>
                        <div class="mobilemenu__sub-links" data-collapse-content>
                            <ul class="mobilemenu__links mobilemenu__links--level--2">
                                @foreach($categories as $cat)
                                <li class="mobilemenu__item mobilemenu__item--has-children" data-collapse-item>
                                    <a class="mobilemenu__link" href="#">{{$cat->name}}</a>
                                    <button type="button" class="mobilemenu__arrow mobilemenu__expander" data-collapse-trigger>
                                        <svg width="6px" height="9px">
                                            <use xlink:href="images/sprite.svg#arrow-left-6x9"></use>
                                        </svg>
                                    </button>
                                    <div class="mobilemenu__sub-links" data-collapse-content>
                                        <ul class="mobilemenu__links mobilemenu__links--level--3">
                                            @foreach($cat->cartories as $catg)
                                            <li class="mobilemenu__item" data-collapse-item>
                                                <a class="mobilemenu__link" href="{{ route('shop.category', [$catg->id, $catg->name]) }}">{{$catg->name}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                    </li>
                    <li class="mobilemenu__item mobilemenu__item--has-children" data-collapse-item><a class="mobilemenu__link" href="shop-grid.html">Shop </a>
                        <button type="button" class="mobilemenu__arrow mobilemenu__expander" data-collapse-trigger>
                            <svg width="6px" height="9px">
                                <use xlink:href="images/sprite.svg#arrow-left-6x9"></use>
                            </svg>
                        </button>
                        <div class="mobilemenu__sub-links" data-collapse-content>
                            <ul class="mobilemenu__links mobilemenu__links--level--2">
                                <li class="mobilemenu__item mobilemenu__item--has-children" data-collapse-item><a class="mobilemenu__link" href="shop-grid.html">Shop </a>
                                    <button type="button" class="mobilemenu__arrow mobilemenu__expander" data-collapse-trigger>
                                        <svg width="6px" height="9px">
                                            <use xlink:href="images/sprite.svg#arrow-left-6x9"></use>
                                        </svg>
                                    </button>
                                    <div class="mobilemenu__sub-links" data-collapse-content>
                                        <ul class="mobilemenu__links mobilemenu__links--level--3">
                                            <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="shop-grid.html">Shop Grid</a></li>
                                            <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="shop-full-grid-5.html">Shop Full Grid 5</a></li>
                                            <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="shop-list.html">Shop List</a></li>
                                            <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="shop-left-sidebar.html">Shop Left Sidebar</a></li>
                                            <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="shop-right-sidebar.html">Shop Right Sidebar</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="product.html">Product</a></li>
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="cart.html">Cart</a></li>
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="checkout.html">Checkout</a></li>
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="account.html">My Account</a></li>
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="track-order.html">Track Order</a></li>
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="wishlist.html">Wishlist</a></li>
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="compare.html">Compare</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="mobilemenu__item mobilemenu__item--has-children" data-collapse-item><a class="mobilemenu__link" href="blog.html">Blog </a>
                        <button type="button" class="mobilemenu__arrow mobilemenu__expander" data-collapse-trigger>
                            <svg width="6px" height="9px">
                                <use xlink:href="images/sprite.svg#arrow-left-6x9"></use>
                            </svg>
                        </button>
                        <div class="mobilemenu__sub-links" data-collapse-content>
                            <ul class="mobilemenu__links mobilemenu__links--level--2">
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="blog.html">Blog Grid</a></li>
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="blog-list.html">Blog List</a></li>
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="blog-left-sidebar.html">Blog Left Sidebar</a></li>
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="post.html">Post</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="mobilemenu__item mobilemenu__item--has-children" data-collapse-item><a class="mobilemenu__link" href="about-us.html">Pages </a>
                        <button type="button" class="mobilemenu__arrow mobilemenu__expander" data-collapse-trigger>
                            <svg width="6px" height="9px">
                                <use xlink:href="images/sprite.svg#arrow-left-6x9"></use>
                            </svg>
                        </button>
                        <div class="mobilemenu__sub-links" data-collapse-content>
                            <ul class="mobilemenu__links mobilemenu__links--level--2">
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="about-us.html">About Us</a></li>
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="contact-us.html">Contact Us</a></li>
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="404.html">404</a></li>
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="terms-and-conditions.html">Terms And Conditions</a></li>
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="faq.html">FAQ</a></li>
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="components.html">Components</a></li>
                                <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="typography.html">Typography</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="contact-us.html">Contact Us</a></li>
                    <li class="mobilemenu__item" data-collapse-item><a class="mobilemenu__link" href="https://themeforest.net/item/meblya-responsive-ecommerce-html-template/23181513">Buy Theme</a></li>
                </ul>
            </div>
        </div>
    </div>