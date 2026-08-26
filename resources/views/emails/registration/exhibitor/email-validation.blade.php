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
                        <p>Hello!,</p>
                        <p>We appreciate your interest in joining Sustainability Solutions Exchange (SSX).</p>
                        <p>Please prepare to submit the following online documents, before you proceed with the registration process:</p>
                        <!-- <p><a href="{{ $reg_link }}" target="_blank">{{ $reg_link }}</a></p> -->
                        <p>REQUIREMENTS FOR LOCAL COMPANIES<br/>Note: Asterisked are mandatory requirements</p>
                        <center>
                            <table cellpadding="5" cellspacing="1" width="95%"
                                style="font-family: Arial, Helvetica, sans-serif !important; font-size: 12px !important;">
                                <tr style="background: #ECECEC">
                                    <td>1.</td>
                                    <td>DTI/SEC/CDA BUSINESS REGISTRATION *</td>
                                </tr>
                                <tr style="background: #ECECEC">
                                    <td>2.</td>
                                    <td>BIR CERTIFICATE OF REGISTRATION *</td>
                                </tr>
                                <tr style="background: #ECECEC">
                                    <td>3.</td>
                                    <td>VALID MAYOR'S PERMIT</td>
                                </tr>
                                <tr style="background: #ECECEC">
                                    <td>4.</td>
                                    <td>VALID DENR-ISSUED CERTIFICATE/S (DP or DISCHARGE PERMIT; PTO or PERMIT TO OPERATE; CNC or CERTIFICATE OF NON-COVERAGE; ECC or ENVIRONMENTAL COMPLIANCE CERTIFICATE)</td>
                                </tr>
                                <tr style="background: #ECECEC">
                                    <td>5.</td>
                                    <td>VALID FDA LICENSE TO OPERATE & CERTIFICATE PRODUCT REGISTRATION <strong>(FOR FOOD & COSMETIC PRODUCTS)</strong> *</td>
                                </tr>
                                <tr style="background: #ECECEC">
                                    <td>6.</td>
                                    <td>ANY VALID CERTIFICATE/S ISSUED BY 3RD-PARTY CERTIFICATION BODIES (e.g., BRC, ECOCERT, GREEN CHOICE, FAIRTRADE, FSC, HACCP, HALAL, ISO, KOSHER, USDA)</td>
                                </tr>
                                <tr style="background: #ECECEC">
                                    <td>7.</td>
                                    <td>INSTITUTIONAL BROCHURE/CATALOG INCLUDING COMPANY PROFILE, PRODUCT PHOTOS, LOCATION, CONTACT INFORMATION. *</td>
                                </tr>
                            </table>
                        </center>
                        <p>REQUIREMENTS FOR FOREIGN COMPANIES<br/>Note: Asterisked are mandatory requirements</p>
                        <center>
                            <table cellpadding="5" cellspacing="1" width="95%"
                                style="font-family: Arial, Helvetica, sans-serif !important; font-size: 12px !important;">
                                <tr style="background: #ECECEC">
                                    <td>1.</td>
                                    <td>VALID CERTIFICATE/S ISSUED BY COUNTRY'S REGULATION BODIES AND/OR 3RD-PARTY CERTIFICATION BODIES (e.g., Food and Drug Certification or its equivalent, BRC, ECOCERT, GREEN CHOICE, FAIRTRADE, FSC, HACCP, HALAL, ISO, KOSHER, USDA) *</td>
                                </tr>
                                <tr style="background: #ECECEC">
                                    <td>2.</td>
                                    <td>INSTITUTIONAL BROCHURE/CATALOG INCLUDING COMPANY PROFILE, PRODUCT PHOTOS, LOCATION, CONTACT INFORMATION. *</td>
                                </tr>
                            </table>
                        </center>
                        <p>Once you have checked off all the items in the list that applies to your company, now you're ready for the next step. Click here: <a href="{{ $reg_link }}" target="_blank">{{ $reg_link }}</a></p>
                        <p>Thank you.</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p style="text-align: center;">THIS IS A SYSTEM-GENERATED EMAIL NOTIFICATION ONLY. DO NOT REPLY.</p>
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
                                        src="{{ url('https://sustainability.ph/assets/images/ssx-full-logo-white.png') }}" width="120"></a></td>
                            <td>
                                <p
                                    style="font-family: Arial, Helvetica, sans-serif; color: #fff; text-align: right; margin-bottom: 0; font-size: 12px; padding-right: 15px;">
                                    Follow Us</p>
                                <p style="text-align: right; margin-top: 0;"><a href="{{ env('APP_SOCIAL_FACEBOOK') }}"
                                        target="_blank"><img
                                            src="https://reprisestudio1.com/IFEXPH/assets/images/facebook_ico.jpg"></a><a
                                        href="{{ env('APP_SOCIAL_TWITTER') }}" target="_blank"><img
                                            src="https://reprisestudio1.com/IFEXPH/assets/images/twitter_ico.jpg"></a><a
                                        href="{{ env('APP_SOCIAL_INSTAGRAM') }}" target="_blank"><img
                                            src="https://reprisestudio1.com/IFEXPH/assets/images/instagram_ico.jpg"></a>
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