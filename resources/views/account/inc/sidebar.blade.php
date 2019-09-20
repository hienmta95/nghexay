<aside>
    <div class="user-panel-sidebar">

        @if (isset($user))
            <div class="profile-userpic" style="display: flex">
                <img src="{!! $user->getAvatar(60,20) !!}" class="img-responsive img-circle img-thumbnail"
                     style="width: 80px;height:80px" alt="">
            </div>
            <!-- END SIDEBAR USERPIC -->
            <!-- SIDEBAR USER TITLE -->
            <div class="profile-usertitle">
                <div class="profile-usertitle-name text-center">
                    {!! $user->name !!}
                </div>
                <div class="profile-usertitle-job">
                    <a {!! ($pagePath=='') ? 'class="active"' : '' !!} href="{{ lurl('account') }}">
                        <i class="icon-home"></i> {{ t('Personal Home') }}
                    </a>
                </div>
                @if($user->user_type_id == 1)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="current-point">
                                Số điểm: {!! $user->point !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <!-- END SIDEBAR USER TITLE -->
            <!-- SIDEBAR BUTTONS -->
            <div class="profile-userbuttons">

            </div>
            <!-- /.collapse-box  -->
        <ul>
            <li>
                <a{!! ($pagePath=='dashboard') ? ' class="active"' : '' !!} href="{{ lurl('account/dashboard') }}
                ">
                <i class="icon-town-hall"></i> {{ t('Dashboard') }}&nbsp;
                </a>
            </li>
        </ul>

            @if (!empty($user->user_type_id) and $user->user_type_id != 0)


                @if (in_array($user->user_type_id, [1]))
                    @include('account.inc.sidebar-employer')
                @endif
                @if (in_array($user->user_type_id, [2]))
                    @include('account.inc.sidebar-candidate')
                @endif
                <?php /*<div class="collapse-box">
                    <h5 class="collapse-title">
                        {{ t('Terminate Account') }}&nbsp;
                        <a href="#TerminateAccount" data-toggle="collapse" class="pull-right"><i
                                    class="fa fa-angle-down"></i></a>
                    </h5>
                    <div class="panel-collapse collapse" id="TerminateAccount">
                        <ul class="acc-list">
                            <li>
                                <a {!! ($pagePath=='close') ? 'class="active"' : '' !!} href="{{ lurl('account/close') }}">
                                    <i class="icon-cancel-circled "></i> {{ t('Close account') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>*/?>
                <!-- /.collapse-box  -->
            @endif
        @endif

    </div>
    <!-- /.inner-box  -->
</aside>
