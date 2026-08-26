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

    
    <table width="650px"><tr><td>

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
                                    {{ $conf->salutation }}
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
                                @if ($profile_info->eCountry->iso3 === 'PHL')
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
                                <td><h5>SSX 2025</h5></td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px;">Venue: </td>
                                <td style="font-size: 8px;">World Trade Center</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px;">Event Date: </td>
                                <td style="font-size: 8px;">May 22-24, 2025</td>
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
        {{--

        <br />

        <table width="100%" cellpadding="5" cellspacing="3" border="0">
            <thead style="background-color: lightgray; font-size: 9px;">
                <tr>
                    <th>PACKAGE</th>
                    <th>BOOTH COST</th>
                    <th>BOOTH SIZE</th>
                    <th>DISCOUNT</th>
                    <th>PARTICIPATION FEE</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody style="font-size: 9px; font-weight: normal;">
                @foreach ($booth_info as $booth)
                <tr>
                    <td>{{ $booth->package->title }} - {{ $booth->package->sub_title }} - {{ $booth->booth_package }}</td>
                    <td>{{ $booth->currency }} {{ number_format($booth->booth_amount,2) }}</td>
                    <td>{{ $booth->remarks }}</td>
                    <td>{{ $booth->discount_remarks }}</td>
                    <td>{{ $booth->currency }} {{ number_format($booth->total_participation,2) }}</td>
                    <td>{{ $booth->currency }} {{ number_format($booth->total_amount_due,2) }}</td>
                </tr>
                @endforeach
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
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" align="right">Sub Total: {{ $invoice_info->currency }} {{ number_format($sub_total,2) }}</td>
                </tr>
                <tr>
                    <td colspan="6" align="right">Total Additional Cost/s: {{ $mandatory_fee->currency }} {{ number_format($total_addfee,2) }}</td>
                </tr>
                <tr>
                    <td colspan="6" align="right">Total Other Discount/s: - {{ $mandatory_fee->currency }} {{ number_format($total_discount,2) }}</td>
                </tr>
                <tr>
                    <td colspan="6" align="right">Total Amount Due (VAT Inclusive): <span class="gray" style="padding: 4px;">{{ $invoice_info->currency }} {{ number_format($invoice_info->total_amount_due,2) }}</span></td>
                </tr>
            </tfoot>
        </table>
        <hr />
        <br />
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
        <br />
        <table width="100%" cellpadding="4" cellspacing="0" border="1">
            <tr>
                <td style="font-size: 9px; font-weight: bold; text-transform: uppercase; text-align: center;" class="gray">THIS IS A SYSTEM-GENERATED BILLING STATEMENT</td>
            </tr>
            <tr>
                <td style="font-size: 8px;">
                    <p style="text-align: center;">I For billing concerns, please contact our Controllership Division thru e-mail address <a href="mailto:billing@citem.com.ph" target="_blank">billing@citem.com.ph</a> or call at 8831-2201 ext. 210.</p>
                    <p style="text-align: center;">For payment/official receipt concerns, please contact our Cashier Section thru e-mail address <a href="mailto:billing@citem.com.ph" target="_blank">collection@citem.com.ph</a> or call at 8831-2201 ext. 211.</p>
                </td>
            </tr>
        </table>
        --}}


    </td></tr></table>
    
</body>

</html>