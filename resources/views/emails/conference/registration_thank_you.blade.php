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
                <td style="background: #9daa39; border-bottom: #343a40 5px solid;"><a href="{{ env('APP_URL') }}"
                        style="display: block;">
                        <img  src="{{ url('https://sustainability.ph/assets/images/ssx-full-logo-white.png') }}"
                            style="width: 70%; max-width: 160px;"></a></td>
            </tr>

            <!-- Content -->
            <tr>
                <td style="padding:40px;font-size:14px;line-height:24px;color:#333333;">

           

                  <p>
    Dear Mr./Ms. {{ $fullName }},
</p>

                    <p>
                        Congratulations! You have successfully registered as an SSX Conference Delegate.
                    </p>

                    <p>
                        We are pleased to confirm your participation in the SSX Conference.
                        You may view the conference program here:
                        <a href="https://citem.ph/p/05de95" target="_blank">
                            https://citem.ph/p/05de95
                        </a>.
                    </p>

                    <br>

                    <p>
                        <strong>Please note the following important reminders:</strong>
                    </p>

                    <p>
                        <strong>Track Selection</strong><br>
                        If you have not yet selected your preferred breakout sessions,
                        please do so through the following link:<br>
                        <a href="https://forms.gle/32CK8tTZg4acoHLU7" target="_blank">
                            SSX Conference 2026: Parallel Breakout Tracks – Fill out form
                        </a>
                    </p>

                    <p>
                        We look forward to welcoming you to the event and having you join the discussions,
                        learning sessions, and networking opportunities.
                        Should you have any questions, please feel free to contact us.
                    </p>

                    <p>
                        Thank you and see you at the conference.
                    </p>

                    <br>

                    <p>
                        <strong>THIS IS A SYSTEM-GENERATED EMAIL. PLEASE DO NOT REPLY.</strong>
                    </p>

                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td style="background:#f8f8f8;padding:25px 30px;text-align:center;">
            
                    <div style="margin:18px auto 0;width:60px;border-top:1px solid #dddddd;"></div>
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