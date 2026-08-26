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
                        
                        


                        <table id="email-body" width="100%">
                            <tr>
                                <td>
                                    <p>Hello!,</p>
                                    <p>Here is your Billing Statement for your participation in Sustainability Solutions Exchange Conference 2025:</p>
                                    <p><a href="{{ $billing_statement }}" target="_blank">Click here to view/download your Billing Statement</a></p>
                                    <p><a href="https://forms.gle/32CK8tTZg4acoHLU7" target="_blank" rel="noopener noreferrer">Click here</a> to select your preferred track that you’re most interested in attending.</p>
                                    <p>To confirm your registration, please settle your payment with the amount on IMMEDIATELY through any of the following methods:</p>
                                    <br>
                                </td>  
                            </tr>

                            <tr><td>
                                <table border="0" cellpadding="0" cellspacing="0" width="600" style="margin:0 auto; border-spacing:0;" align="center">
                                    <tr>
                                        <td width="20"></td>
                                        <td width="15" style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;"><strong>1.</strong></td>
                                        <td width="5"></td>
                                        <td width="560" style="font-family: Arial, Helvetica, sans-serif;"><strong>Landbank</strong></td>
                                    </tr>
                                    <tr><td height="5"></td></tr>
                                    <tr>
                                        <td></td><td></td><td></td>
                                        <td>
                                            <table border="0" cellpadding="0" cellspacing="0" width="560" style="margin:0 auto; border-spacing:0;" align="center">
                                                <tr>
                                                    <td width="20"></td>
                                                    <td width="15" style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;">a.</td>
                                                    <td width="5"></td>
                                                    <td width="520" style="font-family: Arial, Helvetica, sans-serif;">On-line Bank Transfer to CITEM account</td>
                                                </tr>
                                                <tr><td height="10"></td></tr>
                                                <tr>
                                                    <td></td><td></td><td></td>
                                                    <td>
                                                        <table border="0" cellpadding="0" cellspacing="0" width="520" style="margin:0 auto; border-spacing:0;" align="center">
                                                            <tr>
                                                                <td width="300" colspan="2" style="font-family: Arial, Helvetica, sans-serif; text-align: center;">
                                                                    <strong>Landbank of the Philippines</strong>
                                                                </td>
                                                                <td width="220"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;">Account Name:&ensp;</td>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: left; vertical-align: top;"><strong>CITEM</strong></td>
                                                            </tr>
                                                            <tr><td height="1"></td></tr>
                                                            <tr>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;">Account No.:&ensp;</td>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: left; vertical-align: top;"><strong>1772-1038-63</strong></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr><td height="15"></td></tr>
                                                <tr>
                                                    <td width="20"></td>
                                                    <td width="15" style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;">b.</td>
                                                    <td width="5"></td>
                                                    <td width="520" style="font-family: Arial, Helvetica, sans-serif;">Landbank Link.BizPortal (Below are the convenience fees of different payment options using LBP Link.BizPortal)</td>
                                                </tr>
                                                <tr><td height="10"></td></tr>
                                                <tr>
                                                    <td></td><td></td><td></td>
                                                    <td>
                                                        <table border="0" cellpadding="5" cellspacing="1" width="520" style="margin:0 auto; border-spacing:1; font-family: Arial, Helvetica, sans-serif;" align="center">
                                                            <tr bgcolor="#000000">
                                                                <td width="400" style="color: #FFFFFF; text-align: left; vertical-align: top;"><strong>PAYMENT OPTION</strong></td>
                                                                <td width="120" style="color: #FFFFFF; text-align: left; vertical-align: top;"><strong>FEES</strong></td>
                                                            </tr>
                                                            <tr bgcolor="#EEEEEE">
                                                                <td style="text-align: left; vertical-align: top;">Landbank Accounts (ATM-SA, ATM-CA, VISA Debit Cards)</td>
                                                                <td style="text-align: left; vertical-align: top;">PHP 7.00</td>
                                                            </tr>
                                                            <tr bgcolor="#EEEEEE">
                                                                <td style="text-align: left; vertical-align: top;">Bancnet-Member Banks ATM Cards</td>
                                                                <td style="text-align: left; vertical-align: top;">PHP 17.00</td>
                                                            </tr>
                                                            <tr bgcolor="#EEEEEE">
                                                                <td style="text-align: left; vertical-align: top;">Landbank Pay</td>
                                                                <td style="text-align: left; vertical-align: top;">PHP 5.00</td>
                                                            </tr>
                                                            <tr bgcolor="#EEEEEE">
                                                                <td style="text-align: left; vertical-align: top;">Globe Gcash</td>
                                                                <td style="text-align: left; vertical-align: top;">PHP 25.00</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                        </td>
                                    </tr>

                                    <tr><td height="30"></td></tr>
                                    <tr>
                                        <td width="20"></td>
                                        <td width="15" style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;"><strong>2.</strong></td>
                                        <td width="5"></td>
                                        <td width="560" style="font-family: Arial, Helvetica, sans-serif;"><strong>Maya</strong></td>
                                    </tr>
                                    <tr><td height="5"></td></tr>
                                    <tr>
                                        <td></td><td></td><td></td>
                                        <td style="font-family: Arial, Helvetica, sans-serif;">Please add P10.00 for convenience fee, on top of the amount indicated on your SOA</td>
                                    </tr>

                                    <tr><td height="30"></td></tr>
                                    <tr>
                                        <td width="20"></td>
                                        <td width="15" style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;"><strong>3.</strong></td>
                                        <td width="5"></td>
                                        <td width="560" style="font-family: Arial, Helvetica, sans-serif;"><strong>UnionBank</strong></td>
                                    </tr>
                                    <tr><td height="5"></td></tr>
                                    <tr>
                                        <td></td><td></td><td></td>
                                        <td style="font-family: Arial, Helvetica, sans-serif;">Below are the convenience fees of different payment options using Unionbank</td>
                                    </tr>
                                    <tr><td height="10"></td></tr>
                                    <tr>
                                        <td></td><td></td><td></td>
                                        <td>
                                            <table border="0" cellpadding="5" cellspacing="1" width="560" style="margin:0 auto; border-spacing:1; font-family: Arial, Helvetica, sans-serif;" align="center">
                                                <tr bgcolor="#000000">
                                                    <td width="440" style="color: #FFFFFF; text-align: left; vertical-align: top;"><strong>PAYMENT OPTION</strong></td>
                                                    <td width="120" style="color: #FFFFFF; text-align: left; vertical-align: top;"><strong>FEES</strong></td>
                                                </tr>
                                                <tr bgcolor="#EEEEEE">
                                                    <td style="text-align: left; vertical-align: top;">OTC (Over-the-Counter) UnionBank branches</td>
                                                    <td style="text-align: left; vertical-align: top;">PHP 20.00</td>
                                                </tr>
                                                <tr bgcolor="#EEEEEE">
                                                    <td style="text-align: left; vertical-align: top;">PCHC Payment Gateway</td>
                                                    <td style="text-align: left; vertical-align: top;">PHP 25.00</td>
                                                </tr>
                                                <tr bgcolor="#EEEEEE">
                                                    <td style="text-align: left; vertical-align: top;">InstaPay</td>
                                                    <td style="text-align: left; vertical-align: top;">PHP 15.00</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="5"></td></tr>
                                    <tr>
                                        <td></td><td></td><td></td>
                                        <td style="font-family: Arial, Helvetica, sans-serif;">
                                            <small><i>Note: If non-Unionbank options will be selected such as e-wallets and Over-the-Counter, applicable convenience fees of said channels shall apply together with the Unionbank fees.</i></small>
                                        </td>
                                    </tr>

                                    <tr><td height="30"></td></tr>
                                    <tr>
                                        <td width="20"></td>
                                        <td width="15" style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;"><strong>4.</strong></td>
                                        <td width="5"></td>
                                        <td width="560" style="font-family: Arial, Helvetica, sans-serif;">For those paying in dollar denominated billing statement, please use the following details:</td>
                                    </tr>
                                    <tr><td height="10"></td></tr>
                                    <tr>
                                        <td></td><td></td><td></td>
                                        <td>
                                            <table border="0" cellpadding="0" cellspacing="0" width="560" style="margin:0 auto; border-spacing:0;" align="center">
                                                <tr>
                                                    <td width="20"></td>
                                                    <td width="15" style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;">a.</td>
                                                    <td width="5"></td>
                                                    <td width="520" style="font-family: Arial, Helvetica, sans-serif;">Direct Deposit to CITEM LBP Dollar Savings Account</td>
                                                </tr>
                                                <tr><td height="10"></td></tr>
                                                <tr>
                                                    <td></td><td></td><td></td>
                                                    <td>
                                                        <table border="0" cellpadding="0" cellspacing="0" width="520" style="margin:0 auto; border-spacing:0;" align="center">
                                                            <tr>
                                                                <td width="300" colspan="2"></td>
                                                                <td width="220"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;">Account Name:&ensp;</td>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: left; vertical-align: top;"><strong>CITEM</strong></td>
                                                            </tr>
                                                            <tr><td height="1"></td></tr>
                                                            <tr>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;">Account No.:&ensp;</td>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: left; vertical-align: top;"><strong>1774-0065-04</strong></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr><td height="15"></td></tr>

                                                <tr>
                                                    <td width="20"></td>
                                                    <td width="15" style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;">b.</td>
                                                    <td width="5"></td>
                                                    <td width="520" style="font-family: Arial, Helvetica, sans-serif;">Telegraphic Transfer to CITEM LBP Dollar Savings Account</td>
                                                </tr>
                                                <tr><td height="10"></td></tr>
                                                <tr>
                                                    <td></td><td></td><td></td>
                                                    <td>
                                                        <table border="0" cellpadding="0" cellspacing="0" width="520" style="margin:0 auto; border-spacing:0;" align="center">
                                                            <tr>
                                                                <td width="150"></td>
                                                                <td width="300"></td>
                                                                <td width="70"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;">Account Name:&ensp;</td>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: left; vertical-align: top;"><strong>CITEM</strong></td>
                                                            </tr>
                                                            <tr><td height="1"></td></tr>
                                                            <tr>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;">Account No.:&ensp;</td>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: left; vertical-align: top;"><strong>1774-0065-04</strong></td>
                                                            </tr>
                                                            <tr><td height="1"></td></tr>
                                                            <tr>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;">Swift Code:&ensp;</td>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: left; vertical-align: top;"><strong>TLBPPHMM</strong></td>
                                                            </tr>
                                                            <tr><td height="1"></td></tr>
                                                            <tr>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;">Branch:&ensp;</td>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: left; vertical-align: top;"><strong>Century Park Hotel (Harrison Plaza) Branch</strong></td>
                                                            </tr>
                                                            <tr><td height="1"></td></tr>
                                                            <tr>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: right; vertical-align: top;">Address:&ensp;</td>
                                                                <td style="font-family: Arial, Helvetica, sans-serif; text-align: left; vertical-align: top;"><strong>Ground Floor, Century Park Tower P. Ocampo corner Adriatico Street, Malate, Manila</strong></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr><td height="15"></td></tr>
                                            </table>
                                        </td>
                                    </tr>



                                </table>
                            </td></tr>

                            <tr>
                                <td>
                                <br>
                                    <p><strong>Other Payment options</strong>
                                    <br>Additional payment options are available on the CITEM website. <a href="https://citem.gov.ph/services/payment" target="_blank">Click here</a> to open the CITEM Payments page.</p>
                                </td>  
                            </tr>

                            <tr>
                                <td>
                                <br>
                                    <p><strong>Submission of Proof of Payment</strong>
                                    <br>
                                    After completing your payment, kindly send a copy of your proof of payment to <a href="mailto:sustainabilityph@citem.com.ph">sustainabilityph@citem.com.ph</a> with the subject line: SSX Conference 2025 Payment Bill No. [Your Billing Number] for verification and confirmation of your registration.
                                </td>  
                            </tr>

                            <tr>
                                <td>
                                <br>
                                    <p>Thank you!</p>
                                    <p id="donot-reply"><strong >THIS IS A SYSTEM-GENERATED EMAIL NOTIFICATION ONLY. DO NOT REPLY.</strong></p>
                                </td>  
                            </tr>
                        </table>
                        
                        
                        
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
            <!-- FOOTER -->
            <!-- <tr>
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
            </tr> -->
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