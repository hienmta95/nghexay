@extends('layouts.account')

@section('content')

    <div class="inner-box">
        <h2 class="title-2"><i class="icon-cancel-circled "></i> {{ t('Close account') }} </h2>
        <p>{{ t('You are sure you want to close your account?') }}</p>

        @if (isset($user) and $user->can(\App\Models\Permission::getStaffPermissions()))
            <span style="color: red; font-weight: bold;">{{ t('Admin users can\'t be deleted by this way.') }}</span>
        @else
            <form role="form" method="POST" action="{{ lurl('account/close') }}">
                {!! csrf_field() !!}
                <div>
                    <label class="radio-inline">
                        <input type="radio" name="close_account_confirmation" id="closeAccountConfirmation1"
                               value="1"> {{ t('Yes') }}
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="close_account_confirmation" id="closeAccountConfirmation0" value="0"
                               checked> {{ t('No') }}
                    </label>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">{{ t('Submit') }}</button>
            </form>
        @endif

    </div>
    <!--/.inner-box-->

@endsection
