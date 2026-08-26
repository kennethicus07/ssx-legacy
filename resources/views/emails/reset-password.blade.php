<html>

<head>
    <title>{{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/png" href="https://via.placeholder.com/150" />
</head>

<body>
    <center>
        <table cellpadding="10" cellspacing="0" border="0" style="width: 96%; max-width: 768px;">
            <tr>
                <td style="background: #9daa39; border-bottom: #343a40 5px solid;"><a href="{{ env('APP_URL') }}"
                        style="display: block;">
                        <img src="{{ url('https://sustainability.ph/assets/images/ssx-full-logo-white.png') }}"
                            style="width: 70%; max-width: 160px;"></a></td>
            </tr>
            <tr>
                <td>
                    <div
                        style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; line-height: 20px; text-align: left; padding: 30px 20px;">
                        <!--CONTENT HERE -->
                        <p>Hi {{ $fname }},</p>
                        <p>You've asked us to reset your SSX password. Please click on the link below to enter a new
                            password.</p>
                        <p><a href="{{ $reset_link }}" target="_blank">{{ $reset_link }}</a></p>
                        <p>If you didn't request a reset, don't worry. You can safely ignore this email.</p>
                        <p></p>
                        <p style="text-align: center;">THIS IS A SYSTEM-GENERATED EMAIL NOTIFICATION ONLY. DO NOT REPLY.
                        </p>
                        <!--CONTENT END HERE -->
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
                                        src="{{ url('https://sustainability.ph/assets/images/ssx-full-logo-white.png') }}" width="120"></a>
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
