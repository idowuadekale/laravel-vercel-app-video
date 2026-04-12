<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsubscribed Successfully</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        padding: 50px;
        background-color: #f5f5f5;
    }

    .container {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
    }

    h1 {
        color: #4f46e5;
    }

    p {
        color: #666666;
        line-height: 1.6;
    }

    a {
        color: #4f46e5;
        text-decoration: none;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Unsubscribed Successfully</h1>
        <p>The email address <strong>{{ $email }}</strong> has been removed from our mailing list.</p>
        <p>We're sorry to see you go. If this was a mistake, you can resubscribe from our page.</p>
        <p><a href="{{ url('/') }}">Return to our website</a></p>
    </div>
</body>

</html>