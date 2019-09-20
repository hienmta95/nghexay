<div class="collapse-box mb-0">
    <a href="#MyAds" data-toggle="collapse" ><h5 class="collapse-title">
        Tuyển dụng
        <i class="fa fa-angle-down pull-right"></i>
    </h5></a>
    <div class="panel-collapse collapse {!! in_array($pagePath,['dashboard','favourite','suitable','saved-search','archived','conversations']) ? ' in' : '' !!}"
         id="MyAds">
        <ul class="acc-list">
            <!-- COMPANY -->

            @if (in_array($user->user_type_id, [2]))
                <li>
                    <a{!! ($pagePath=='conversations') ? ' class="active"' : '' !!} href="{{ lurl('account/conversations') }}
                    ">
                    <i class="icon-mail-1"></i> Đã ứng tuyển
                    <span class="badge">
												{{ isset($countConversations) ? \App\Helpers\Number::short($countConversations) : 0 }}
											</span>&nbsp;
                    <span class="badge badge-important count-conversations-with-new-messages">0</span>
                    </a>
                </li>


                <li>
                    <a{!! ($pagePath=='favourite') ? ' class="active"' : '' !!} href="{{ lurl('account/favourite') }}
                    ">
                    <i class="icon-heart"></i> {{ t('Saved jobs') }}&nbsp;
                    <span class="badge">
											{{ isset($countFavouritePosts) ? \App\Helpers\Number::short($countFavouritePosts) : 0 }}
										</span>
                    </a>
                </li>
                <li>
                    <a{!! ($pagePath=='suitable') ? ' class="active"' : '' !!} href="{{ lurl('account/suitable') }}
                    ">
                    <i class="icon-heart"></i> {{ t('Suitable jobs') }}&nbsp;
                    </a>
                </li>
                <?php /*<li>
                    <a{!! ($pagePath=='saved-search') ? ' class="active"' : '' !!} href="{{ lurl('account/saved-search') }}
                    ">
                    <i class="icon-star-circled"></i> {{ t('Saved searches') }}&nbsp;
                    <span class="badge">
											{{ isset($countSavedSearch) ? \App\Helpers\Number::short($countSavedSearch) : 0 }}
										</span>
                    </a>
                </li>*/?>

                @endif


        </ul>
    </div>
</div>

<div class="collapse-box mb-0">
    <a href="#briefcase" data-toggle="collapse">
    <h5 class="collapse-title">
        Quản lý hồ sơ
       <i
                    class="fa fa-angle-down pull-right"></i>
    </h5></a>
    <div class="panel-collapse collapse {!! in_array($pagePath,['resumes','']) ? ' in' : '' !!}"
         id="briefcase">
        <ul class="acc-list">
            <li>
                <a{!! ($pagePath=='resumes') ? ' class="active"' : '' !!} href="{{ lurl('account/resumes') }}
                ">
                <i class="icon-attach"></i> {{ t('My resumes') }}&nbsp;
                <span class="badge">
											{{ isset($countResumes) ? \App\Helpers\Number::short($countResumes) : 0 }}
										</span>
                </a>
            </li>
            <li>
                <a {!! ($pagePath=='') ? 'class="active"' : '' !!} href="{{ lurl('account') }}">
                    <i class="icon-home"></i> {{ t('Personal Home') }}
                </a>
            </li>



        </ul>
    </div>
</div>

