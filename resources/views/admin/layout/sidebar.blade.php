            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href=" {{ route('admin.dashboard') }} " aria-expanded="false">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-shopping"></i>
                                <span class="hide-menu">Orders </span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.orders') }}" class="sidebar-link">
                                        <i class="mdi mdi-checkbox-blank-circle-outline"></i>
                                        <span class="hide-menu"> New Orders </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.inshipping') }}" class="sidebar-link">
                                        <i class="mdi mdi-checkbox-blank-circle-outline"></i>
                                        <span class="hide-menu"> Shipping Orders </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.completeorder') }}" class="sidebar-link">
                                        <i class="mdi mdi-checkbox-blank-circle-outline"></i>
                                        <span class="hide-menu"> Complete Orders </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-dns"></i>
                                <span class="hide-menu">Category </span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{route('admin.topcategory')}}" class="sidebar-link">
                                        <i class="mdi mdi-checkbox-blank-circle-outline"></i>
                                        <span class="hide-menu"> Top Category </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{route('admin.category')}}" class="sidebar-link">
                                        <i class="mdi mdi-checkbox-blank-circle-outline"></i>
                                        <span class="hide-menu"> Category </span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-archive"></i>
                                <span class="hide-menu">Product </span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{route('admin.addproduct')}}" class="sidebar-link">
                                        <i class="mdi mdi-checkbox-blank-circle-outline"></i>
                                        <span class="hide-menu"> Add Product </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{route('admin.allproduct')}}" class="sidebar-link">
                                        <i class="mdi mdi-checkbox-blank-circle-outline"></i>
                                        <span class="hide-menu"> View Products </span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.approve') }}" aria-expanded="false">
                                <i class="mdi mdi-checkbox-marked-circle"></i>
                                <span class="hide-menu">Approve Products</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.shipping') }}" aria-expanded="false">
                                <i class="mdi mdi-motorbike"></i>
                                <span class="hide-menu">Shipping Method</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-settings"></i>
                                <span class="hide-menu">Setting </span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{route('admin.geninfo')}}" class="sidebar-link">
                                        <i class="mdi mdi-checkbox-blank-circle-outline"></i>
                                        <span class="hide-menu"> General Information </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{route('admin.homesetting')}}" class="sidebar-link">
                                        <i class="mdi mdi-checkbox-blank-circle-outline"></i>
                                        <span class="hide-menu"> Hero Slider </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.featured') }}" class="sidebar-link">
                                        <i class="mdi mdi-checkbox-blank-circle-outline"></i>
                                        <span class="hide-menu"> Featured Products </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.latest') }}" class="sidebar-link">
                                        <i class="mdi mdi-checkbox-blank-circle-outline"></i>
                                        <span class="hide-menu"> Latest Collection </span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>