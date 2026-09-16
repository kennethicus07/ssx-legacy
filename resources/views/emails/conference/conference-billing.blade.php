<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>STATEMENT OF ACCOUNT</title>

        <style type="text/css">
            * {
                font-family: Verdana, Arial, sans-serif;
                box-sizing: border-box;
            }

            /* =========================================================
               PAGE / CANVAS
               DomPDF paints `body` background across the WHOLE canvas,
               not per-page, so a light gray body background shows up
               as a gray band at page breaks. Force white here.
            ========================================================= */

            @page {
                margin: 20px;
            }

            html,
            body {
                font-size: 9px;
                color: #000;
                margin: 0;
                padding: 0;
                background: #fff; /* was #eee — this was the source of the gray band */
            }

            .page-wrap {
                max-width: 100%;
                margin: 0;         /* was: 20px auto — auto-centering isn't needed once @page handles margins */
                background: #fff;
                padding: 16px;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            .no-border td,
            .no-border th {
                border: none;
            }

            .gray {
                background-color: #d9d9d9;
            }

            .light-gray {
                background-color: #e8e8e8;
            }

            .dark-gray {
                background-color: #bfbfbf;
            }

            .bold {
                font-weight: bold;
            }

            .upper {
                text-transform: uppercase;
            }

            .center {
                text-align: center;
            }

            .right {
                text-align: right;
            }

            /* =========================================================
               OUTER DOCUMENT
            ========================================================= */

            .form-code {
                text-align: right;
                font-weight: bold;
                font-size: 10px;
                padding-bottom: 2px;
            }

            .outer-box {
                width: 100%;
                border: 1.5px solid #000;
                border-collapse: collapse;
                border-spacing: 0;
            }

            .outer-box > tbody > tr > td {
                padding: 0;
            }

            .block {
                padding: 8px 10px;
            }

            .divider td {
                border-top: 1px solid #000;
                padding: 0;
                height: 1px;
            }

            /* =========================================================
               HEADER
            ========================================================= */

            h2.company-title {
                text-align: center;
                font-size: 13px;
                margin: 2px 0 4px 0;
                padding: 0;
                text-transform: uppercase;
            }

            .addr-block {
                text-align: center;
                font-size: 8px;
                line-height: 1.4;
            }

            .soa-title-table {
                width: 100%;
                margin: 6px 0 0 0;
                border-collapse: collapse;
            }

            .soa-title-table td {
                padding: 0;
            }

            .soa-title-left,
            .soa-title-right {
                width: 20%;
            }

            .soa-title-center {
                width: 60%;
                text-align: center;
                border: 1px solid #000;
                padding: 5px 20px;
                letter-spacing: 4px;
                font-size: 13px;
                font-weight: bold;
                text-transform: uppercase;
                white-space: nowrap;
            }

            /* =========================================================
               FORM FIELDS
            ========================================================= */

            .field-row td {
                padding: 3px 4px 5px 4px;
                vertical-align: bottom;
                font-size: 9px;
            }

            .field-label {
                width: 80px;
                font-weight: bold;
                white-space: nowrap;
                text-transform: uppercase;
            }

            .colon {
                width: 12px;
            }

            .field-value {
                border-bottom: 1px solid #000;
            }

            .section-label {
                font-weight: bold;
                text-transform: uppercase;
                padding: 0 0 4px 0;
            }

            /* =========================================================
               COST TABLE

               10-column grid:

               Description = 4 columns
               Cost        = 2 columns
               Size / Unit = 2 columns
               Total       = 2 columns
            ========================================================= */

            .cost-table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                table-layout: fixed;

                /* OUTER TABLE BORDER */
                border: 1px solid #000;
            }

            /* No borders inside by default */
            .cost-table th,
            .cost-table td {
                border: none;

                font-family: Verdana, Arial, sans-serif;
                font-size: 9px;
                padding: 5px 4px;
                vertical-align: top;

                word-break: normal;
                overflow-wrap: break-word;
            }

            /* Keep colored summary rows from splitting across a page
               break — this is what caused the "gray line" look at
               the seam when a row got sliced in half. */
            .cost-table tr,
            .reminders-box tr {
                page-break-inside: avoid;
            }

            /* =========================================================
               HEADER
            ========================================================= */

            .cost-table th {
                background-color: #d9d9d9;
                font-weight: bold;
                text-transform: uppercase;
                text-align: left;

                /* Header cells are fully bordered */
                border: 1px solid #000;
            }

            /* =========================================================
               CUSTOM FULL CELL BORDER
            ========================================================= */

            .cost-table .cell-border {
                border: 1px solid #000 !important;
            }

            /* =========================================================
               OPTIONAL BORDER SIDES
            ========================================================= */

            .cost-table .border-top {
                border-top: 1px solid #000 !important;
            }

            .cost-table .border-right {
                border-right: 1px solid #000 !important;
            }

            .cost-table .border-bottom {
                border-bottom: 1px solid #000 !important;
            }

            .cost-table .border-left {
                border-left: 1px solid #000 !important;
            }

            /* =========================================================
               TEXT
            ========================================================= */

            .cost-table .amt {
                text-align: right;
                white-space: nowrap;
            }

            .cost-table .bold {
                font-weight: bold;
            }

            .cost-table .upper {
                text-transform: uppercase;
            }

            .cost-table .right {
                text-align: right;
            }

            /* =========================================================
               BACKGROUNDS
            ========================================================= */

            .cost-table .light-gray {
                background-color: #e8e8e8;
            }

            .cost-table .dark-gray {
                background-color: #bfbfbf;
            }

            .cost-table .gray {
                background-color: #d9d9d9;
            }

            .cost-table .final-total {
                font-size: 10px;
                font-weight: bold;
            }

            /*
             * 10-column widths
             *
             * Description = 40%
             * Cost        = 22%
             * Size / Unit = 22%
             * Total       = 16%
             */
            .cost-table col.description {
                width: 10%;
            }

            .cost-table col.cost {
                width: 11%;
            }

            .cost-table col.size {
                width: 11%;
            }

            .cost-table col.total {
                width: 8%;
            }

            /* =========================================================
               SUMMARY BORDER CONTROL
            ========================================================= */

            .no-top {
                border-top: none !important;
            }

            .no-right {
                border-right: none !important;
            }

            .no-bottom {
                border-bottom: none !important;
            }

            .no-left {
                border-left: none !important;
            }

            .no-border-cell {
                border: none !important;
            }

            /* =========================================================
               PAYMENT REMINDERS
            ========================================================= */

            .reminders {
                font-size: 7.5px;
                line-height: 1.6;
            }

            .reminders-table {
                table-layout: fixed;
            }

            /* Payment Reminders outer border */
            .reminders-box {
                border: 1px solid #000;
                border-collapse: collapse;
                width: 100%;
            }

            /* Keep the inside clean */
            .reminders-box td {
                border: none;
            }

            .reminders-col {
                width: 62%;
                vertical-align: top;
                padding-right: 10px;
                word-wrap: break-word;
            }

            .qr-col {
                width: 38%;
                vertical-align: top;
                text-align: left;
            }

            .qr-content-table {
                width: 100%;
                border-collapse: collapse;
                border: none;
            }

            .qr-content-table td {
                border: none;
                vertical-align: center;
            }

            .qr-instruction {
                text-align: left;
                font-size: 7.5px;
                line-height: 1.5;
                padding-bottom: 6px;
            }

            .qr-instruction a {
                word-break: break-all;
            }

            .qr-image-col {
                width: 45%;
                text-align: center;
                vertical-align: top;
            }

            .qr-image-col img {
                display: block;
                margin: 0 auto;
                width: 90px;
                height: 90px;
                border: 1px solid #ccc;
            }

            .qr-note-col {
                width: 55%;
                vertical-align: center;
                padding-left: 8px;
            }

            .qr-note {
                font-size: 7px;
                font-weight: bold;
                color: #ee0e0f;
                text-align: start;
                line-height: 1.4;
            }

            /* =========================================================
               SIGNATURES
            ========================================================= */

            .sig-block {
                text-align: center;
                font-size: 8.5px;
                padding-top: 15px;
                padding-bottom: 12px;
            }

            /* =========================================================
               SYSTEM GENERATED STAMP
            ========================================================= */

            .stamp-wrap {
                padding: 0 10px 10px 10px !important;
            }

            .stamp-box {
                border: 1px solid #000;
                margin: 8px 0 0 0;
                width: 100%;
            }

            .stamp-box td {
                padding: 4px;
                text-align: center;
            }

            .stamp-title {
                font-weight: bold;
                text-transform: uppercase;
                font-size: 9px;
            }

            .stamp-sub {
                font-size: 7.5px;
            }

            /* =========================================================
               PRIVACY
            ========================================================= */

            .privacy {
                font-size: 7.5px;
                line-height: 1.4;
            }

            .doc-footer {
                font-size: 7px;
                text-align: center;
                padding-top: 4px;
            }

            .italic {
                font-style: italic;
            }
            .cost-table .header-center {
                text-align: center;
                vertical-align: middle;
            }
        </style>
    </head>

    <body>
        <div class="page-wrap">

            <!-- =====================================================
                 FORM CODE
            ====================================================== -->

            <table class="no-border" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="form-code">CITEM.CTR.FR.013</td>
                </tr>
            </table>

            <!-- =====================================================
                 OUTER BOX
            ====================================================== -->

            <table class="outer-box" cellpadding="0" cellspacing="0">

                <!-- =================================================
                     HEADER
                ================================================== -->

                <tr>
                    <td class="block">

                        <table
                            class="no-border"
                            cellpadding="0"
                            cellspacing="0"
                        >
                            <tr>

                                <!-- CITEM LOGO -->

                                <td width="15%" style="padding: 8px">
                                    <img
                                        src="{{ url('https://sustainability.ph/assets/images/soa_logo_citem.png') }}"
                                        alt="CITEM"
                                        style="width: 100%; max-width: 85px"
                                    />
                                </td>

                                <!-- COMPANY INFORMATION -->

                                <td width="70%">

                                    <h2 class="company-title">
                                        Center for International Trade
                                        Expositions and Missions
                                    </h2>

                                    <div class="addr-block">
                                        Golden Shell Pavilion, Int'l. Trade
                                        Center Complex, Roxas Blvd., cor., Sen.
                                        Gil Puyat Avenue, Pasay City,
                                        Philippines 1300

                                        <br />

                                        Tel.: (632) 8831-22-01 Fax: (632)
                                        8832-39-65 / 8834-01-77 &nbsp; E-mail:
                                        info@citem.com.ph

                                        <br />

                                        VAT Reg. TIN: 001-240-440-00000
                                    </div>

                                </td>

                                <!-- DTI LOGO -->

                                <td
                                    width="15%"
                                    style="padding: 8px; text-align: right"
                                >
                                    <img
                                        src="{{ url('https://sustainability.ph/assets/images/soa_logo_dti.png') }}"
                                        alt="DTI"
                                        style="width: 100%; max-width: 65px"
                                    />
                                </td>

                            </tr>
                        </table>

                        <!-- SOA TITLE -->

                        <table
                            class="soa-title-table"
                            cellpadding="0"
                            cellspacing="0"
                        >
                            <tr>
                                <!-- LEFT 20% -->
                                <td class="soa-title-left"></td>

                                <!-- CENTER 60% -->
                                <td class="soa-title-center">
                                    Statement of Account
                                </td>

                                <!-- RIGHT 20% -->
                                <td class="soa-title-right"></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- =================================================
                     COMPANY / SOA INFORMATION
                ================================================== -->

                <tr>
                    <td
                        class="block"
                        style="padding-top: 20px; padding-bottom: 10px"
                    >

                        <table
                            class="no-border"
                            cellpadding="0"
                            cellspacing="0"
                        >
                            <tr>

                                <!-- COMPANY DETAILS -->

                                <td width="65%" style="padding-left: 5px">

                                    <table
                                        class="no-border field-row"
                                        cellpadding="0"
                                        cellspacing="0"
                                    >

                                        <tr>
                                            <td class="field-label" style="width: 120px;">
                                                Company Name
                                            </td>

                                            <td class="colon">:</td>

                                            <td class="field-value bold">
                                                {{ $conf->company_name }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="field-label">
                                                TIN
                                            </td>

                                            <td class="colon">:</td>

                                            <td class="field-value">
                                                {{ $conf->tin }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="field-label">
                                                Contact Person
                                            </td>

                                            <td class="colon">:</td>

                                            <td class="field-value">
                                                <span>ATTN.
                                                {{ $conf->contact_person_salutation }}&nbsp;
                                                {{ $conf->contact_person }}
                                                </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="field-label">
                                                Email Address
                                            </td>

                                            <td class="colon">:</td>

                                            <td class="field-value">
                                                {{ $conf->company_address }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="field-label">
                                                Tel./Mobile No./s
                                            </td>

                                            <td class="colon">:</td>

                                            <td class="field-value">
                                                {{ $conf->contact_number }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="field-label">
                                                Address
                                            </td>

                                            <td class="colon">:</td>

                                            <td
                                                class="field-value"
                                                style="text-transform: capitalize"
                                            >
                                                {{ $conf->company_address }}
                                            </td>
                                        </tr>

                                    </table>

                                </td>

                                <!-- SOA DETAILS -->

                                <td
                                    width="35%"
                                    style="vertical-align: top"
                                >

                                    <table
                                        class="no-border field-row"
                                        cellpadding="0"
                                        cellspacing="0"
                                    >

                                        <tr>
                                            <td
                                                class="field-label"
                                                style="width: 70px"
                                            >
                                                SOA No.
                                            </td>

                                            <td class="colon">:</td>

                                            <td class="field-value bold">
                                                {{ $conf->registration_number }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="field-label">
                                                Date
                                            </td>

                                            <td class="colon">:</td>

                                            <td class="field-value">
                                                {{ $soa->date_issued->format('M d, Y') }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="field-label">
                                                Due Date
                                            </td>

                                            <td class="colon">:</td>

                                            <td class="field-value">
                                                {{ $soa->date_due
                                                    ? $soa->date_due->format('M d, Y')
                                                    : 'IMMEDIATELY'
                                                }}
                                            </td>
                                        </tr>

                                    </table>

                                </td>

                            </tr>
                        </table>

                    </td>
                </tr>

                <!-- DIVIDER -->

                <tr class="divider">
                    <td></td>
                </tr>

                <!-- =================================================
                     EVENT INFORMATION
                ================================================== -->

                <tr>
                    <td
                        class="block"
                        style="
                            padding-left: 8px;
                            padding-top: 15px;
                            padding-bottom: 10px;
                        "
                    >

                        <div class="section-label">
                            Event Information
                        </div>

                        <table
                            class="no-border field-row"
                            cellpadding="0"
                            cellspacing="0"
                        >

                            <tr>
                                <td
                                    class="field-label"
                                    style="width: 70px"
                                >
                                    Event
                                </td>

                                <td class="colon">:</td>

                                <td class="field-value bold">
                                    {{ $event->event_name }}
                                </td>
                            </tr>

                            <tr>
                                <td class="field-label">
                                    Date
                                </td>

                                <td class="colon">:</td>

                                <td class="field-value">
                                    {{ $event->formatted_date_range }}
                                </td>
                            </tr>

                            <tr>
                                <td class="field-label">
                                    Venue
                                </td>

                                <td class="colon">:</td>

                                <td class="field-value">
                                    Philippine Trade Training Center-Global MSME Academy (PTTC-GMEA), Pasay City, Metro Manila, Philippines
                                </td>
                            </tr>

                        </table>

                    </td>
                </tr>

                <!-- =================================================
                     COST TABLE
                ================================================== -->

                <tr>
                    <td
                        style="
                            padding-left: 8px;
                            padding-right: 8px;
                            padding-bottom: 15px;
                        "
                    >

                        <table
                            class="cost-table"
                            cellpadding="0"
                            cellspacing="0"
                        >

                            <!-- 10 COLUMN GRID -->

                            <colgroup>
                                <col class="description" />
                                <col class="description" />
                                <col class="description" />
                                <col class="description" />

                                <col class="cost" />
                                <col class="cost" />

                                <col class="size" />
                                <col class="size" />

                                <col class="total" />
                                <col class="total" />
                            </colgroup>

                            <!-- HEADER -->

                                     <thead>
                            <tr>
                                <th colspan="4" class="header-center">
                                    Description / Package
                                </th>

                                <th colspan="2" class="header-center">
                                    Cost
                                </th>

                                <th colspan="2" class="header-center">
                                    Size / Unit
                                </th>

                                <th colspan="2" class="header-center">
                                    Total
                                </th>
                            </tr>
                        </thead>

                            <tbody>

                                <!-- CONFERENCE DELEGATE -->

                                <tr>
                                    <td colspan="4">

                                        <span class="bold">
                                            Conference Delegate
                                        </span>
                                        <br>
                                        INCLUSIONS:<br>
                                        - Delegate Pass to SSX Conference on 15-17 October 2026<br>
                                        - Access to SSX exhibition<br>
                                        - Conference kit (bag, booklet, and pen)<br>
                                        - Meals for 2-day conference<br>
                                        - Access to live recorded sessions and/or conference materials<br>
                                        - Printed and/or e-copy of the certificate of attendance
                                    </td>

                                    <td colspan="2" class="amt">
                                        {{ $conf->currency }} {{ number_format($base_rate, 2) }}
                                    </td>

                                    <td colspan="2" class="amt">
                                        {{ $conf->participant_count }}
                                    </td>

                                    <td
                                        colspan="2"
                                        class="amt border-left"
                                    >
                                        {{ $conf->currency }} {{ number_format($base_total, 2) }}
                                    </td>
                                </tr>

                                <!-- ADDITIONAL COST/S -->

                                <tr>

                                    <td
                                        colspan="4"
                                        class="light-gray bold upper"
                                    >
                                        Additional Cost/s
                                    </td>

                                    <td
                                        colspan="2"
                                        class="light-gray"
                                    ></td>

                                    <td
                                        colspan="2"
                                        class="light-gray"
                                    ></td>

                                    <td
                                        colspan="2"
                                        class="light-gray border-left"
                                    ></td>

                                </tr>


                                <!-- ADDITIONAL COST -->

                                @foreach ($fees as $fee)

                                    <tr>

                                        <td colspan="4">
                                            {{ $fee->description }}
                                        </td>

                                        <td colspan="2"></td>

                                        <td colspan="2" class="amt">
                                            @if ($fee->count > 0)
                                                {{ $fee->count }}
                                            @endif
                                        </td>

                                        <td
                                            colspan="2"
                                            class="amt border-left"
                                        >
                                            {{ $conf->currency }}
                                            {{ number_format($fee->value, 2) }}
                                        </td>

                                    </tr>

                                @endforeach
                                <!-- TOTAL BEFORE DEDUCTIONS -->

                                <tr>

                                    <td
                                        colspan="4"
                                        class="dark-gray bold upper"
                                    >
                                        Total Amount Before Deductions
                                    </td>

                                    <td colspan="2" class="dark-gray"></td>

                                    <td colspan="2" class="dark-gray"></td>

                                    <td
                                        colspan="2"
                                        class="amt dark-gray bold border-left"
                                    >
                                        {{ $conf->currency }} {{ number_format($total_before_deductions, 2) }}
                                    </td>

                                </tr>

                                <!-- DEDUCTIONS -->

                                <tr>

                                    <td
                                        colspan="4"
                                        class="light-gray bold upper"
                                    >
                                        Deductions:
                                    </td>

                                    <td
                                        colspan="2"
                                        class="light-gray"
                                    ></td>

                                    <td
                                        colspan="2"
                                        class="light-gray"
                                    ></td>

                                    <td
                                        colspan="2"
                                        class="light-gray border-left"
                                    ></td>

                                </tr>

                                <!-- SUBSIDY -->

                                <tr>

                                    <td
                                        colspan="4"
                                        class="light-gray bold upper"
                                    >
                                        Subsidy
                                    </td>

                                    <td
                                        colspan="2"
                                        class="light-gray"
                                    ></td>

                                    <td
                                        colspan="2"
                                        class="light-gray"
                                    ></td>

                                    <td
                                        colspan="2"
                                        class="amt light-gray border-left"
                                    >
                                        
                                    </td>

                                </tr>

                                    @foreach ($subsidy_discounts as $subsidy_discount)

                                    <tr>

                                        <td colspan="4">
                                     

                                            {{ $subsidy_discount->description }}
                                        </td>

                                        <td colspan="2"></td>

                                        <td colspan="2" class="amt">
                                                   @if ($subsidy_discount->count > 0)
                                                {{ $subsidy_discount->count }}
                                            @endif
                                        </td>

                                        <td
                                            colspan="2"
                                            class="amt border-left"
                                        >
                                            -    {{ $conf->currency }} {{ number_format($subsidy_discount->value, 2) }}
                                        </td>

                                    </tr>

                                @endforeach


                                <!-- DISCOUNT/S -->

                                <tr>

                                    <td
                                        colspan="4"
                                        class="light-gray bold upper"
                                    >
                                        Discount/s
                                    </td>

                                    <td
                                        colspan="2"
                                        class="light-gray"
                                    ></td>

                                    <td
                                        colspan="2"
                                        class="light-gray"
                                    ></td>

                                    <td
                                        colspan="2"
                                        class="amt light-gray border-left"
                                    >

                                    </td>

                                </tr>

                                <!-- DISCOUNT VALUE -->



                                @foreach ($discounts as $discount)

                                    <tr>

                                        <td colspan="4">
                                      
                                            {{ $discount->description }}
                                        </td>

                                        <td colspan="2"></td>

                                        <td colspan="2">
                                                  @if ($discount->count > 0)
                                                {{ $discount->count }} x
                                            @endif

                                        </td>

                                        <td
                                            colspan="2"
                                            class="amt border-left"
                                        >
                                            -    {{ $conf->currency }} {{ number_format($discount->value, 2) }}
                                        </td>

                                    </tr>

                                @endforeach

                                <!-- =================================================
                                     SUMMARY
                                ================================================== -->

                                <!-- EMPTY ROW -->

                                <tr>
                                    <td colspan="4"></td>

                                    <td colspan="2"></td>

                                    <td colspan="2"></td>

                                    <td
                                        colspan="2"
                                        class="border-left"
                                    ></td>
                                </tr>

                                <!-- EMPTY ROW -->

                                <tr>
                                    <td colspan="4"></td>

                                    <td colspan="2"></td>

                                    <td colspan="2"></td>

                                    <td
                                        colspan="2"
                                        class="border-left"
                                    ></td>
                                </tr>

                                <!-- TOTAL AMOUNT DUE -->

                                <tr>

                                    <td
                                        colspan="2"
                                        class="bold border-top"
                                    >
                                        Total Amount Due
                                    </td>

                                    <td
                                        colspan="2"
                                        class="bold border-top border-right border-bottom"
                                    >
                                        {{ $conf->currency }} {{ number_format($total_amount_due, 2) }}
                                    </td>

                                    <td colspan="2"></td>

                                    <td colspan="2"></td>

                                    <td
                                        colspan="2"
                                        class="amt bold border-left"
                                    >

                                    </td>

                                </tr>


                                <!-- VAT -->

                                <tr>

                                    <td
                                        colspan="2"
                                        class="bold"
                                    >
                                        VAT {{ number_format($vat_rate, 0) }}%
                                    </td>

                                    <td
                                        colspan="2"
                                        class="bold border-right"
                                    >
                                        {{ $conf->currency }}   {{ number_format($vat_amount, 2) }}
                                    </td>

                                    <td colspan="2"></td>

                                    <td colspan="2"></td>

                                    <td
                                        colspan="2"
                                        class="amt border-left"
                                    >

                                    </td>

                                </tr>


                                <!-- NET OF VAT -->

                                <tr>

                                    <td
                                        colspan="2"
                                        class="bold border-bottom"
                                    >
                                        Net of VAT
                                    </td>

                                    <td
                                        colspan="2"
                                        class="bold border-bottom border-right"
                                    >
                                        {{ $conf->currency }}   {{ number_format($net_vat, 2) }}
                                    </td>

                                    <td colspan="2"></td>

                                    <td colspan="2"></td>

                                    <td
                                        colspan="2"
                                        class="amt border-left"
                                    >

                                    </td>

                                </tr>

                                <!-- EMPTY SPACE -->

                                <tr>
                                    <td colspan="4"></td>

                                    <td colspan="2"></td>

                                    <td colspan="2"></td>

                                    <td
                                        colspan="2"
                                        class="border-left"
                                    ></td>
                                </tr>

                                <tr>
                                    <td colspan="4"></td>

                                    <td colspan="2"></td>

                                    <td colspan="2"></td>

                                    <td
                                        colspan="2"
                                        class="border-left"
                                    ></td>
                                </tr>

                                <!-- FINAL TOTAL -->

                                <tr>

                                    <td colspan="4" class="border-top"></td>

                                    <td colspan="2" class="border-top"></td>

                                    <td
                                        colspan="2"
                                        class="bold right italic border-top"
                                    >
                                        Total Amount Due
                                    </td>

                                    <td
                                        colspan="2"
                                        class="amt final-total border-left border-top italic"
                                    >
                                        {{ $conf->currency }}  {{ number_format($total_amount_due, 2) }}
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </td>
                </tr>

                <!-- =================================================
                     PAYMENT REMINDERS
                ================================================== -->

                <tr>
                    <td
                        class="block"
                        style="
                            padding-left: 8px;
                            padding-right: 8px;
                        "
                    >

                        <table
                            class="reminders-box reminders reminders-table"
                            cellpadding="0"
                            cellspacing="0"
                        >

                            <tr>

                                <td
                                    class="reminders-col"
                                    style="
                                        padding-left: 8px;
                                        padding-top: 8px;
                                        padding-bottom: 8px;
                                        padding-bottom:8px;
                                    "
                                >

                                    <span class="bold upper">
                                        Payment Reminders:
                                    </span>

                                    <br />

                                    1. Payments can be made thru the following:

                                    <br />

                                    &emsp;a) Citem Cashier (Cash / Manager's
                                    Check, Credit Card - VISA)

                                    <br />

                                    &emsp;b) On-line Bank Transfer (Account
                                    Name: CITEM / Branch: Century Park - HP)

                                    <br />

                                    &emsp;&emsp;b.1) LBP - PESO Account No.
                                    1772-1038-63

                                    <br />

                                    &emsp;&emsp;b.2) LBP - DOLLAR Account No.
                                    1774-0065-04

                                    <br />

                                    &emsp;c) Swift Code: TLBPPHMMXXX

                                    <br />

                                    2. The Amount due shall be paid in the
                                    CURRENCY IN WHICH IT IS BILLED (PHP or USD)

                                    <br />

                                    3. For billing concerns: please contact
                                    Controllership Division 8831-2201 ext 210
                                    or e-mail controllership@citem.com.ph

                                    <br />

                                    4. For payment concerns: please contact
                                    Cashier Section 8831-2201 ext 211 or
                                    e-mail cashier@citem.com.ph

                                    <br />

                                </td>

                                <!-- QR -->

                                <td></td>

                                <td class="qr-col">

                                    <table
                                        class="qr-content-table"
                                        cellpadding="0"
                                        cellspacing="0"
                                    >

                                        <!-- INSTRUCTION -->

                                        <tr>

                                            <td
                                                colspan="2"
                                                class="qr-instruction"
                                                style="
                                                    padding-right: 8px;
                                                    padding-top: 8px;
                                                    padding-bottom: 8px;
                                                "
                                            >

                                                5. For other payment options and
                                                instructions, visit CITEM
                                                website and upload your proof of
                                                payment thru the link or QR code
                                                below:

                                                <br />

                                                <a
                                                    href="https://citem.gov.ph/services/payment"
                                                >
                                                    https://citem.gov.ph/services/payment
                                                </a>

                                            </td>

                                        </tr>

                                        <!-- QR + IMPORTANT NOTE -->

                                        <tr>

                                            <!-- QR COLUMN -->

                                            <td class="qr-image-col">

                                                <img
                                                    src="{{ url('https://sustainability.ph/assets/images/soa_logo_qr.png') }}"
                                                    alt="QR"
                                                />

                                            </td>

                                            <!-- IMPORTANT NOTE COLUMN -->

                                            <td class="qr-note-col">

                                                <div>

                                                    <span class="italic">
                                                        Important Note:
                                                    </span>

                                                    <br />

                                                    <span class="qr-note">
                                                        ALL BANK CHARGES AND
                                                        CONVENIENCE FEES SHALL
                                                        BE FOR THE ACCOUNT OF
                                                        THE EXHIBITOR.
                                                    </span>

                                                </div>

                                            </td>

                                        </tr>

                                    </table>

                                </td>

                            </tr>

                        </table>

                    </td>
                </tr>

                <!-- =================================================
                     SIGNATURES
                ================================================== -->

                <tr>

                    <td
                        class="block"
                        style="padding-top: 0"
                    >

                        <table
                            class="no-border"
                            cellpadding="0"
                            cellspacing="0"
                        >

                            <tr>

                                <td
                                    width="50%"
                                    class="sig-block"
                                >

                                    Prepared by:

                                    <br />
                                    <br />

                                    <span class="bold upper">
                                        Senior Bookkeeper
                                    </span>

                                </td>

                                <td
                                    width="50%"
                                    class="sig-block"
                                >

                                    Certified Correct:

                                    <br />
                                    <br />

                                    <span class="bold upper">
                                        Chief, Controllership Division
                                    </span>

                                </td>

                            </tr>

                        </table>

                    </td>

                </tr>

                <!-- =================================================
                     SYSTEM GENERATED STAMP
                ================================================== -->

                <tr>

                    <td class="stamp-wrap">

                        <table
                            class="stamp-box"
                            cellpadding="0"
                            cellspacing="0"
                        >

                            <tr>
                                <td class="stamp-title">
                                    This is a system-generated statement of
                                    account
                                </td>
                            </tr>

                            <tr>
                                <td class="stamp-sub">
                                    Approved through the authorized electronic
                                    approval system. No signature is required.
                                </td>
                            </tr>

                        </table>

                    </td>

                </tr>

                <!-- =================================================
                     DIVIDER
                ================================================== -->

                <tr class="divider">
                    <td></td>
                </tr>

                <!-- =================================================
                     DATA PRIVACY
                ================================================== -->

                <tr>

                    <td class="stamp-wrap">

                        <table
                            class="stamp-box"
                            cellpadding="0"
                            cellspacing="0"
                        >

                            <tr>
                                <td class="bold upper">
                                    DATA PRIVACY NOTICE
                                </td>
                            </tr>

                            <tr>

                                <td class="stamp-sub">

                                    CITEM collects and processes the personal
                                    information and documents you submit solely
                                    for payment verification and related
                                    transaction processing, in accordance with
                                    the Data Privacy Act of 2012 (Republic Act
                                    No. 10173). For more information, please
                                    refer to CITEM's Privacy Notice through the
                                    link below.

                                    <br />

                                    <a
                                        href="https://citem.gov.ph/privacy-policy"
                                    >
                                        https://citem.gov.ph/privacy-policy
                                    </a>

                                </td>

                            </tr>

                        </table>

                    </td>

                </tr>

            </table>

            <!-- =====================================================
                 FOOTER
            ====================================================== -->

            <div class="doc-footer">
                Document Owner: CITEM - Controllership Division |
                Document Code: CD-FRM-001 |
                Revision No.: 00 |
                Effectivity Date: 01 August 2026 |
                Page: 1 of 1
            </div>

        </div>
    </body>
</html>