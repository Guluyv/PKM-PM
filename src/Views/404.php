<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        .error-container {
            text-align: center;
            padding: 50px;
            font-family: Arial, sans-serif;
        }
        .error-code {
            font-size: 120px;
            color: #e74c3c;
            margin: 0;
        }
        .error-message {
            font-size: 24px;
            color: #2c3e50;
            margin: 20px 0;
        }
        .home-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .home-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1 class="error-code">404</h1>
        <p class="error-message">Oops! Page Not Found</p>
        <p>The page you are looking for might have been removed or is temporarily unavailable.</p>
        <a href="<?php echo BASE_URL; ?>" class="home-button">Return to Home</a>
    </div>
</body>
</html>