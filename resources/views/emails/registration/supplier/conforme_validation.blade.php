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
                                {{-- <img src="{{ asset('assets/images/venue-date.png') }}" alt="Event Info" width="180"
                                    style="display:block; border:0; outline:none;" /> --}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <div
                        style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; line-height: 20px; text-align: left; padding: 30px 20px;">
                        <p>Hello {{ $user->name ?? 'Participant' }},</p>
                        <p>Congratulations! You are now officially a Supplier/Exhibitor of {{ $event_name }}!</p>
                        <p>To confirm your participation, please review the
                            <a href="{{ asset('storage/noa/' . $pdfFilename) }}" target="_blank"
                                style="color: #9daa39; text-decoration: underline; font-family: Arial, Helvetica, sans-serif;">
                                conforme</a>, and click the button below for approval.
                        </p>
                        <div style="height: 20px; line-height: 30px;">&nbsp;</div>
                        <p style="text-align: center; margin:34px 0;">
                            <a href="{{ env('APP_URL') . '/conforme/' . $token . '/1' }}" target="_blank"
                                style="background: #9daa39; color: #fff; text-decoration: none; 
                                        padding: 12px 24px; font-size: 14px; 
                                        border-radius: 5px; font-family: Arial, Helvetica, sans-serif;">
                                I have read and I approve the conforme.
                            </a>
                        </p>
                        <p style="text-align: center; margin: 34px 0;">
                            <a href="{{ env('APP_URL') . '/conforme/' . $token . '/0' }}" target="_blank"
                                style="background: #c4c4c3; color: #0e0e0e; text-decoration: none; 
                                        padding: 12px 24px; font-size: 14px; 
                                        border-radius: 5px; font-family: Arial, Helvetica, sans-serif;">
                                I have read and I do not approve the conforme.
                            </a>
                        </p>
                        <div style="height: 20px; line-height: 30px;">&nbsp;</div>
                        <p>While we prepare your Statement of Account, please ensure your account access is secure. You
                            are responsible for sharing your login details with other users from your company. Should
                            there be any changes to your company email and/or password, please communicate within your
                            group as we cannot retrieve the password for you.</p>
                        <p style="text-align: center;">THIS IS A SYSTEM-GENERATED EMAIL. PLEASE DO NOT REPLY.</p>
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
                            Center for International Trade Expositions and Missions (CITEM)<br />
                            Golden Shell Pavilion, ITC Complex,<br />
                            Roxas Boulevard corner Sen. Gil J. Puyat Avenue,<br />
                            Pasay City 1300, Philippines
                        </p>
                        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 11px; text-align: center;">
                            <strong>Tel. no.:</strong> (02) 8.831.2336<br />
                            <strong>Email:</strong> <a href="mailto:{{ env('SSX_EMAIL') }}"
                                target="_blank">{{ env('SSX_EMAIL') }}</a>
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
        </table>
    </center>
</body>

</html>
