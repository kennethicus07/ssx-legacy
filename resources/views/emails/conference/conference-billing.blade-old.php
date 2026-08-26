<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BILLING STATEMENT</title>

    <style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }

    table {
        font-size: x-small;
    }

    tfoot tr td {
        font-weight: bold;
        font-size: 10px;
    }

    .gray {
        background-color: lightgray
    }

    h5 {
        text-transform: uppercase;
        padding: 0;
        margin: 0;
        font-weight: bold;
    }

    h3 {
        text-transform: uppercase;
        padding: 0;
        margin: 0;
        font-weight: bold;
    }
    </style>

</head>

<body>

    
    

        <table width="100%">
            <tr>
                <td>
                    <img src="{{ url('https://sustainability.ph/assets/images/ssx-logo.png') }}" alt="" style="width: 50%; max-width: 160px;" />
                </td>
                <td align="right">
                    <h1>BILLING STATEMENT</h1>
                </td>
            </tr>
        </table>
        <br />
        
        <table width="100%" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td align="left">
                        <table width="100%">
                            <tr>
                                <td><h3>CENTER FOR INTERNATIONAL TRADE EXPOSITIONS AND MISSIONS</h3></td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px;">
                                    <div style="margin-bottom: 1px;">Golden Shell Pavilion, Int'l. Trade Center Complex, Roxas Blvd.,</div>
                                    <div style="margin-bottom: 1px;">cor., Sen. Gil Puyat Avenue, Pasay City, Philippines 1300</div>
                                    <div style="margin-bottom: 1px;">Tel.: (632) 831-22-01 Fax: (632) 832-39-65 / 834-01-77</div>
                                    <div style="margin-bottom: 1px;">E-mail: info@citem.com.ph</div>
                                    <div>VAT Reg. TIN: 001-240-440-00000</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td align="right">
                        <table width="100%">
                            <tr>
                                <td style="font-size: 8px; margin-bottom: 6px;">Bill No.:</td>
                                <td style="border-bottom: 1px solid; font-weight: bold; font-size: 9px; text-align: center;">{{ $conf->registration_number }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px; margin-bottom: 6px;">Date Issued:</td>
                                <td style="border-bottom: 1px solid; font-weight: bold; font-size: 9px; text-align: center;">{{ Carbon\Carbon::parse($conf->created_at)->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px; margin-bottom: 6px;">Amount Due:</td>
                                <td style="border-bottom: 1px solid; font-weight: bold; font-size: 12px; text-align: center;"><span style="font-family: DejaVu Sans, sans-serif;"></span>{{ $conf->currency }}&nbsp;{{ number_format($conf->final_amount,2, '.', ',') }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px; margin-bottom: 6px;">Due Date:</td>
                                @if (!empty($invoice_info->due_date))
                                <td style="border-bottom: 1px solid; font-weight: bold; font-size: 9px; text-align: center;"></td>
                                @else
                                <td style="border-bottom: 1px solid; font-weight: bold; font-size: 9px; text-align: center;">IMMEDIATELY</td>
                                @endif
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <br />
        
        
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tbody>
                <tr>
                    <td align="left">
                        <table width="80%" cellpadding="2" cellspacing="1" border="0">
                            <tr>
                                <td colspan="2" style="border-bottom: 1px solid;"><h5>bill to:</h5></td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px;">Company Name: </td>
                                <td><h5>{{ $conf->company_name }}</h5></td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px;">Contact Person: </td>
                                <td>
                                    <h5>ATTN.
                                    {{ $conf->salutation }}&nbsp;
                                    {{ $conf->contact_person }}
                                    </h5>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px;">Email Address: </td>
                                <td style="font-size: 8px;">{{ $conf->company_email }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px;">Contact No.: </td>
                                <td style="font-size: 8px;">{{ $conf->contact_number }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px;">Address: </td>
                                <td style="font-size: 8px; text-transform: capitalize;">{{ $conf->company_address }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px;">Company TIN: </td>
                                <td style="font-size: 8px;">{{ $conf->tin }}</td>
                            </tr>
                        </table>
                    </td>
                    <td align="right">
                        <table width="100%" cellpadding="2" cellspacing="1" border="0">
                            <tr>
                                <td colspan="2" style="border-bottom: 1px solid;"><h5>project details:</h5></td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px;">Project: </td>
                                <td><h5>Sustainability Solutions Exchange CONFERENCE 2025</h5></td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px;">Venue: </td>
                                <td style="font-size: 8px;">Philippine Trade Training Center - GMEA</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px;">Event Date: </td>
                                <td style="font-size: 8px;">May 22-23, 2025</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px;">&nbsp;</td>
                                <td style="font-size: 8px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px;">&nbsp;</td>
                                <td style="font-size: 8px;">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        

        <br />

        <table width="100%" cellpadding="5" cellspacing="3" border="0">
            <thead style="background-color: lightgray; font-size: 9px;">
                <tr>
                    <th>PARTICIPATION AND INCLUSIONS</th>
                    <th>DISCOUNT</th>
                    <th>PARTICIPATION FEE</th>
                    <th style="padding: initial 30px;">TOTAL</th>
                </tr>
            </thead>
            <tbody style="font-size: 9px; font-weight: normal;">
                <tr>
                    <td>
                        <span style="font-size: 12px; font-weight: bold;">Conference Delegate x {{ $conf->participant_count }}</span><br>
                        -Inclusive of Delegate Pass with access to:<br>
                        &emsp;&emsp;3-day IFEX Philippines x SSX exhibits at Halls A-E<br>
                        &emsp;&emsp;2-day SSX Conference at PTTC<br>
                        - Conference kit (bag, booklet, and pen)<br>
                        - Conference meals<br>
                        &emsp;&emsp;Day 1: PM Snack<br>
                        &emsp;&emsp;Day 2: AM & PM Snack, and Lunch<br>
                        - Printed and/ or e-copy of the certificate of attendance<br>
                        - Link to Drive / E-copy of the conference materials after the show<br>
                        - Exclusive discounted rates for accredited accommodation and tour services (subject to availability)
                    </td>
                    <td>
                        @foreach ($conf->conferenceBreakdown as $entry)
                            @if($entry->type == 'discount')
                                {{ $entry->count }} x {{ $entry->description }}<br>
                                ({{ $conf->currency }} {{ number_format($entry->value, 2) }})
                                <br><br>
                            @endif
                        @endforeach
                    </td>
                    <td>{{ $conf->currency }} {{ number_format($conf->amount,2) }}</td>
                    <td>{{ $conf->currency }} {{ number_format($conf->final_amount,2) }}</td>
                </tr>
                {{--
                @if ($total_addfee > 0)
                <tr>
                    <td colspan="6" style="background-color: lightgray; font-weight: bold;">ADDITIONAL COST/S</td>
                </tr>
                @foreach ($additional_fees as $addfee)
                <tr>
                    <td colspan="5" style="text-transform: capitalize;">{{ $addfee->remarks }}</td>
                    <td>{{ $addfee->currency }} {{ number_format($addfee->fee,2) }}</td>
                </tr>
                @endforeach
                @endif
                @if ($total_discount > 0)
                <tr>
                    <td colspan="6" style="background-color: lightgray; font-weight: bold;">LESS: OTHER DISCOUNT/S</td>
                </tr>
                @foreach ($discounts as $discount)
                <tr>
                    <td colspan="5" style="text-transform: capitalize;">{{ $discount->remarks }}</td>
                    <td>- {{ $discount->currency }} {{ number_format($discount->discount,2) }}</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <td colspan="6" style="background-color: lightgray; font-weight: bold;">IFEX MANDATORY FEE</td>
                </tr>
                <tr>
                    <td colspan="5">{{ $mandatory_fee->details }}</td>
                    <td>{{ $mandatory_fee->currency }} {{ number_format($mandatory_fee->price,2) }}</td>
                </tr>
                --}}
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" align="right">Sub Total: {{ $conf->currency }} {{ number_format($conf->amount,2) }}</td>
                </tr>
                {{--
                <tr>
                    <td colspan="6" align="right">Total Additional Cost/s: {{ $mandatory_fee->currency }} {{ number_format($total_addfee,2) }}</td>
                </tr>
                --}}
                <tr>
                    <td colspan="6" align="right">Total Discount/s: - {{ $conf->currency }} {{ number_format($conf->discount,2) }}</td>
                </tr>
                <tr>
                    <td colspan="6" align="right">Total Amount Due (VAT Inclusive): <span class="gray" style="padding: 4px;">{{ $conf->currency }} {{ number_format($conf->final_amount,2) }}</span></td>
                </tr>
            </tfoot>
        </table>
        <hr />

        

        <br />
        {{--
        <table width="40%" cellpadding="4" cellspacing="0" border="1">
            @if (empty($profile_info->vat_exempted) && empty($profile_info->vat_zero_rated))
            <tr>
                <td style="font-size: 8px; font-weight: bold;">Net of VAT Sales: </td>
                <td style="font-size: 8px; font-weight: bold;">{{ number_format($net_vat, 2) }}</td>
            </tr>
            @else
            <tr>
                <td style="font-size: 8px; font-weight: bold;">Net of VAT Sales: </td>
                <td style="font-size: 8px; font-weight: bold;">--</td>
            </tr>
            @endif

            @if (empty($profile_info->vat_exempted) && empty($profile_info->vat_zero_rated))
            <tr>
                <td style="font-size: 8px;">12% VAT: </td>
                <td style="font-size: 8px;">{{ number_format($less_vat, 2) }}</td>
            </tr>
            @else
            <tr>
                <td style="font-size: 8px;">12% VAT: </td>
                <td style="font-size: 8px;">--</td>
            </tr>
            @endif

            @if (empty($profile_info->vat_zero_rated))
            <tr>
                <td style="font-size: 8px;">Zero-Rated VAT Sales: </td>
                <td style="font-size: 8px;">--</td>
            </tr>
            @else
            <tr>
                <td style="font-size: 8px;">Zero-Rated VAT Sales: </td>
                <td style="font-size: 8px;">{{ number_format($invoice_info->total_amount_due,2) }}</td>
            </tr>
            @endif

            @if (empty($profile_info->vat_exempted))
            <tr>
                <td style="font-size: 8px;">VAT Exempt Sales:</td>
                <td style="font-size: 8px;">--</td>
            </tr>
            @else
            <tr>
                <td style="font-size: 8px;">VAT Exempt Sales:</td>
                <td style="font-size: 8px;">{{ number_format($net_vat, 2) }}</td>
            </tr>
            @endif




            <tr>
                <td style="font-size: 9px; font-weight: bold;">Total Amount Due:</td>
                <td style="font-size: 9px; font-weight: bold;">{{ $invoice_info->currency }} {{ number_format($invoice_info->total_amount_due,2) }}</td>
            </tr>
        </table>
        <br />
        <br />
        --}}
        <br />
        <table width="100%" cellpadding="4" cellspacing="0" border="1">
            <tr>
                <td style="font-size: 9px; font-weight: bold; text-transform: uppercase; text-align: center;" class="gray">THIS IS A SYSTEM-GENERATED BILLING STATEMENT</td>
            </tr>
            <tr>
                <td style="font-size: 8px;">
                    <!-- <p style="text-align: center;">For billing concerns, please contact our Controllership Division thru e-mail address <a href="mailto:billing@citem.com.ph" target="_blank">billing@citem.com.ph</a> or call at 8831-2201 ext. 210.</p>
                    <p style="text-align: center;">For payment/official receipt concerns, please contact our Cashier Section thru e-mail address <a href="mailto:billing@citem.com.ph" target="_blank">collection@citem.com.ph</a> or call at 8831-2201 ext. 211.</p> -->
                    <p style="text-align: center;">After completing your payment, kindly send a copy of your proof of payment to <a href="mailto:sustainabilityph@citem.com.ph">sustainabilityph@citem.com.ph</a> with the subject line: SSX Conference 2025 Payment Bill No. [Your Billing Number] for verification and confirmation of your registration.</p>
                </td>
            </tr>
        </table>
    
</body>

</html>