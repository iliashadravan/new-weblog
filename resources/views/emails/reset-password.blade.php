<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: #ffffff;
            text-align: center;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .container {
            background: rgba(255, 255, 255, 0.12);
            max-width: 420px;
            padding: 35px;
            border-radius: 18px;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        h2 {
            font-size: 26px;
            margin-bottom: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        p {
            color: #ddd;
            font-size: 16px;
            line-height: 1.8;
        }

        .password-box {
            display: inline-block;
            background: linear-gradient(135deg, #ffdd00, #ffbb00);
            color: #222;
            font-size: 24px;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: bold;
            margin: 20px 0;
            box-shadow: 0 6px 12px rgba(255, 204, 0, 0.5);
            transition: transform 0.2s, box-shadow 0.3s ease-in-out;
            animation: popUp 0.6s ease-in-out;
        }

        .password-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 204, 0, 0.6);
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #bbb;
        }

        .footer a {
            color: #ffcc00;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .footer a:hover {
            color: #fff;
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes popUp {
            from {
                transform: translateY(10px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Password Reset</h2>
    <p>Your new password has been generated successfully. Please use it to log in and change it immediately for security purposes.</p>
    <div class="password-box">{{ $newPassword }}</div>
    <p>If you did not request this change, please contact support immediately.</p>
    <div class="footer">
        Need help? <a href="mailto:support@example.com">Contact Support</a>
    </div>
</div>
</body>
</html>
