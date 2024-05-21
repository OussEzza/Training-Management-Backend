<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Expired</title>
</head>
<body>
    <h1>Your Training Has Expired</h1>
    <p>Hello {{ $agent->name }},</p>
    <p>We regret to inform you that your training "{{ $training->name }}" has expired.</p>
    <p>Please contact your supervisor or training coordinator for further instructions.</p>
    <p>Thank you.</p>
</body>
</html>
