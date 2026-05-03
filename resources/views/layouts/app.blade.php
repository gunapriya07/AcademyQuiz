<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AcademyQuiz</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { background: #0b0d10; color: #eeeae0; font-family: 'DM Sans', sans-serif; margin: 0; }
        .btn-outline {
            display: inline-block;
            padding: 12px 28px;
            background: transparent;
            color: #eeeae0;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 400;
            border-radius: 10px;
            border: 1px solid #c9a84c44;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-outline:hover { border-color: #c9a84c; color: #c9a84c; }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
