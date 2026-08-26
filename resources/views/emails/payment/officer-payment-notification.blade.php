<html>
<head>
    <title>{{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/png" href="https://via.placeholder.com/150" />
</head>
<body>
<center>
    <table cellpadding="10" cellspacing="0" border="0" style="width:96%; max-width:768px;">
        <tr>
            <td style="background:#9daa39; border-bottom:5px solid #343a40; padding:0;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation">
                    <tr>
                        <td align="left" style="padding:12px 15px;">
                            <a href="{{ env('APP_URL') }}">
                                <img src="{{ url('https://sustainability.ph/assets/images/ssx-full-logo-white.png') }}?v=2026_v1"
                                    alt="SSX Logo" width="160" style="display:block;" />
                            </a>
                        </td>
                        <td align="right" style="padding:12px 15px;">
                       
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <div style="font-family:Arial, sans-serif; font-size:13px; line-height:20px; padding:30px 20px;">
                    <p>Hello Officer,</p>

                    <p>The following companies have updated their payment status to <strong>PAID</strong>:</p>

                    <table cellpadding="8" cellspacing="0" border="1" style="border-collapse:collapse; width:100%; font-size:13px;">
                        <thead style="background:#f2f2f2;">
                            <tr>
                                <th>Company Name</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Event</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $att)
                            <tr>
                                <td>{{ $att->exhibitor->co_name ?? 'N/A' }}</td>
                                <td>{{ $att->user->name ?? 'N/A' }}</td>
                                <td>{{ $att->user->email ?? 'N/A' }}</td>
                                <td>{{ $att->event->event_name ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <p style="margin-top:20px;">Please review these payments in the system if needed.</p>
                    <p style="text-align:center; font-size:12px; color:#888;">THIS IS A SYSTEM-GENERATED EMAIL. DO NOT REPLY.</p>
                </div>
            </td>
        </tr>

        <tr>
            <td style="background:#f8f8f8; padding:10px;">
                <p style="font-family:Arial,sans-serif; font-size:12px; text-align:center;">
                    <strong>Sustainability Solutions Exchange. {{ date('Y') }}.</strong><br/>
                    Center for International Trade Expositions and Missions (CITEM)<br/>
                    Golden Shell Pavilion, ITC Complex, Roxas Boulevard corner Sen. Gil J. Puyat Avenue, Pasay City 1300, Philippines<br/>
                    Tel. no.: (02) 8.831.2336 | Email: <a href="mailto:{{ env('SSX_EMAIL') }}">{{ env('SSX_EMAIL') }}</a>
                </p>
            </td>
        </tr>

        <tr>
            <td style="background:#9daa39; padding:10px;">
                <table width="100%">
                    <tr>
                        <td><a href="{{ env('APP_URL') }}"><img src="{{ url('https://sustainability.ph/assets/images/ssx-full-logo-white.png') }}" width="120"></a></td>
                        <td style="text-align:right;">
                            <p style="color:#fff; font-size:12px; margin:0;">Follow Us</p>
                            <a href="{{ env('APP_SOCIAL_FACEBOOK') }}"><img src="{{ url('https://sustainability.ph/assets/images/facebook-icon.png') }}" width="24"></a>
                            <a href="{{ env('APP_SOCIAL_LINKEDIN') }}"><img src="{{ url('https://sustainability.ph/assets/images/linkedin-icon.png') }}" width="24"></a>
                            <a href="{{ env('APP_SOCIAL_INSTAGRAM') }}"><img src="{{ url('https://sustainability.ph/assets/images/instagram-icon.png') }}" width="24"></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
</center>
</body>
</html>