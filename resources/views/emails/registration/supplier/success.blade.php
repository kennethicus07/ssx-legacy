<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/png" href="https://via.placeholder.com/150">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="margin:0; padding:0; background-color:#f4f4f4; font-family: Arial, Helvetica, sans-serif;">

    <center>
        <table cellpadding="0" cellspacing="0" border="0"
            style="width: 96%; max-width: 768px; background-color: #fff;">
            <!-- HEADER -->
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

            <!-- BODY -->
            <tr>
                <td style="padding: 30px 20px; font-size: 13px; line-height: 20px; color: #333;">
                    <p>Hi {{ $fname }},</p>

                    <p>
                        Thank you for registering your company as a Supplier/Exhibitor for
                        <strong>{{ $event_name ?? 'the Sustainability Solutions Exchange (SSX)' }}</strong>!
                    </p>

                    <p>
                        Your application will undergo technical review and evaluation.
                        We will get back to you within 72 hours regarding the result of your
                        application.
                    </p>

                    <p>
                        Please check your Inbox or Spam folder for our next email.
                    </p>

                    <p>
                        If you have questions about your application, feel free to contact our team via
                        <a href="mailto:{{ env('SSX_EMAIL') }}" target="_blank">{{ env('SSX_EMAIL') }}</a>.
                    </p>
                    {{-- @if (!$pdf_failed)
                        <p>You can download your registration summary <a
                                href="{{ asset('storage/exhibitor_summary/' . $pdfFilename) }}"
                                target="_blank">here</a>.</p>
                    @endif --}}

                    <p>Thank you.</p>

                    <p style="margin-top: 40px; font-size: 11px; text-align: center; color: #777;">
                        THIS IS A SYSTEM-GENERATED EMAIL NOTIFICATION ONLY. DO NOT REPLY.
                    </p>
                </td>
            </tr>

            <!-- FOOTER INFO -->
            <tr>
                <td style="background: #f8f8f8; padding: 20px;">
                    <p style="font-size: 12px; text-align: center; margin: 0;">
                        <strong>Sustainability Solutions Exchange. {{ date('Y') }}.</strong>
                    </p>
                    <p style="font-size: 11px; text-align: center; margin: 8px 0;">
                        Center for International Trade Expositions and Missions (CITEM)<br>
                        Golden Shell Pavilion, ITC Complex,<br>
                        Roxas Boulevard corner Sen. Gil J. Puyat Avenue,<br>
                        Pasay City 1300, Philippines
                    </p>
                    <p style="font-size: 11px; text-align: center; margin: 0;">
                        <strong>Tel. no.:</strong> (02) 8.831.2336<br>
                        <strong>Email:</strong>
                        <a href="mailto:{{ env('SSX_EMAIL') }}" target="_blank">{{ env('SSX_EMAIL') }}</a>
                    </p>
                </td>
            </tr>

            <!-- SOCIAL FOOTER -->
            <tr>
                <td style="background: #9daa39; padding: 10px 15px;">
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tr>
                            <td><a href="{{ env('APP_URL') }}"><img
                                        src="{{ url('https://sustainability.ph/assets/images/ssx-full-logo-white.png') }}" width="120"></a>
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
