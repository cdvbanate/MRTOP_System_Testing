<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onboarding Instructions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 40px;
        }
        .container {
            margin: 0 auto;
            padding: 40px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2, h3 {
            color: #007bff;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Good day {{ $user->institution_name }},</h1>

        <p>Thank you for submitting your onboarding requirements for <b>{{ $request->qualification->qualification_name }}</b>.The technical team will review it and provide feedback once they’ve completed their assessment.</p>

        <p>Should you have any questions, feel free to contact us via the FB LMS Technical Support Group Chat.</p>
        <p>Looping in this email Mr/Ms<b>{{ $user->name }}</b> the LMS Administrator of <b>{{ $user->institution_name }}</b> </p>

        <p>Thank you!</p>

        <div class="footer">
            <p>Regards,</p>
            <p>Information Technology Team<br>eTESDA Division</p>
        </div>
    </div>
</body>
</html>
