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
                                    <img src="{{ url('https://sustainability.ph/assets/images/ssx-full-logo-white.png') }}?v=2026_v1" alt="SSX Logo"
                                        width="160"
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

                        <p>Hello,</p>

                        <p>We wanted to inform you that the following supplier/exhibitor has chosen not to approve the
                            conforme for the event <strong>{{ $event_name }}</strong>:</p>

                        <ul>
                            <li><strong>Name:</strong> {{ $exhibitor_name ?? 'N/A' }}</li>
                            <li><strong>Email:</strong> {{ $exhibitor_email ?? 'N/A' }}</li>
                        </ul>

                        {{-- <p>No worries! This is just an update for your awareness. The officers assigned to this
                            supplier/exhibitor are:</p>
                        <ul>
                            <li><strong>Accounting Officer:</strong> {{ $conforme_officer ?? 'N/A' }}</li>
                            <li><strong>Reviewer Officer:</strong> {{ $reviewer_officer ?? 'N/A' }}</li>
                        </ul> --}}

                        <p>Please follow up as needed, or keep this for your records.</p>

                        <p style="text-align: center;">THIS IS A SYSTEM-GENERATED EMAIL. Please do not reply directly.
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
                                        src="{{ url('https://sustainability.ph/assets/images/ssx-full-logo-white.png') }}?v=2026_v1" width="120"></a>
                            </td>
                            <td>
                                <p
                                    style="font-family: Arial, Helvetica, sans-serif; color: #fff; text-align: right; margin-bottom: 0; font-size: 12px; padding-right: 15px;">
                                    Follow Us
                                </p>
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
