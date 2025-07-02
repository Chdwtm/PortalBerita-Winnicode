<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
    body {
        background-color: #f8f9fa;
    }

    .auth-container {
        max-width: 400px;
        margin: auto;
        margin-top: 50px;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .auth-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    </style>
</head>

<body>

    <div class="container">
        @yield('content')
    </div>

</body>

</html>