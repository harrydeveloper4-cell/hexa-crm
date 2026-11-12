<!DOCTYPE html>
<html>

<head>
    <title>{{ env('APP_NAME') }} - Order Details</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style>
        @import url(https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap);

        *,
        ::after,
        ::before {
            -webkit-box-sizing: border-box;
            box-sizing: border-box
        }

        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0
        }

        a {
            background-color: transparent
        }

        b {
            font-weight: bolder
        }

        img {
            border-style: none
        }

        button {
            font-family: inherit;
            font-size: 100%;
            line-height: 1.15;
            margin: 0
        }

        button {
            overflow: visible
        }

        button {
            text-transform: none
        }

        button {
            -webkit-appearance: button
        }

        button::-moz-focus-inner {
            border-style: none;
            padding: 0
        }

        button:-moz-focusring {
            outline: 1px dotted ButtonText
        }

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            font: inherit
        }

        body,
        html {
            color: #777;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5em;
            overflow-x: hidden;
            background-color: #f5f7ff
        }

        p,
        div {
            margin-top: 0;
            line-height: 1.5em
        }

        p {
            margin-bottom: 15px
        }

        img {
            border: 0;
            max-width: 50%;
            height: auto;
            vertical-align: middle
        }

        a {
            color: inherit;
            text-decoration: none;
            -webkit-transition: all .3s ease;
            transition: all .3s ease
        }

        a:hover {
            color: #2ad19d
        }

        button {
            color: inherit;
            -webkit-transition: all .3s ease;
            transition: all .3s ease
        }

        a:hover {
            text-decoration: none;
            color: inherit
        }

        table {
            width: 100%;
            caption-side: bottom;
            border-collapse: collapse
        }

        th {
            text-align: left
        }

        td {
            border-top: 1px solid #eaeaea
        }

        td,
        th {
            padding: 10px 15px;
            line-height: 1.55em
        }

        b {
            font-weight: bold
        }

        .cs-f16 {
            font-size: 16px
        }

        .cs-semi_bold {
            font-weight: 600
        }

        .cs-bold {
            font-weight: 700
        }

        .cs-m0 {
            margin: 0
        }

        .cs-mb0 {
            margin-bottom: 0
        }

        .cs-mb5 {
            margin-bottom: 5px
        }

        .cs-mb10 {
            margin-bottom: 10px
        }

        .cs-mb25 {
            margin-bottom: 25px
        }

        .cs-width_1 {
            width: 8.33333333%
        }

        .cs-width_2 {
            width: 16.66666667%
        }

        .cs-width_3 {
            width: 25%
        }

        .cs-width_4 {
            width: 33.33333333%
        }

        .cs-primary_color {
            color: #111
        }

        .cs-focus_bg {
            background: #f6f6f6
        }

        .cs-container {
            max-width: 880px;
            padding: 30px 15px;
            margin-left: auto;
            margin-right: auto
        }

        .cs-text_right {
            text-align: right
        }

        .cs-border_top_0 {
            border-top: 0
        }

        .cs-border_top {
            border-top: 1px solid #eaeaea
        }

        .cs-border_left {
            border-left: 1px solid #eaeaea
        }

        .cs-round_border {
            border: 1px solid #eaeaea;
            overflow: hidden;
            border-radius: 6px
        }

        .cs-border_none {
            border: none
        }

        .cs-invoice.cs-style1 {
            background: #fff;
            border-radius: 10px;
            padding: 50px
        }

        .cs-invoice.cs-style1 .cs-invoice_head {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between
        }

        .cs-invoice.cs-style1 .cs-invoice_head.cs-type1 {
            -webkit-box-align: end;
            -ms-flex-align: end;
            align-items: flex-end;
            padding-bottom: 25px;
            border-bottom: 1px solid #eaeaea
        }

        .cs-invoice.cs-style1 .cs-invoice_footer {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex
        }

        .cs-invoice.cs-style1 .cs-invoice_footer table {
            margin-top: -1px
        }

        .cs-invoice.cs-style1 .cs-left_footer {
            width: 55%;
            padding: 10px 15px
        }

        .cs-invoice.cs-style1 .cs-right_footer {
            width: 46%
        }

        .cs-invoice.cs-style1 .cs-note {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: start;
            -ms-flex-align: start;
            align-items: flex-start;
            margin-top: 40px
        }

        .cs-invoice.cs-style1 .cs-note_left {
            margin-right: 10px;
            margin-top: 6px;
            margin-left: -5px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex
        }

        .cs-invoice.cs-style1 .cs-note_left svg {
            width: 32px
        }

        .cs-invoice.cs-style1 .cs-invoice_left {
            max-width: 55%
        }

        .cs-invoice_btns {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            margin-top: 30px
        }

        .cs-invoice_btns .cs-invoice_btn:first-child {
            border-radius: 5px 0 0 5px
        }

        .cs-invoice_btns .cs-invoice_btn:last-child {
            border-radius: 0 5px 5px 0
        }

        .cs-invoice_btn {
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            border: none;
            font-weight: 600;
            padding: 8px 20px;
            cursor: pointer
        }

        .cs-invoice_btn svg {
            width: 24px;
            margin-right: 5px
        }

        .cs-invoice_btn.cs-color1 {
            color: #111;
            background: rgba(42, 209, 157, .15)
        }

        .cs-invoice_btn.cs-color1:hover {
            background-color: rgba(42, 209, 157, .3)
        }

        .cs-invoice_btn.cs-color2 {
            color: #fff;
            background: #2ad19d
        }

        .cs-invoice_btn.cs-color2:hover {
            background-color: rgba(42, 209, 157, .8)
        }

        .cs-table_responsive {
            overflow-x: auto
        }

        .cs-table_responsive>table {
            min-width: 600px
        }

        .cs-bar_list li:not(:last-child) {
            margin-bottom: 10px
        }

        .cs-table.cs-style2 tr:not(:first-child) {
            border-top: 1px dashed #eaeaea
        }

        .cs-list.cs-style1 li:not(:last-child) {
            border-bottom: 1px dashed #eaeaea
        }

        .cs-table.cs-style1 .cs-table.cs-style1 tr:not(:first-child) td {
            border-color: #eaeaea
        }

        @media (max-width:767px) {
            .cs-mobile_hide {
                display: none
            }

            .cs-invoice.cs-style1 {
                padding: 30px 20px
            }

            .cs-invoice.cs-style1 .cs-right_footer {
                width: 100%
            }
        }

        @media (max-width:500px) {
            .cs-invoice.cs-style1 .cs-logo {
                margin-bottom: 10px
            }

            .cs-invoice.cs-style1 .cs-invoice_head {
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column
            }

            .cs-invoice.cs-style1 .cs-invoice_head.cs-type1 {
                -webkit-box-orient: vertical;
                -webkit-box-direction: reverse;
                -ms-flex-direction: column-reverse;
                flex-direction: column-reverse;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                text-align: center
            }

            .cs-invoice.cs-style1 .cs-invoice_head .cs-invoice.cs-style1 .cs-invoice_left {
                max-width: 100%
            }
        }
    </style>

</head>

<body>
    <div class="cs-container">
        <div class="cs-invoice cs-style1">
            <div class="cs-invoice_in" id="download_section">
                <div class="cs-invoice_head cs-type1 cs-mb25">
                    <div class="cs-invoice_left">
                        <p class="cs-invoice_number cs-primary_color cs-mb5 cs-f16"><b class="cs-primary_color">Payment Successful - Order Details:</b></p><br>
                        <p class="cs-invoice_number cs-primary_color cs-mb5 cs-f16"><b class="cs-primary_color">Order No:</b> #{{ $order->order_number }}</p>
                        <p class="cs-invoice_date cs-primary_color cs-m0"><b class="cs-primary_color">Date: </b>{{ \Carbon\Carbon::now()->format('d.m.Y') }}</p>
                    </div>
                    <div class="cs-invoice_right cs-text_right">
                        <div class="cs-logo cs-mb5">
                            <img src="{{ asset($order->brand_details->logo) }}" alt="Logo">
                        </div>
                    </div>
                </div>
                <div class="cs-invoice_head cs-mb10">
                    <div class="cs-invoice_left">
                        <b class="cs-primary_color">Invoice To:</b>
                        <p>
                            Name: {{ $order->user_details->firstname.' '.$order->user_details->lastname }}<br>
                            Email: {{ $order->customer_email }}<br>
                            Phone Number: {{ $order->user_details->billing_phonenumber }}<br>
                            {{-- @if (!is_null($order->customer_business_name))
                            Customer Business Name: {{ $order->customer_business_name }}<br>
                            @endif
                            @if (!is_null($order->customer_vat_number))
                            Customer VAT Number: {{ $order->customer_vat_number }}<br>
                            @endif --}}
                        </p>
                    </div>
                    <div style="padding-left:245px;">
                        <b class="cs-primary_color">Pay To:</b>
                        <p>
                            {{ $order->brand_details->name ?? '' }} <br>
                            Address: {{ $order->brand_details->address_one ?? '' }} <br>
                            Address: {{ $order->brand_details->address_two ?? '' }} <br>
                            Call now: {{ $order->brand_details->phone_call ?? '' }} <br>
                            {{ env('MAIL_FROM_ADDRESS') }}
                        </p>
                    </div>
                </div>
                <div class="cs-table cs-style1">
                    <div class="cs-round_border">
                        <div class="cs-table_responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Package Name</th>
                                        <th class="cs-width_4 cs-semi_bold cs-primary_color cs-focus_bg">Order Description</th>
                                        <th class="cs-width_2 cs-semi_bold cs-primary_color cs-focus_bg">Qty</th>
                                        <th class="cs-width_1 cs-semi_bold cs-primary_color cs-focus_bg">Price</th>
                                        <th class="cs-width_2 cs-semi_bold cs-primary_color cs-focus_bg cs-text_right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->packages as $package)
                                        <tr>
                                            <td class="col-sm-7">{{ $package->package_name }}</td>
                                            <td class="cs-width_4">{{ $order->description }}</td>
                                            <td class="cs-width_2">Custom</td>
                                            <td class="cs-width_1">Custom</td>
                                            <td class="cs-width_2 cs-text_right">Custom</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="cs-invoice_footer cs-border_top">
                            <div class="cs-left_footer">
                                {{--
                                <p class="cs-m0"> 
                                    <a href="{{env('ASSET_URL').'/'.$order->pdf_agreement}}" class="cs-invoice_btn cs-color2" target="_blank">
                                        Download Agreement
                                    </a>
                                </p>
                                --}}
                            </div>
                            <div class="cs-right_footer">
                                <table>
                                    <tbody>
                                        <tr class="cs-border_left">
                                            <td class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Subtotal</td>
                                            <td class="cs-width_3 cs-semi_bold cs-focus_bg cs-primary_color cs-text_right">{{ $order->sale_currency }} {{ round($order->sale_amount,2) }}</td>
                                        </tr>
                                        {{-- <tr class="cs-border_left">
                                            <td class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Tax</td> --}}
                                            {{-- <td class="cs-width_3 cs-semi_bold cs-focus_bg cs-primary_color cs-text_right">{{ $order->tax ?? '' }}%</td> --}}
                                        {{-- </tr> --}}
                                        <?php 
                                            // Assuming $order->sale_amount and $payment->tax are available
                                            $price = $order->sale_amount;
                                            // $tax = $order->tax ?? 1;

                                            // Calculate the total amount including tax
                                            $subtotal = $price;
                                            // $taxAmount = ($tax / 100) * $price;
                                            // $total = $subtotal + $taxAmount;
                                            $total = $subtotal;
                                        ?>
                                        <tr class="cs-border_left">
                                            <td class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Total</td>
                                            <td class="cs-width_3 cs-semi_bold cs-focus_bg cs-primary_color cs-text_right">{{ $order->sale_currency }} {{ round($total,2) }}</td>
                                        </tr>
                                        {{-- <tr class="cs-border_left">
                                            <td class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Remaining</td>
                                            <td class="cs-width_3 cs-semi_bold cs-focus_bg cs-primary_color cs-text_right">{{ $order->sale_currency }} {{ round($payment->remaining,2) }}</td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>