<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $subject }}</title>
    <style type="text/css">
        /* Client-specific styles */
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        /* Reset styles */
        body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }
    </style>
</head>

<body
    style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; margin: 0; padding: 0; color: #333; background-color: #f7f7f7;">
    <!-- Email Container -->
    <table width="100%" cellspacing="0" cellpadding="0" style="background-color: #f7f7f7;">
        <tr>
            <td style="text-align: center; vertical-align: top;" align="center" valign="top">

                <!-- Main Content -->
                <table width="600" cellspacing="0" cellpadding="0"
                    style="margin: 20px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #4f46e5; padding: 30px 20px; text-align: center;">
                            <img src="{{ url('assets/img/favicon.png') }}" alt="{{ config('app.name') }} Logo"
                                style="max-width: 150px; height: auto; display: inline-block;">
                            <!-- <h1 style="color: #ffffff; margin: 0; font-size: 24px;">{{ config('app.name') }}</h1> -->
                        </td>
                    </tr>

                    <!-- Content Container -->
                    <tr>
                        <td style="padding: 30px;">
                            <!-- Rich Text Content Wrapper -->
                            <div
                                style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            font-size: 15px; line-height: 1.6; color: #333; text-align: center;">

                                <!--[if mso]>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" style="padding: 0 10px;">
    <![endif]-->

                                <!-- Logo / Template Image -->
                                @if (!empty($image_url))
                                    <img src="{{ $image_url }}" alt="Template Logo" width="350"
                                        style="display: block; margin: 0 auto 20px auto; border-radius: 10px; 
               width: 350px; height: auto; border: 0; outline: none; text-decoration: none;">
                                @endif

                                <!-- Main Content -->
                                <div style="text-align: left; margin-bottom: 20px;">
                                    {!! $content !!}
                                </div>

                                <!-- User-Uploaded Flyer Section -->
                                @if (!empty($image))
                                    <div style="text-align: center; margin-top: 20px;">
                                        <p style="margin-bottom: 10px; font-weight: bold;">
                                            Attached Flyer
                                        </p>
                                        <a href="{{ url('storage/' . $image) }}" target="_blank"
                                            style="text-decoration: none;">
                                            <img src="{{ url('storage/' . $image) }}" alt="Flyer Image" width="200"
                                                style="display: block; margin: 0 auto; border-radius: 8px; 
                       width: 200px; height: auto; border: 1px solid #ccc; outline: none; text-decoration: none;">
                                        </a>
                                        <p style="margin-top: 8px; font-size: 13px; color: #555;">
                                            Click the flyer above to view or download.
                                        </p>
                                        <a href="{{ url('storage/' . $image) }}" target="_blank"
                                            style="display: inline-block; margin-top: 5px; padding: 8px 15px; 
                  background-color: #4f46e5; color: #ffffff; border-radius: 5px; 
                  text-decoration: none; font-size: 14px;">
                                            View / Download Flyer
                                        </a>
                                    </div>
                                @endif

                                <!--[if mso]>
            </td>
        </tr>
    </table>
    <![endif]-->
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background-color: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #6b7280; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 3px 0;">
                                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                            <p style="margin: 0 0 10px 0;">
                                {{ config('app.mail') }}.
                            </p>
                            <p style="margin: 0;">
                                <a href="{{ route('unsubscribe', ['email' => $email]) }}"
                                    style="color: #4f46e5; text-decoration: none;">
                                    Unsubscribe
                                </a>
                                &nbsp;|&nbsp;
                                <a href="{{ config('app.url') }}" style="color: #4f46e5; text-decoration: none;">Our
                                    Website</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
