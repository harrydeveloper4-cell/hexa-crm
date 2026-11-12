@foreach ($transactions as $key => $transaction)
    <tr>
        <td>{{ $transaction->id }}</td>
        <td>{{ $transaction->orders->order_number }}</td>
        <td>{{ $transaction->orders->sale_amount . ' ' . $transaction->orders->sale_currency }}
        </td>
        <td>{{ $transaction->orders->payment_gateway }} </td>
        <td>{{ date('d/m/Y H:i', strtotime($transaction->created_at)) }}</td>

        <td>
            <a
                href = "{{ route('admin.orders.show', ['id' => $transaction->order_id]) }}"><i
                    class = "icon-eye"></i></a>
            @if ($transaction->orders->payment_gateway == 'Stripe' || $transaction->orders->payment_gateway == 'Authorize.net')
                <a class = "payment-reoccur" href = "javascript::void(0)"
                    data-brand = "{{ $transaction->orders->brand_name }}"
                    data-email = "{{ $transaction->email }}"
                    data-ordernumber = "{{ $transaction->orders->order_number }}"
                    data-order = "{{ $transaction->order_id }}"
                    data-merchant = "{{ strtolower($transaction->orders->payment_gateway) }}"
                    data-currency = "{{ $transaction->orders->sale_currency }}"
                    data-toggle="modal" data-target="#exampleModalCenter"><i
                    class = "icon-refresh"></i></a>
            @endif
    </tr>
@endforeach
