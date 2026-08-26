<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
</head>

<body style="margin:0;padding:0;background:#f5f5f5;font-family:Arial,Helvetica,sans-serif;">

    <center>

        <table
            cellpadding="0"
            cellspacing="0"
            border="0"
            style="width:100%;max-width:700px;background:#ffffff;margin:30px auto;"
        >

            <!-- Header -->
            <tr>
                <td style="background:#9daa39;border-bottom:#343a40 5px solid;padding:15px;">
                    <a
                        href="{{ env('APP_URL') }}"
                        style="display:block;"
                    >
                        <img
                             src="{{ url('https://sustainability.ph/assets/images/ssx-full-logo-white.png') }}"
                            style="width:70%;max-width:160px;"
                        >
                    </a>
                </td>
            </tr>

            <!-- Content -->
            <tr>
                <td
                    style="padding:40px;font-size:14px;line-height:24px;color:#333333;"
                >

                    <p>
                        Dear Accounting Team,
                    </p>

                    <p>
                        A new SSX Conference registration has been reviewed
                        and is now ready for Accounting review.
                    </p>

                    <p>
                        <strong>Registration Details</strong>
                    </p>

                    <table
                        cellpadding="8"
                        cellspacing="0"
                        border="0"
                        style="width:100%;font-size:14px;"
                    >

                        <tr>
                            <td style="font-weight:bold;width:180px;">
                                Registration Number
                            </td>
                            <td>
                                {{ $registrationNumber }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:bold;">
                                Company Name
                            </td>
                            <td>
                                {{ $companyName }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:bold;">
                                Contact Person
                            </td>
                            <td>
                                {{ $contactPerson }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:bold;">
                                Company Email
                            </td>
                            <td>
                                {{ $companyEmail }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:bold;">
                                Final Amount
                            </td>
                            <td>
                                {{ $finalAmount }}
                            </td>
                        </tr>

                    </table>

                    <br>

                    <p>
                        Please review the registration and proceed with
                        the necessary billing/Accounting process.
                    </p>

                    <p>
                        Thank you.
                    </p>

                    <br>

                    <p>
                        <strong>
                            THIS IS A SYSTEM-GENERATED EMAIL.
                            PLEASE DO NOT REPLY.
                        </strong>
                    </p>

                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td
                    style="background:#f8f8f8;padding:25px 30px;text-align:center;"
                >

                    <div
                        style="margin:18px auto 0;width:60px;border-top:1px solid #dddddd;"
                    ></div>

                    <p
                        style="margin:0;font-size:12px;font-weight:bold;color:#333;"
                    >
                        Sustainability Solutions Exchange 2026
                    </p>

                    <p
                        style="margin:12px 0 0;font-size:11px;line-height:18px;color:#666;"
                    >
                        Center for International Trade Expositions and Missions (CITEM)<br>
                        Golden Shell Pavilion, ITC Complex,<br>
                        Roxas Boulevard corner Sen. Gil J. Puyat Avenue,<br>
                        Pasay City 1300, Philippines
                    </p>

                </td>
            </tr>

        </table>

    </center>

</body>

</html>