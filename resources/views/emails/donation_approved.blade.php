<!DOCTYPE html>
<html>

<head>
    <title>Donation Request Approved</title>
    <style>
        .email-content {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
        }

        .email-content .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .email-content .message {
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="email-content">
        <div class="logo">
            <h2 class="logo">Blood Donation</h2>
            <button class="btn collapse-menu" type="button" data-collapse-menu>
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="message">
            <p>{{ $message }}</p>
        </div>
    </div>
</body>

</html>