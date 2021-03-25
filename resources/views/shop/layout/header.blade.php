            <header class="site__header">
                <div class="header">
                    <div class="header__body">
                        <div class="search">
                            <form class="search__form">
                                <input class="search__input" type="search" placeholder="Search Query...">
                                <button class="search__button" type="submit">
                                    <span style="font-size: 20px;">
                                      <i class="fas fa-search" aria-hidden="true"></i>
                                    </span>
                                </button>
                                <button class="search__button search-trigger" type="button">
                                    <span style="font-size: 20px;">
                                      <i class="fas fa-times"></i>
                                    </span>
                                </button>
                            </form>
                        </div>
                        <button class="header__mobilemenu" type="button">
                            <span style="font-size: 20px">
                                <i class="fas fa-bars"></i>
                            </span>
                        </button>
                        <a href="{{ route('home') }}" class="header__logo">
                            <svg class="logo" xmlns="http://www.w3.org/2000/svg" width="82px" height="24px">
                                <path d="M79.011,17.987 L79.011,15.978 C79.011,15.978 77.402,17.366 76.739,17.672 C76.074,17.979 75.110,17.987 74.043,17.987 C72.730,17.987 71.698,17.757 70.944,17.004 C70.191,16.252 70.001,15.282 70.001,13.892 C70.001,12.437 70.421,10.962 71.435,10.272 C72.450,9.581 73.878,9.020 75.924,8.947 L78.295,8.953 C78.295,7.563 77.586,6.768 76.168,6.768 C75.077,6.768 73.794,7.099 72.319,7.761 L71.085,5.235 C72.657,4.409 74.400,3.997 76.315,3.997 C78.149,3.997 79.555,4.397 80.532,5.198 C81.510,6 81.999,7.217 81.999,8.852 L81.999,17.987 L79.011,17.987 ZM78.295,11.636 L76.852,11.685 C75.769,11.718 74.963,11.914 74.434,12.273 C73.904,12.633 73.639,13.181 73.639,13.917 C73.639,14.971 74.242,15.297 75.448,15.297 C76.311,15.297 77.101,14.948 77.619,14.449 C78.135,13.951 78.295,13.590 78.295,12.764 L78.295,11.636 ZM57.289,24 C56.646,24 55,23.994 55,23.994 L55,20.995 C55,20.995 56.332,20.998 56.861,20.998 C59.189,20.998 59.962,17.898 59.962,17.898 L54,4 L58,4 L61.720,14.396 L65,4 L69,4 L62.989,19.741 C61.931,22.589 59.909,24 57.289,24 ZM49,0 L52,0 L52,18 L49,18 L49,0 ZM41.500,18 C40.163,18 38.953,17.368 38,16.358 L38,18 L35,18 L35,0 L38,0 L38,5.642 C38.953,4.632 40.163,4 41.500,4 C44.538,4 47,7.134 47,11 C47,14.866 44.538,18 41.500,18 ZM41,7 C39.343,7 38,8.791 38,11 C38,13.209 39.343,15 41,15 C42.657,15 44,13.209 44,11 C44,8.791 42.657,7 41,7 ZM25.157,14.338 C25.743,14.932 26.565,15.229 27.623,15.229 C28.444,15.229 29.222,15.144 29.954,14.973 C30.687,14.802 31.451,14.529 32,14.155 L32,17.036 C31.598,17.361 30.902,17.603 30.162,17.762 C29.421,17.921 28.518,18 27.452,18 C24,18 21,16 21,11 C21,8 22,4 27,4 C32,4 33,8 33,11 L33,12 L24.217,12 C24.257,13.162 24.571,13.744 25.157,14.338 ZM29.527,9 C29.510,8.081 29,7 27,7 C25,7 24.367,8.081 24.302,9 L29.527,9 ZM16,4.500 L10.977,18 L8,18 L3,4.500 L3,18 L0,18 L0,0 L5,0 L9.500,13.400 L14,0 L19,0 L19,18 L16,18 L16,4.500 Z"></path>
                                <path class="logo__accent" d="M0,22 L52,22 L52,24 L0,24 L0,22"></path>
                            </svg>
                        </a>
                        
                        <nav class="header__nav main-nav">
                            <ul class="main-nav__list">
                                <li class="main-nav__item">
                                    <a class="main-nav__link" href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="main-nav__item">
                                    <a class="main-nav__link" href="#">
                                        Categories
                                        <span class="main-nav__link-arrow">
                                            <i class="fas fa-caret-down"></i>
                                        </span>
                                    </a>
                                    <div class="main-nav__sub-megamenu">
                                        <div class="megamenu">

                                            <div class="row">
                                                <div class="col-2">
                                                    <ul class="megamenu__links megamenu__links--root">
                                                        @php $i = 0 @endphp
                                                        @foreach($categories as $cat)
                                                            <li>{{$cat->name}}
                                                                <ul class="megamenu__links megamenu__links--sub">
                                                                    @foreach($cat->cartories as $catg)
                                                                        <li><a href="{{ route('shop.category', [$catg->id, $catg->name]) }}">{{$catg->name}}</a></li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                            
                                                            {{-- After display 2 category add a new div --}}
                                                            @php $i++ @endphp
                                                            @if($i == 2)
                                                                </ul>
                                                                </div>
                                                                <div class="col-2">
                                                                <ul class="megamenu__links megamenu__links--root">
                                                            @php $i = 0 @endphp
                                                            @endif

                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="col-4">
                                                    <a href="#" class="megamenu__banner">
                                                        <img srcset="images/banners/megamenu-banner.jpg, images/banners/megamenu-banner@2x.jpg 2x" src="images/banners/megamenu-banner.jpg" alt="">
                                                    </a>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </li>
                                <li class="main-nav__item main-nav__item--with--menu">
                                    <a class="main-nav__link" href="shop-grid.html">
                                        Shop
                                        <span class="main-nav__link-arrow">
                                            <i class="fas fa-caret-down"></i>
                                        </span>
                                    </a>
                                    <div class="main-nav__sub-menu">
                                        <ul class="menu">
                                            <li class="menu__item">
                                                <a class="menu__link" href="shop-grid.html">
                                                    Shop
                                                    <span class="main-nav__link-arrow">
                                                        <i class="fas fa-caret-right"></i>
                                                    </span>
                                                </a>
                                                <div class="menu__sub">
                                                    <ul class="menu">
                                                        <li class="menu__item"><a class="menu__link" href="shop-grid.html">Shop Grid</a></li>
                                                        <li class="menu__item"><a class="menu__link" href="shop-full-grid-5.html">Shop Full Grid 5</a></li>
                                                        <li class="menu__item"><a class="menu__link" href="shop-list.html">Shop List</a></li>
                                                        <li class="menu__item"><a class="menu__link" href="shop-left-sidebar.html">Shop Left Sidebar</a></li>
                                                        <li class="menu__item"><a class="menu__link" href="shop-right-sidebar.html">Shop Right Sidebar</a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="menu__item"><a class="menu__link" href="product.html">Product</a></li>
                                            <li class="menu__item"><a class="menu__link" href="cart.html">Cart</a></li>
                                            <li class="menu__item"><a class="menu__link" href="checkout.html">Checkout</a></li>
                                            <li class="menu__item"><a class="menu__link" href="account.html">My Account</a></li>
                                            <li class="menu__item"><a class="menu__link" href="track-order.html">Track Order</a></li>
                                            <li class="menu__item"><a class="menu__link" href="wishlist.html">Wishlist</a></li>
                                            <li class="menu__item"><a class="menu__link" href="compare.html">Compare</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="main-nav__item">
                                    <a class="main-nav__link" href="contact-us.html">Contact Us</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="header__spring"></div>
                        <div class="header__indicator">
                            <button type="button" class="header__indicator-button indicator search-trigger" style="font-size: 20px;" title="Search">
                                <span class="indicator__area">
                                    <i class="fas fa-search"></i>
                                </span>
                            </button>
                        </div>
                        <div class="header__indicator">
                            <a href="wishlist.html" class="header__indicator-button indicator" title="View Wishlist">
                                <span class="indicator__area" style="font-size: 20px;">
                                    <i class="far fa-heart"></i>
                                </span>
                            </a>
                        </div>
                        <div class="header__indicator">
                            <a href="{{ route('shop.cart') }}" class="header__indicator-button indicator" title="View Cart">
                                <span class="indicator__area" style="font-size: 20px;">
                                    <span id="totalitem" class="indicator__value">{{$cartitems}}</span>
                                    <i class="fas fa-shopping-cart"></i>
                                </span>
                            </a>
                        </div>
                        <div class="header__indicator">
                            <a href="#" class="header__indicator-button indicator dropdown-toggle" data-toggle="dropdown">
                                <span class="indicator__area" style="font-size: 20px;">
                                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                                </span>
                            </a>
                              <div class="dropdown-menu">
                                @guest
                                <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                                @endguest
                                @auth
                                <a class="dropdown-item" href="{{ route('shop.orderlist') }}">Orders</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                {{-- <a class="dropdown-item" href="#">Link 3</a> --}}
                                @endauth
                              </div>
                        </div>
                    </div>
                </div>
            </header>