<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to LASU CNS CHAPTER Newsletter</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
    <table width="100%" cellspacing="0" cellpadding="0" style="background-color: #f5f5f5; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="600" cellspacing="0" cellpadding="0"
                    style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #4f46e5; padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">Welcome to LASU CNS CHAPTER</h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <h2 style="color: #333333; margin-top: 0;">Thank You for Subscribing!</h2>
                            <p style="color: #666666; line-height: 1.6; margin-bottom: 20px;">
                                Dear Subscriber,
                            </p>
                            <p style="color: #666666; line-height: 1.6; margin-bottom: 20px;">
                                This is to inform you that you have successfully subscribed to our newsletter.
                                You'll now receive relevant updates and communications from LASU CNS CHAPTER.
                            </p>
                            <p style="color: #666666; line-height: 1.6; margin-bottom: 20px;">
                                We're excited to share the latest news, events, and insights with you.
                            </p>
                            <p style="color: #666666; line-height: 1.6;">
                                God bless you.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background-color: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #6b7280; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 10px 0;">
                                &copy; {{ date('Y') }} LASU CNS CHAPTER. All rights reserved.
                            </p>
                            <p style="margin: 0 0 10px 0;">
                                {{ config('app.mail', 'contact@lasucns.org') }}
                            </p>
                            <p style="margin: 0;">
                                <a href="{{ route('unsubscribe', ['email' => $email]) }}"
                                    style="color: #4f46e5; text-decoration: none;">Unsubscribe</a>
                                &nbsp;|&nbsp;
                                <a href="{{ config('app.url', url('/')) }}"
                                    style="color: #4f46e5; text-decoration: none;">Our Website</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>