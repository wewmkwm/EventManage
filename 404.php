<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 0px;
            color: #333;
        }
        .error-container {
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            font-size: 48px;
            color: #d9534f;
        }
        p {
            font-size: 18px;
        }
        a {
            color: #5bc0de;
            text-decoration: none;
            font-size: 18px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php include 'nav.php'?>

    <div class="error-container">
        <h1>Error 404</h1>
        <p>Oops! The page you're looking for can't be found.</p>
        <a href="index.php">Go Back to Homepage</a>
    </div>
</body>
</html>
