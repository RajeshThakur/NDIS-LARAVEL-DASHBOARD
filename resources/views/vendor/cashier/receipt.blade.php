<!doctype html>
<html lang="en">
        
   <head>
      <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <title>Cloud Acess Pty Ltd</title>
        <style>
                h2 {
                    color: #2165B0;
                    font-size: 18px;
                    font-weight: 600;
                    margin-top: 25px;
                    margin-bottom: 0px;
                    margin: 0;
                }
                td,  li{
                    color: #2165B0;
                    }
                    th{
                    color: #2165B0;
                    }
                    td{
                    color: #2165B0;
                    /* white-space: nowrap;*/
                    padding: 6px 30px;
                    }
                    .custom-voice ul li {
                    list-style: none;
                    line-height: 22px;
                    font-size: 14px;
                }
                table.custom-table-pdf td span {
                    font-size: 14px;
                }
                .custom-voice ul {
                padding: 0;
                }
                table.custom-table td {
                padding: 0px;
                /*padding-left: 15px !important;*/
                text-align: left;
                }
                table.custom-table th {
                    border-bottom: 1px solid #2165B0;
                    padding: 8px;
                    font-size: 14px;
                    text-align: left;
                }
                table.pay-table-custom td {
                padding-left: 0;
                font-weight: 500;
                }
                table {
                border-spacing: 0;
                border-collapse: collapse;
                }
                table.custom-table-pdf td {
                    padding: 2px 16px !important;
                    padding-right: 12px;
                }
                table.table-footer td {
                    padding: 0px;
                    font-size: 14px;
                    line-height: 20px;
            /* padding-right: 20px; */
                }
                .table-border {
                    border-collapse: collapse !important;
                }
                table.table-border tr td {
                    padding: 8px 10px !important;
                    font-size: 14px;
                    border-bottom: 1px solid #2165B0;
                }
                table.table-footer p {
                    font-size: 12px;
                    margin: 0px 0px;
                }
                table.none-margin {
                    /* white-space: nowrap; */
                    margin-right: 0 !important;
                    /* width: 100% !important; */
                    margin-left: 51px;
                }
        </style>
   </head>

    <body style="width: 600px; margin: 0 auto;     font-family: 'Nunito', sans-serif;">
        <?php $data = $invoice->asStripeInvoice(); ?>
        <table border="0" cellpadding="0" cellspacing="0" class="email-temp custom-table" style="border-collapse: separate; width: 100%; text-align: center; padding: 0; margin-top:30px;">
            <tbody>
                <tr valign="top">
                    <td style=" padding-left: 0;">
                        <div class="column-first">
                        <div class="custom-voice">
                            <h2>Cloud Acess Pty Ltd</h2>
                            <ul>
                                <li>
                                    {{  $owner->email ?: $owner->name }}
                                </li>
                                <li>
                                    some address
                                </li>
                                <li>
                                    {{ $data->customer_address['country'] }}
                                </li>
                                <li>
                                    {{ $data->customer_phone }}
                                </li>
                                <li>
                                    {{ $data->customer_email }}
                                </li>
                            </ul>
                        </div>
                        <div class="custom-voice">
                            <h2>Bill to</h2>
                            <ul>
                                <li>
                                    {{ $data->customer_name }}
                                </li>
                                <li>
                                    {{ $data->customer_address['line1'] }}
                                </li>
                                <li>
                                    {{ $data->customer_address['line2'] }}
                                </li>
                                <li>
                                    {{ $data->customer_address['city'] }} {{ $data->customer_address['state'] }} {{ $data->customer_address['postal_code'] }}
                                </li>
                                <li>
                                    {{ $data->customer_address['country'] }}
                                </li>
                                <li>
                                    {{ $data->customer_phone }}
                                </li>
                                <li>
                                    {{ $data->customer_email }}
                                </li>
                            </ul>
                        </div>
                        </div>
                    </td>
                    <!-- Organization Name / Date -->
                    <td style="padding-right:0;">
                        <table class="none-margin" style="">
                            <tr style="">
                                        <td>
                                        <div class="custom-voice">
                                        <h2 style="  padding-right: 11px; text-align: right;"> Invoice</h2>
                                        </div>
                                    </td>
                        <tr>
                            <td style="padding-left: 0; ">
                                <table class="custom-table-pdf" style="">
                                </tr>
                                    <tr>
                                    <td style="padding-left: 0;"><span style="text-align: left;  display: inline-block;">Invoice number </span> </td>
                                    <td style="padding-left: 0; text-align: right; padding-right:0;"><span style="font-weight: bold; text-align: right; display: inline-block; text-align: right; padding-right:0;">{{ $id ?? $invoice->id }}</span> </td>
                                    </tr>
                                    <tr>
                                    <td style="padding-left: 0; "><span style="text-align: left;  display: inline-block;">Date of issue</span></td>
                                    <td style="padding-left: 0; text-align: right; padding-right:0;"><span style=" font-weight: bold;text-align: right; display: inline-block; text-align: right; padding-right:0;">{{ dbToDate($data->period_start) }}</span>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td style="padding-left: 0;"><span style=" text-align: left; display: inline-block;">Date due </span></td>
                                    <td style="padding-left: 0; text-align: right; padding-right:0;"><span style=" font-weight: bold;text-align: right;display: inline-block; text-align: right; padding-right:0;">{{ dbToDate($data->period_end) }}</span></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" class="email-temp custom-table table-border" style="border-collapse: separate; width: 100%; padding: 0;">
            <tbody>
                <tr>
                    <td><h2 style="margin-bottom:15px;">A${{ $data->amount_due }}.00 {{ $invoice->date() }}</h2></td>
                </tr>
            </tbody>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" class="email-temp custom-table table-border" style="border-collapse: separate; width: 100%; padding: 0;">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr style="">
                    <td style="padding-left: 0; border:none;">OCT 21 – NOV 21, 2019</td>
                    <td style="padding-left: 0; border:none;">&nbsp;</td>
                    <td style="padding-left: 0; border:none;">&nbsp;</td>
                    <td style="padding-left: 0; border:none;">&nbsp;</td>
                </tr>
                @foreach ($invoice->subscriptions() as $subscription)
                    <tr style="background: #F6F9FC;">
                        <td style="padding-left: 0;">{{ $subscription->description }}</td>
                        <td style="padding-left: 0;">{{ $subscription->quantity }}</td>
                        <td style="padding-left: 0;">{{ $invoice->subtotal() }}</td>
                        <td style="padding-left: 0;">{{ $subscription->total() }}</td>
                    </tr>
                @endforeach
                <tr style="">
                    <td rowspan="5" class="colum-rating" colspan="2" style="border:none;">
                <tr style="background: #F6F9FC;">
                    <td style="padding-left: 0;">
                        Subtotal
                    </td>
                    <td style="padding-left: 0; font-weight: 500;">
                        {{ $invoice->subtotal() }}
                    </td>
                </tr>
                <tr style="background: #E6EBF1;">
                    <td style="padding-left: 0; font-weight: 500; border:none;">
                        Total
                    </td>
                    <td style="padding-left: 0; font-weight: 500; border:none;">
                        {{ $invoice->total() }}
                    </td>
                </tr>
                <tr style="background: #F6F9FC;">
                    <td style="padding-left: 0;">
                        Applied balance
                    </td>
                    <td style="padding-left: 0; font-weight: 500;">
                        {{ $invoice->subtotal() }}
                    </td>
                </tr>
                <tr style="background: #E6EBF1; border:none;">
                    <td style="padding-left: 0; font-weight: 500; border:none;">
                        Amount due
                    </td>
                    <td style="padding-left: 0; font-weight: 500; border:none;">
                        A${{ $data->amount_due }}.00
                    </td>
                </tr>
                </td>
                </tr>
            </tbody>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" class="table-footer" style="border-collapse: separate; width: 100%;  padding: 0; margin-top:30px;">
            <tbody>
                <tr>
                <td> <p>Pay</p></td>
                </tr>
                <tr>
                <td><p>  with card Visit pay.stripe.com/invoice/invst_nIjKg9q5gZJsbypA0Wr0CDxJ2k</p></td>
                </tr>
                <tr>
                <td> <p> with card Visit pay.stripe.com/invoice/invst_nIjKg9q5gZJsbypA0Wr0CDxJ2k</p></td>
                </tr>
                <tr>
                <td><p> Questions? Contact Cloud Acess Pty Ltd at accounts@ndiscentral.org.au or call at +61 413 746 37</p></td>
                    <td style="padding-left: 24px;">
                    <p> FDA8E715-0003 – Page 1 of 1</p>
                </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>