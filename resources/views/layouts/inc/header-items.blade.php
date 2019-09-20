<div class="navbar-header">
    <?php
        $segment = request()->segment(1);
    ?>

    @if($segment == 'account')
    <button class="navbar-toggle pull-left ml-3 d-block d-lg-none"  type="button"  id="menu-toggle">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
        @endif
    {{-- Toggle Nav --}}
    <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>

    <?php /*
				@if (getSegment(1) != trans('routes.countries'))
					@if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
						@if (!empty(config('country.icode')))
							@if (file_exists(public_path().'/images/flags/24/'.config('country.icode').'.png'))
								<button class="flag-menu country-flag visible-xs btn btn-default hidden" href="#selectCountry" data-toggle="modal" >
									<img src="{{ url('images/flags/24/'.config('country.icode').'.png') . getPictureVersion() }}" style="float: left;">
									<span class="caret hidden-xs"></span>
								</button>
							@endif
						@endif
					@endif
				@endif*/?>

    {{-- Logo --}}
    <a href="{{ lurl('/') }}" class="navbar-brand logo logo-title">
        <img src="{{ \Storage::url(config('settings.app.logo')) . getPictureVersion() }}"
             alt="{{ strtolower(config('settings.app.app_name')) }}" class="tooltipHere main-logo" title=""
             data-placement="bottom"
             data-toggle="tooltip"
             data-original-title="{!! isset($logoLabel) ? $logoLabel : '' !!}"/>
    </a>
</div>
<div class="navbar-collapse collapse">
    <?php /*<ul class="nav navbar-nav navbar-left">
					{{-- Country Flag --}}
					@if (getSegment(1) != trans('routes.countries'))
						@if (config('settings.geo_location.country_flag_activation'))
							@if (!empty(config('country.icode')))
								@if (file_exists(public_path().'/images/flags/32/'.config('country.icode').'.png'))
									<li class="flag-menu country-flag tooltipHere hidden-xs" data-toggle="tooltip" data-placement="{{ (config('lang.direction') == 'rtl') ? 'bottom' : 'right' }}" {!! $multiCountriesLabel !!}>
										@if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
											<a href="#selectCountry" data-toggle="modal">
												<img class="flag-icon" src="{{ url('images/flags/32/'.config('country.icode').'.png') . getPictureVersion() }}" style="float: left;">
												<span class="caret hidden-sm"></span>
											</a>
										@else
											<a style="cursor: default;">
												<img class="flag-icon" src="{{ url('images/flags/32/'.config('country.icode').'.png') . getPictureVersion() }}" style="float: left;">
											</a>
										@endif
									</li>
								@endif
							@endif
						@endif
					@endif
					<li>
						<?php $attr = ['countryCode' => config('country.icode')]; ?>
						<a href="{{ lurl(trans('routes.v-search', $attr), $attr) }}">
							<i class="icon-th-list-2 hidden-sm"></i>
							{{ t('Browse Jobs') }}
						</a>
					</li>
				</ul>*/?>
    <ul class="nav navbar-nav navbar-right">

        <li><a href="{{ url('/') }}">
                <p class="text-icon"><i class="fa fa-home"></i></p>
                <p class="text-icon"> {{ t('Home') }}</p></a>
        </li>
        {{-- @if (getSegment(1) != trans('routes.countries'))
             @if (config('settings.geo_location.country_flag_activation'))
                 @if (!empty(config('country.icode')))
                     @if (file_exists(public_path().'/images/flags/32/'.config('country.icode').'.png'))
                         <li class="flag-menu country-flag tooltipHere hidden-xs" data-toggle="tooltip"
                             data-placement="{{ (config('lang.direction') == 'rtl') ? 'bottom' : 'right' }}" {!! $multiCountriesLabel !!}>
                             @if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
                                 <a href="#selectCountry" data-toggle="modal">
                                     <img class="flag-icon"
                                          src="{{ url('images/flags/32/'.config('country.icode').'.png') . getPictureVersion() }}"
                                          style="float: left;">
                                     <span class="caret hidden-sm"></span>
                                 </a>
                             @else
                                 <a style="cursor: default;">
                                     <img class="flag-icon"
                                          src="{{ url('images/flags/32/'.config('country.icode').'.png') . getPictureVersion() }}"
                                          style="float: left;">
                                 </a>
                             @endif
                         </li>
                     @endif
                 @endif
             @endif
         @endif--}}
        <li>
            <?php $attr = ['countryCode' => config('country.icode')]; ?>
            <a href="{{ lurl(trans('routes.v-search', $attr), $attr) }}">
                <p class="text-icon"><i class="fa fa-briefcase"></i></p>
                <p class="text-icon">{{ t('Browse Jobs') }}</p></a></li>
        <li><a href="{{ url('/ung-vien') }}">
                <p class="text-icon"><i class="fa fa-user"></i></p>
                <p class="text-icon"> {{ t('Job seekers') }}</p></a>
        </li>
        <li>
            <a href="{{ lurl(trans('routes.v-companies-list', $attr), $attr) }}">
                <p class="text-icon"><i class="fa fa-building-o"></i></p>
                <p class="text-icon"> {{ t('Company') }}</p></a>
        </li>
        <li><a href="{{ url('/page/pricing') }}">
                <p class="text-icon"><i class="fa fa-table"></i></p>
                <p class="text-icon"> {{ t('Pricing') }}</p></a>
        </li>
        @if (!auth()->check())
            <li>
                @if (config('settings.security.login_open_in_modal'))
                    <a href="#quickLogin" data-toggle="modal">
                        <p class="text-icon"><i class="icon-user fa"></i></p>
                        <p class="text-icon">{{ t('Log In') }}</p>
                    </a>
                @else
                    <a href="{{ lurl(trans('routes.login')) }}">
                        <p class="text-icon"><i
                                    class="icon-user fa"></i></p>
                        <p class="text-icon">{{ t('Log In') }}</p>
                    </a>
                @endif
            </li>

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <p class="text-icon"><i class="fa fa-key"></i></p>
                    <p class="text-icon"> {{ t('Register') }}</p></a>
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{!! url('nha-tuyen-dung') !!}">
                            <p class="text-icon"> Nhà tuyển dụng</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ lurl(trans('routes.register')) }}?type=2">
                            <p class="text-icon"> Ứng viên</p>
                        </a>
                    </li>
                </ul>
            </li>
        @else

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="margin-top: -4px">
                    <p class="text-icon"><i class="icon-user fa hidden-sm"></i></p>
                    <p class="text-icon"><span>{{ trans('global.My Account') }}</span>
                        <span class="badge badge-important count-conversations-with-new-messages">0</span>
                        <i class="icon-down-open-big fa hidden-sm"></i></p>
                </a>
                <ul class="dropdown-menu user-menu">
                    <li class="active"><a href="{{ lurl('account/dashboard') }}"><i
                                    class="icon-home"></i> {{ t('Personal Home') }}</a></li>
                    @if (in_array(auth()->user()->user_type_id, [1]))
                        <li><a href="{{ lurl('account/companies') }}"><i
                                        class="icon-town-hall"></i> {{ t('My companies') }} </a></li>
                        <li><a href="{{ lurl('account/my-posts') }}"><i
                                        class="icon-th-thumb"></i> {{ t('My ads') }} </a></li>
                        <li><a href="{{ lurl('account/pending-approval') }}"><i
                                        class="icon-hourglass"></i> {{ t('Pending approval') }} </a></li>
                        <li><a href="{{ lurl('account/archived') }}"><i
                                        class="icon-folder-close"></i> {{ t('Archived ads') }}</a></li>
                        <li>
                            <a href="{{ lurl('account/conversations') }}">
                                <i class="icon-mail-1"></i> {{ t('Conversations') }}
                                <span class="badge badge-important count-conversations-with-new-messages">0</span>
                            </a>
                        </li>
                        <li><a href="{{ lurl('account/transactions') }}"><i
                                        class="icon-money"></i> {{ t('Transactions') }}</a></li>
                    @endif
                    @if (in_array(auth()->user()->user_type_id, [2]))
                        <li><a href="{{ lurl('account/resumes') }}"><i
                                        class="icon-attach"></i> {{ t('My resumes') }} </a></li>
                        <li><a href="{{ lurl('account/favourite') }}"><i
                                        class="icon-heart"></i> {{ t('Favourite jobs') }} </a></li>
                        <li><a href="{{ lurl('account/saved-search') }}"><i
                                        class="icon-star-circled"></i> {{ t('Saved searches') }} </a></li>
                        <li>
                            <a href="{{ lurl('account/conversations') }}">
                                <i class="icon-mail-1"></i> {{ t('Conversations') }}
                                <span class="badge badge-important count-conversations-with-new-messages">0</span>
                            </a>
                        </li>
                    @endif
                    <li>
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

        <?php /*@if (!auth()->check())
						<li class="postadd">
							@if (config('settings.single.guests_can_post_ads') != '1')
								<a class="btn btn-block btn-post btn-add-listing" href="#quickLogin" data-toggle="modal">
									<i class="fa fa-plus-circle"></i> {{ t('Create a Job ad') }}
								</a>
							@else
								<a class="btn btn-block btn-post btn-add-listing" href="{{ lurl('posts/create') }}">
									<i class="fa fa-plus-circle"></i> {{ t('Create a Job ad') }}
								</a>
							@endif
						</li>
					@else
						@if (in_array(auth()->user()->user_type_id, [1]))
							<li class="postadd">
								<a class="btn btn-block btn-post btn-add-listing" href="{{ lurl('posts/create') }}">
									<i class="fa fa-plus-circle"></i> {{ t('Create a Job ad') }}
								</a>
							</li>
						@endif
					@endif
                    */?>

        @auth
            @if (in_array(auth()->user()->user_type_id, [1]))
                <li class="postadd">
                    <a class="btn btn-block btn-post btn-add-listing" href="{{ lurl('posts/create') }}">
                        <i class="fa fa-plus-circle"></i> {{ t('Create a Job ad') }}
                    </a>
                </li>
            @endif
        @endauth

        <?php /*@include('layouts.inc.menu.select-language')*/?>

    </ul>
</div>
