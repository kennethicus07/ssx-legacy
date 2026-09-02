<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
</head>

<body style="margin:0;padding:0;background:#f5f5f5;font-family:Arial,Helvetica,sans-serif;">

    <center>
        <table cellpadding="0" cellspacing="0" border="0"
            style="width:100%;max-width:700px;background:#ffffff;margin:30px auto;">

            <!-- Header -->
            <tr>
                <td style="background:#9daa39;border-bottom:#343a40 5px solid;">
                    <a href="{{ env('APP_URL') }}" style="display:block;">
                        <img src="{{ url('https://sustainability.ph/assets/images/ssx-full-logo-white.png') }}"
                            style="width:70%;max-width:160px;">
                    </a>
                </td>
            </tr>

            <!-- Content -->
            <tr>
                <td style="padding:40px;font-size:14px;line-height:24px;color:#333333;">

                    <p>
                        Dear {{ $fullName }},
                    </p>

                    <p>
                        Congratulations! You have been approved to attend the event as a
                        <strong>conference delegate</strong>, and we have reserved one (1)
                        seat for you.
                    </p>

                    <p>
                        For the breakout sessions, please click the link below to select
                        and reserve your preferred session. Kindly note that seats are
                        available on a first-come, first-served basis:
                    </p>

                    <p>
                        <a href="https://forms.gle/32CK8tTZg4acoHLU7"
                            target="_blank"
                            style="color:#9daa39;font-weight:bold;text-decoration:underline;">
                            Breakout Session Registration Form
                        </a>
                    </p>

                    <p>
                        On the day of the event, please present this email together with
                        your valid ID for verification and badge printing.
                    </p>

                    <p>
                        Thank you and we look forward to welcoming you to the
                        <strong>SSX Conference!</strong>
                    </p>

                    <br>

                   <p style="text-align: center;">
                        <strong>THIS IS A SYSTEM-GENERATED EMAIL. PLEASE DO NOT REPLY.</strong>
                    </p>

                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td style="background:#f8f8f8;padding:25px 30px;text-align:center;">

                

                    <p style="margin:0;font-size:12px;font-weight:bold;color:#333;">
                        Sustainability Solutions Exchange 2026
                    </p>

                    <p style="margin:12px 0 0;font-size:11px;line-height:18px;color:#666;">
                        Center for International Trade Expositions and Missions (CITEM)<br>
                        Golden Shell Pavilion, ITC Complex,<br>
                        Roxas Boulevard corner Sen. Gil J. Puyat Avenue,<br>
                        Pasay City 1300, Philippines
                    </p>

                    <p style="margin:12px 0 0;font-size:11px;">
                        <strong>Email:</strong>
                        <a href="mailto:sustainabilityph@citem.com.ph">
                            sustainabilityph@citem.com.ph
                        </a>
                    </p>

                </td>
            </tr>

        </table>
    </center>

</body>

</html>