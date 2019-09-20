@if (!empty($user->user_type_id) and $user->user_type_id != 0)

    <div class="collapse-box mb-0">

            <a href="#MyAds" data-toggle="collapse" aria-expanded="true">
                <h5 class="collapse-title">Tuyển dụng  <i class="fa fa-angle-down pull-right"></i></h5>
            </a>

        <div class="panel-collapse collapse in {!! in_array($pagePath,['dashboard','companies','my-posts','pending-approval','archived']) ? ' in' : '' !!}"
             id="MyAds">
            <ul class="acc-list">
                <!-- COMPANY -->


                @if (in_array($user->user_type_id, [1]))
                    <li>
                        <a{!! ($pagePath=='companies') ? ' class="active"' : '' !!} href="{{ lurl('account/companies') }}
                        ">
                        <i class="icon-town-hall"></i> {{ t('My companies') }}&nbsp;
                        <span class="badge">
											{{ isset($countCompanies) ? \App\Helpers\Number::short($countCompanies) : 0 }}
										</span>
                        </a>
                    </li>

                    <li>
                        <a{!! ($pagePath=='my-posts') ? ' class="active"' : '' !!} href="{{ lurl('account/my-posts') }}
                        ">
                        <i class="icon-docs"></i> {{ t('My ads') }}&nbsp;
                        <span class="badge">
											{{ isset($countMyPosts) ? \App\Helpers\Number::short($countMyPosts) : 0 }}
										</span>
                        </a>
                    </li>
                    <?php /*<li>
                                    <a{!! ($pagePath=='pending-approval') ? ' class="active"' : '' !!} href="{{ lurl('account/pending-approval') }}
                                    ">
                                    <i class="icon-hourglass"></i> {{ t('Pending approval') }}&nbsp;
                                    <span class="badge">
											{{ isset($countPendingPosts) ? \App\Helpers\Number::short($countPendingPosts) : 0 }}
										</span>
                                    </a>
                                </li>

                                <li>
                                    <a{!! ($pagePath=='archived') ? ' class="active"' : '' !!} href="{{ lurl('account/archived') }}
                                    ">
                                    <i class="icon-folder-close"></i> {{ t('Archived ads') }}&nbsp;
                                    <span class="badge">
											{{ isset($countArchivedPosts) ? \App\Helpers\Number::short($countArchivedPosts) : 0 }}
										</span>
                                    </a>
                                </li>*/?>
                @endif
            <!-- CANDIDATE -->
                @if (in_array($user->user_type_id, [2]))

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
                        <a{!! ($pagePath=='favourite') ? ' class="active"' : '' !!} href="{{ lurl('account/favourite') }}
                        ">
                        <i class="icon-heart"></i> {{ t('Favourite jobs') }}&nbsp;
                        <span class="badge">
											{{ isset($countFavouritePosts) ? \App\Helpers\Number::short($countFavouritePosts) : 0 }}
										</span>
                        </a>
                    </li>
                    <li>
                        <a{!! ($pagePath=='saved-search') ? ' class="active"' : '' !!} href="{{ lurl('account/saved-search') }}
                        ">
                        <i class="icon-star-circled"></i> {{ t('Saved searches') }}&nbsp;
                        <span class="badge">
											{{ isset($countSavedSearch) ? \App\Helpers\Number::short($countSavedSearch) : 0 }}
										</span>
                        </a>
                    </li>
                    <li>
                        <a{!! ($pagePath=='conversations') ? ' class="active"' : '' !!} href="{{ lurl('account/conversations') }}
                        ">
                        <i class="icon-mail-1"></i> {{ t('Conversations') }}&nbsp;
                        <span class="badge">
											{{ isset($countConversations) ? \App\Helpers\Number::short($countConversations) : 0 }}
										</span>&nbsp;
                        <span class="badge badge-important count-conversations-with-new-messages">0</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <!-- /.collapse-box  -->
    <!-- COMPANY -->
    @if (in_array($user->user_type_id, [1]))

        <div class="collapse-box mb-0">

                <a href="#briefcase" data-toggle="collapse" aria-expanded="true">
                    <h5 class="collapse-title">
                        Quản lý hồ sơ
                    <i  class="fa fa-angle-down pull-right"></i>
            </h5></a>
            <div class="panel-collapse collapse {!! in_array($pagePath,['search','saved-candidates','viewed-candidates','conversations']) ? ' in' : '' !!}"
                 id="briefcase">
                <ul class="acc-list">

                    <li>
                        <a{!! ($pagePath=='search') ? ' class="active"' : '' !!} href="{{ lurl('account/search') }}
                        ">
                        <i class="icon-user-1"></i> {{ t('Search candidates') }}&nbsp;
                        </a>
                    </li>

                    <li>
                        <a{!! ($pagePath=='saved-candidates') ? ' class="active"' : '' !!} href="{{ lurl('account/saved-candidates') }}
                        ">
                        <i class="icon-star-circled"></i> {{ t('Saved candidates') }}&nbsp;
                        <span class="badge">
											{{ isset($countSavedCandidate) ? \App\Helpers\Number::short($countSavedCandidate) : 0 }}
										</span>
                        </a>
                    </li>
                    <li>
                        <a{!! ($pagePath=='viewed-candidates') ? ' class="active"' : '' !!} href="{{ lurl('account/viewed-candidates') }}
                        ">
                        <i class="icon-star-circled"></i> {{ t('Viewed candidates') }}&nbsp;
                        <span class="badge">
											{{ isset($countViewedCandidate) ? \App\Helpers\Number::short($countViewedCandidate) : 0 }}
										</span>
                        </a>
                    </li>

                    <li>
                        <a{!! ($pagePath=='conversations') ? ' class="active"' : '' !!} href="{{ lurl('account/conversations') }}
                        ">
                        <i class="icon-mail-1"></i> {{ t('Conversations') }}&nbsp;
                        <span class="badge">
												{{ isset($countConversations) ? \App\Helpers\Number::short($countConversations) : 0 }}
											</span>&nbsp;
                        <span class="badge badge-important count-conversations-with-new-messages">0</span>
                        </a>
                    </li>


                </ul>
            </div>
        </div>


        <div class="collapse-box mb-0">

            <a href="#other" data-toggle="collapse"  aria-expanded="true">
            <h5 class="collapse-title">
                Khác<i class="fa fa-angle-down pull-right"></i>
            </h5>
            </a>
            <div class="panel-collapse collapse" id="other">
                <ul class="acc-list">
                    <!-- COMPANY -->
                    @if (in_array($user->user_type_id, [1]))
                        <li>
                            <a{!! ($pagePath=='conversations') ? ' class="active"' : '' !!} href="{{ lurl('account/conversations') }}
                            ">
                            <i class="icon-mail-1"></i> {{ t('Conversations') }}&nbsp;
                            <span class="badge">
												{{ isset($countConversations) ? \App\Helpers\Number::short($countConversations) : 0 }}
											</span>&nbsp;
                            <span class="badge badge-important count-conversations-with-new-messages">0</span>
                            </a>
                        </li>
                        <li>
                            <a{!! ($pagePath=='transactions') ? ' class="active"' : '' !!} href="{{ lurl('account/transactions') }}
                            ">
                            <i class="icon-money"></i> {{ t('Transactions') }}&nbsp;
                            <span class="badge">
											{{ isset($countTransactions) ? \App\Helpers\Number::short($countTransactions) : 0 }}
										</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    @endif
@endif
