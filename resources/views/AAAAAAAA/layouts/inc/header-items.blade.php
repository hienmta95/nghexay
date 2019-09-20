



{{--New theme menu--}}
<div class="gc_main_menu_wrapper">
    <div class="container-fluid">
        <div class="row">

            <?php
                $segment = request()->segment(1);
            ?>

            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 hidden-xs hidden-sm full_width">
                <div class="gc_header_wrapper">
                    <div class="gc_logo">
                        <a href="{{ route('homepage') }}">
                            <img src="{{ asset('storage/'. config('settings.app.logo')) . getPictureVersion() }}" alt="{{ strtolower(config('settings.app.app_name')) }}" title="{{ strtolower(config('settings.app.app_name')) }}" class="img-responsive" data-original-title="{!! isset($logoLabel) ? $logoLabel : '' !!}">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12 center_responsive">
                <div class="header-area hidden-menu-bar stick" id="sticker">
                    <!-- mainmenu start -->
                    <div class="mainmenu">
                        <div class="gc_right_menu">
                            <ul>
                                <li id="search_button">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_3" x="0px" y="0px" viewBox="0 0 451 451" style="enable-background:new 0 0 451 451;" xml:space="preserve"><g><path id="search" d="M447.05,428l-109.6-109.6c29.4-33.8,47.2-77.9,47.2-126.1C384.65,86.2,298.35,0,192.35,0C86.25,0,0.05,86.3,0.05,192.3   s86.3,192.3,192.3,192.3c48.2,0,92.3-17.8,126.1-47.2L428.05,447c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4   C452.25,441.8,452.25,433.2,447.05,428z M26.95,192.3c0-91.2,74.2-165.3,165.3-165.3c91.2,0,165.3,74.2,165.3,165.3   s-74.1,165.4-165.3,165.4C101.15,357.7,26.95,283.5,26.95,192.3z" fill="#23c0e9"/></g></svg>
                                </li>
                                <li>
                                    <div id="search_open" class="gc_search_box">
                                        <input type="text" placeholder="Search here">
                                        <button><i class="fa fa-search" aria-hidden="true"></i></button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <ul class="float_left">
                            <li class="gc_main_navigation parent">
                                <a href="{{ lurl('/') }}" class="gc_main_navigation">
                                    <i class="fa fa-home"></i> {{ t('Home') }}</a>
                            </li>

                            <li class="gc_main_navigation parent">
                                <?php $attr = ['countryCode' => config('country.icode')]; ?>
                                <a href="{{ lurl(trans('routes.v-search', $attr), $attr) }}" class="gc_main_navigation"><i class="fa fa-briefcase"></i> {{ t('Browse Jobs') }}</a>
                            </li>

                            <li class="gc_main_navigation parent">
                                <a href="{{ url('/ung-vien') }}" class="gc_main_navigation"><i class="fa fa-user"></i> {{ t('Job seekers') }}</a>
                            </li>

                            <li class="gc_main_navigation parent">
                                <a href="{{ lurl(trans('routes.v-companies-list', $attr), $attr) }}" class="gc_main_navigation"><i class="fa fa-building-o"></i> {{ t('Company') }}</a>
                            </li>

                            <li class="gc_main_navigation parent">
                                <a href="{{ url('/page/pricing') }}" class="gc_main_navigation"><i class="fa fa-table"></i> {{ t('Pricing') }}</a>
                            </li>

                        </ul>
                    </div>
                    <!-- mainmenu end -->
                    <!-- mobile menu area start -->
                    <header class="mobail_menu">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <div class="gc_logo">
                                        <a href="index.html"><img src="refactor-theme/images/header/logo.png" alt="Logo" title="Grace Church"></a>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="cd-dropdown-wrapper">
                                        <a class="house_toggle" href="#0">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 31.177 31.177" style="enable-background:new 0 0 31.177 31.177;" xml:space="preserve" width="25px" height="25px"><g><g><path class="menubar" d="M30.23,1.775H0.946c-0.489,0-0.887-0.398-0.887-0.888S0.457,0,0.946,0H30.23    c0.49,0,0.888,0.398,0.888,0.888S30.72,1.775,30.23,1.775z" fill="#ffffff"/></g><g><path class="menubar" d="M30.23,9.126H12.069c-0.49,0-0.888-0.398-0.888-0.888c0-0.49,0.398-0.888,0.888-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,8.729,30.72,9.126,30.23,9.126z" fill="#ffffff"/></g><g><path class="menubar" d="M30.23,16.477H0.946c-0.489,0-0.887-0.398-0.887-0.888c0-0.49,0.398-0.888,0.887-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,16.079,30.72,16.477,30.23,16.477z" fill="#ffffff"/></g><g><path class="menubar" d="M30.23,23.826H12.069c-0.49,0-0.888-0.396-0.888-0.887c0-0.49,0.398-0.888,0.888-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,23.43,30.72,23.826,30.23,23.826z" fill="#ffffff"/></g><g><path class="menubar" d="M30.23,31.177H0.946c-0.489,0-0.887-0.396-0.887-0.887c0-0.49,0.398-0.888,0.887-0.888H30.23    c0.49,0,0.888,0.398,0.888,0.888C31.118,30.78,30.72,31.177,30.23,31.177z" fill="#ffffff"/></g></g></svg>
                                        </a>
                                        <nav class="cd-dropdown">
                                            <h2><a href="#">Nghề<span> Xây</span></a></h2>
                                            <a href="#0" class="cd-close">Close</a>
                                            <ul class="cd-dropdown-content">
                                                <li>
                                                    <form class="cd-search">
                                                        <input type="search" placeholder="Search...">
                                                    </form>
                                                </li>
                                                <li>
                                                    <a href="{{ lurl('/') }}">
                                                        <i class="fa fa-home"></i> {{ t('Home') }}</a>                                                              </li>
                                                <li>
                                                    <?php $attr = ['countryCode' => config('country.icode')]; ?>
                                                    <a href="{{ lurl(trans('routes.v-search', $attr), $attr) }}"><i class="fa fa-briefcase"></i> {{ t('Browse Jobs') }}</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/ung-vien') }}"><i class="fa fa-user"></i> {{ t('Job seekers') }}</a>
                                                </li>
                                                <li>
                                                    <a href="{{ lurl(trans('routes.v-companies-list', $attr), $attr) }}"><i class="fa fa-building-o"></i> {{ t('Company') }}</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/page/pricing') }}"><i class="fa fa-table"></i> {{ t('Pricing') }}</a>
                                                </li>

                                                <!-- .has-children -->
                                                <li class="has-children">
                                                    <a href="#">Blog</a>

                                                    <ul class="cd-secondary-dropdown is-hidden">
                                                        <li class="go-back"><a href="#0">Menu</a></li>
                                                        <li>
                                                            <a href="blog_left.html">Blog-Left</a>
                                                        </li>
                                                        <!-- .has-children -->

                                                        <li>
                                                            <a href="blog_right.html">Blog-Right</a>
                                                        </li>
                                                        <!-- .has-children -->

                                                        <li>
                                                            <a href="blog_single_left.html">Blog-Single-Left</a>
                                                        </li>
                                                        <!-- .has-children -->

                                                        <li>
                                                            <a href="blog_single_right.html">Blog-Single-Left</a>
                                                        </li>
                                                        <!-- .has-children -->

                                                    </ul>
                                                    <!-- .cd-secondary-dropdown -->
                                                </li>
                                                <!-- .has-children -->

                                                @if (!auth()->check())
                                                    <li>
                                                        @if (config('settings.security.login_open_in_modal'))
                                                            <a href="#quickLogin" data-toggle="modal">
                                                                <i class="fa fa-user"></i> {{ t('Log In') }}
                                                            </a>
                                                        @else
                                                            <a href="{{ lurl(trans('routes.login')) }}">
                                                                <i class="fa fa-user"></i> {{ t('Log In') }}
                                                            </a>
                                                        @endif
                                                    </li>

                                                    <li class="has-children">
                                                        <a href="#">
                                                            <i class="fa fa-key"></i>
                                                            {{ t('Register') }}
                                                            <i class="fa fa-angle-down"></i>
                                                        </a>
                                                        <!-- mega menu start -->
                                                        <ul class="cd-secondary-dropdown is-hidden">
                                                            <li class="go-back"><a href="#0">Menu</a></li>
                                                            <li>
                                                                <a href="{!! url('nha-tuyen-dung') !!}"> Nhà tuyển dụng
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ lurl(trans('routes.register')) }}?type=2"> Ứng viên
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                @else
                                                    <li class="has-mega gc_main_navigation">
                                                        <a href="#" class="gc_main_navigation">
                                                            <i class="fa fa-user"></i>
                                                            {{ trans('global.My Account') }}
                                                            <i class="fa fa-angle-down"></i>
                                                        </a>

                                                        <ul>
                                                            <li class="parent"><a href="{{ lurl('account/dashboard') }}"><i
                                                                            class="icon-home"></i> {{ t('Personal Home') }}</a></li>
                                                            @if (in_array(auth()->user()->user_type_id, [1]))
                                                                <li class="parent"><a href="{{ lurl('account/companies') }}"><i
                                                                                class="icon-town-hall"></i> {{ t('My companies') }} </a></li>
                                                                <li class="parent"><a href="{{ lurl('account/my-posts') }}"><i
                                                                                class="icon-th-thumb"></i> {{ t('My ads') }} </a></li>
                                                                <li class="parent"><a href="{{ lurl('account/pending-approval') }}"><i
                                                                                class="icon-hourglass"></i> {{ t('Pending approval') }} </a></li>
                                                                <li class="parent"><a href="{{ lurl('account/archived') }}"><i
                                                                                class="icon-folder-close"></i> {{ t('Archived ads') }}</a></li>
                                                                <li class="parent">
                                                                    <a href="{{ lurl('account/conversations') }}">
                                                                        <i class="icon-mail-1"></i> {{ t('Conversations') }}
                                                                        <span class="badge badge-important count-conversations-with-new-messages">0</span>
                                                                    </a>
                                                                </li>
                                                                <li class="parent"><a href="{{ lurl('account/transactions') }}"><i
                                                                                class="icon-money"></i> {{ t('Transactions') }}</a></li>
                                                            @endif
                                                            @if (in_array(auth()->user()->user_type_id, [2]))
                                                                <li class="parent"><a href="{{ lurl('account/resumes') }}"><i
                                                                                class="icon-attach"></i> {{ t('My resumes') }} </a></li>
                                                                <li class="parent"><a href="{{ lurl('account/favourite') }}"><i
                                                                                class="icon-heart"></i> {{ t('Favourite jobs') }} </a></li>
                                                                <li class="parent"><a href="{{ lurl('account/saved-search') }}"><i
                                                                                class="icon-star-circled"></i> {{ t('Saved searches') }} </a></li>
                                                                <li class="parent">
                                                                    <a href="{{ lurl('account/conversations') }}">
                                                                        <i class="icon-mail-1"></i> {{ t('Conversations') }}
                                                                        <span class="badge badge-important count-conversations-with-new-messages">0</span>
                                                                    </a>
                                                                </li>
                                                            @endif
                                                            <li class="parent">
                                                                @if (app('impersonate')->isImpersonating())
                                                                    <a href="{{ route('impersonate.leave') }}">
                                                                        <i class="icon-logout hidden-sm"></i>
                                                                        {{ t('Leave') }}
                                                                    </a>
                                                                @else
                                                                    <a href="{{ lurl(trans('routes.logout')) }}">
                                                                        <i class="glyphicon glyphicon-off hidden-sm"></i>
                                                                        {{ t('Log Out') }}
                                                                    </a>
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </li>
                                                @endif
                                            </ul>
                                            <!-- .cd-dropdown-content -->

                                        </nav>
                                        <!-- .cd-dropdown -->

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- .cd-dropdown-wrapper -->
                    </header>
                </div>
            </div>
            <!-- mobile menu area end -->
            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 hidden-sm hidden-xs">
                <div class="header-area hidden-menu-bar stick" id="sticker">
                    <!-- mainmenu start -->
                    <div class="mainmenu">
                        <ul class="float_left">
                            @if (!auth()->check())
                                <li class="gc_main_navigation parent">
                                    @if (config('settings.security.login_open_in_modal'))
                                        <a href="#quickLogin" data-toggle="modal" class="gc_main_navigation">
                                            <i class="fa fa-user"></i> {{ t('Log In') }}
                                        </a>
                                    @else
                                        <a href="{{ lurl(trans('routes.login')) }}" class="gc_main_navigation">
                                            <i class="fa fa-user"></i> {{ t('Log In') }}
                                        </a>
                                    @endif
                                </li>

                                <li class="has-mega gc_main_navigation">
                                    <a href="#" class="gc_main_navigation">
                                        <i class="fa fa-key"></i>
                                        {{ t('Register') }}
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <!-- mega menu start -->
                                    <ul>
                                        <li class="parent">
                                            <a href="{!! url('nha-tuyen-dung') !!}"> Nhà tuyển dụng
                                            </a>
                                        </li>
                                        <li class="parent">
                                            <a href="{{ lurl(trans('routes.register')) }}?type=2"> Ứng viên
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="has-mega gc_main_navigation">
                                    <a href="#" class="gc_main_navigation">
                                        <i class="fa fa-user"></i>
                                        {{ trans('global.My Account') }}
                                        <i class="fa fa-angle-down"></i>
                                    </a>

                                    <ul>
                                        <li class="parent"><a href="{{ lurl('account/dashboard') }}"><i
                                                        class="icon-home"></i> {{ t('Personal Home') }}</a></li>
                                        @if (in_array(auth()->user()->user_type_id, [1]))
                                            <li class="parent"><a href="{{ lurl('account/companies') }}"><i
                                                            class="icon-town-hall"></i> {{ t('My companies') }} </a></li>
                                            <li class="parent"><a href="{{ lurl('account/my-posts') }}"><i
                                                            class="icon-th-thumb"></i> {{ t('My ads') }} </a></li>
                                            <li class="parent"><a href="{{ lurl('account/pending-approval') }}"><i
                                                            class="icon-hourglass"></i> {{ t('Pending approval') }} </a></li>
                                            <li class="parent"><a href="{{ lurl('account/archived') }}"><i
                                                            class="icon-folder-close"></i> {{ t('Archived ads') }}</a></li>
                                            <li class="parent">
                                                <a href="{{ lurl('account/conversations') }}">
                                                    <i class="icon-mail-1"></i> {{ t('Conversations') }}
                                                    <span class="badge badge-important count-conversations-with-new-messages">0</span>
                                                </a>
                                            </li>
                                            <li class="parent"><a href="{{ lurl('account/transactions') }}"><i
                                                            class="icon-money"></i> {{ t('Transactions') }}</a></li>
                                        @endif
                                        @if (in_array(auth()->user()->user_type_id, [2]))
                                            <li class="parent"><a href="{{ lurl('account/resumes') }}"><i
                                                            class="icon-attach"></i> {{ t('My resumes') }} </a></li>
                                            <li class="parent"><a href="{{ lurl('account/favourite') }}"><i
                                                            class="icon-heart"></i> {{ t('Favourite jobs') }} </a></li>
                                            <li class="parent"><a href="{{ lurl('account/saved-search') }}"><i
                                                            class="icon-star-circled"></i> {{ t('Saved searches') }} </a></li>
                                            <li class="parent">
                                                <a href="{{ lurl('account/conversations') }}">
                                                    <i class="icon-mail-1"></i> {{ t('Conversations') }}
                                                    <span class="badge badge-important count-conversations-with-new-messages">0</span>
                                                </a>
                                            </li>
                                        @endif
                                        <li class="parent">
                                            @if (app('impersonate')->isImpersonating())
                                                <a href="{{ route('impersonate.leave') }}">
                                                    <i class="icon-logout hidden-sm"></i>
                                                    {{ t('Leave') }}
                                                </a>
                                            @else
                                                <a href="{{ lurl(trans('routes.logout')) }}">
                                                    <i class="glyphicon glyphicon-off hidden-sm"></i>
                                                    {{ t('Log Out') }}
                                                </a>
                                            @endif
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <!-- mainmenu end -->
                </div>
            </div>
        </div>
    </div>
</div>
