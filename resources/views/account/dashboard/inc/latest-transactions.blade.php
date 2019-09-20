<div class="card card-default dashboard-block">
    <div class="card-heading">
        <h4 class="card-title">Danh sách dịch vụ</h4>
        <a class="label label-primary pull-right" href="/page/bang-gia">Xem bảng giá</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-gray">
                <tr>
                    <th class="text-center"><span>ID</span></th>
                    <th class="text-center">{{ t('Description') }}</th>
                    <th class="text-center">{{ t('Payment Method') }}</th>
                    <th class="text-center">{{ t('Value') }}</th>
                    <th class="text-center">{{ t('Date') }}</th>
                    <th class="text-center">{{ t('Status') }}</th>
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
                    <td class="text-center">#{{ $transaction->id }}</td>
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
                    <td class="text-center">{!! ((!empty($transaction->package->currency)) ? $transaction->package->currency->symbol : '') . '' . $transaction->package->price !!}</td>
                    <td class="text-center">{{ $transaction->created_at->formatLocalized(config('settings.app.default_datetime_format')) }}</td>
                    <td class="text-center">
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
    </div>
</div>
