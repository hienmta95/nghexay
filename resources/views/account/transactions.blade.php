@extends('layouts.account')

@section('content')

    <div class="inner-box">
        <h2 class="title-2"><i class="icon-money"></i> {{ t('Transactions') }} </h2>

        <div style="clear:both"></div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th><span>ID</span></th>
                    <th>{{ t('Description') }}</th>
                    <th>{{ t('Payment Method') }}</th>
                    <th>{{ t('Value') }}</th>
                    <th>{{ t('Date') }}</th>
                    <th>{{ t('Status') }}</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (isset($transactions) && $transactions->count() > 0):
                foreach($transactions as $key => $transaction):

                // Fixed 2
                if (empty($transaction->post)) continue;
                if (!$countries->has($transaction->post->country_code)) continue;

                if (empty($transaction->package)) continue;
                ?>
                <tr>
                    <td>#{{ $transaction->id }}</td>
                    <td>
                        <?php $attr = ['slug' => slugify($transaction->post->title), 'id' => $transaction->post->id]; ?>
                        <a href="{{ lurl($transaction->post->uri, $attr) }}">{{ $transaction->post->title }}</a><br>
                        <strong>{{ t('Type') }}</strong> {{ $transaction->package->short_name }} <br>
                        <strong>{{ t('Duration') }}</strong> {{ $transaction->package->duration }} {{ t('days') }}
                    </td>
                    <td>
                        @if ($transaction->active == 1)
                            @if (!empty($transaction->paymentMethod))
                                {{ t('Paid by') }} {{ $transaction->paymentMethod->display_name }}
                            @else
                                {{ t('Paid by') }} --
                            @endif
                        @else
                            {{ t('Pending payment') }}
                        @endif
                    </td>
                    <td>{!! ((!empty($transaction->package->currency)) ? $transaction->package->currency->symbol : '') . '' . $transaction->package->price !!}</td>
                    <td>{{ $transaction->created_at->formatLocalized(config('settings.app.default_datetime_format')) }}</td>
                    <td>
                        @if ($transaction->active == 1)
                            <span class="label label-success">{{ t('Done') }}</span>
                        @else
                            <span class="label label-info">{{ t('Pending') }}</span>
                        @endif
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-bar text-center">
            {{ (isset($transactions)) ? $transactions->links() : '' }}
        </div>

        <div style="clear:both"></div>

    </div>

@endsection

@section('after_scripts')
@endsection