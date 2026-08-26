<html>

<head>
    <title>{{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/png" href="https://via.placeholder.com/150" />
</head>

<body>
    <center>
        <table cellpadding="10" cellspacing="0" border="0" style="width: 96%; max-width: 768px;">
            <tr>
                <td style="background:#9daa39; border-bottom:5px solid #343a40; padding:0;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation"
                        style="border-collapse:collapse;">
                        <tr>
                            <!-- Left: Logo -->
                            <td align="left" valign="middle" style="padding:12px 15px;">
                                <a href="{{ env('APP_URL') }}" style="display:block;">
                                    <img src="{{ url('https://sustainability.ph/assets/images/ssx-full-logo-white.png') }}?v=2026_v1"
                                        alt="SSX Logo" width="160"
                                        style="display:block; border:0; outline:none; text-decoration:none;" />
                                </a>
                            </td>

                            <!-- Right: Event Info Image -->
                            <td align="right" valign="middle" style="padding:12px 15px;">
                              
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <div
                        style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 22px; text-align: left; padding: 30px 20px;">
                        <p>Hello,</p>

                        <p>
                            A new application has been submitted in the Sustainability Solutions Exchange (SSX) system.
                            Kindly review the details below for your action and processing.
                        </p>

                        <!-- Friendly Group Text -->
                        <h3 style="margin-bottom: 15px; color: #9daa39;">{{ $group }}</h3>

                        <!-- Company and Event Table -->
                        <table cellpadding="5" cellspacing="0" border="0"
                            style="width: 100%; max-width: 600px; border: 1px solid #ccc;">
                            <tr>
                                <td style="font-weight: bold; width: 150px;">Company Name:</td>
                                <td>{{ $companyName }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">Company Email:</td>
                                <td> {{ !empty($exhibitorEmail) ? $exhibitorEmail : (!empty($buyerEmail) ? $buyerEmail : 'N/A') }}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">Event Name:</td>
                                <td>{{ $event->event_name }}</td>
                            </tr>
                        </table>

                        <p>
                            Please review and confirm approval at your earliest convenience.
                        </p>

                        <p>Thank you.</p>

                        <p style="text-align: center; font-size: 12px; color: #555;">
                            THIS IS A SYSTEM-GENERATED EMAIL NOTIFICATION ONLY. DO NOT REPLY.
                        </p>
                    </div>

                </td>
            </tr>
            <tr>
                <td style="background: #f8f8f8;">
                    <div style="padding: 10px;">
                        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; text-align: center;">
                            <strong>Sustainability Solutions Exchange. {{ date('Y') }}.</strong>
                        </p>
                        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 11px; text-align: center;">
                            Center for International Trade Expositions and Missions (CITEM)<br />Golden Shell Pavilion,
                            ITC Complex,<br />Roxas Boulevard corner Sen. Gil J. Puyat Avenue,<br />Pasay City 1300,
                            Philippines</p>
                        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 11px; text-align: center;">
                            <strong>Tel. no.:</strong> (02) 8.831.2336<br /><strong>Email:</strong> <a
                                href="mailto:{{ env('SSX_EMAIL') }}" target="_blank">{{ env('SSX_EMAIL') }}</a>
                        </p>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="background: #9daa39;">
                    <table cellspacing="0" cellspacing="0" width="100%">
                        <tr>
                            <td><a href="{{ env('APP_URL') }}"><img
                                        src="{{ url('https://sustainability.ph/assets/images/ssx-full-logo-white.png') }}?v=2026_v1"
                                        width="120"></a>
                            </td>
                            <td>
                                <p
                                    style="font-family: Arial, Helvetica, sans-serif; color: #fff; text-align: right; margin-bottom: 0; font-size: 12px; padding-right: 15px;">
                                    Follow Us</p>
                                <p style="text-align: right; margin-top: 0;">
                                    <a href="{{ env('APP_SOCIAL_FACEBOOK') }}" target="_blank">
                                        <img src="{{ url('https://sustainability.ph/assets/images/facebook-icon.png') }}" width="24">
                                    </a>
                                    <a href="{{ env('APP_SOCIAL_LINKEDIN') }}" target="_blank">
                                        <img src="{{ url('https://sustainability.ph/assets/images/linkedin-icon.png') }}" width="24">
                                    </a>
                                    <a href="{{ env('APP_SOCIAL_INSTAGRAM') }}" target="_blank">
                                        <img src="{{ url('https://sustainability.ph/assets/images/instagram-icon.png') }}" width="24">
                                    </a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <p
                        style="font-family: Arial, Helvetica, sans-serif; font-size: 10px; text-align: center; padding: 5px 10%;">
                    </p>
                </td>
            </tr>
        </table>
    </center>
</body>

</html>
