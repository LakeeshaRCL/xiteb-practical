<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

    </style>
</head>

<body class="antialiased">
    <div class="titleArea" style="text-align: center;">
        <h1>Medical Prescripton System</h1>
    </div>
    <!--import layout-->
    @yield('bodyContent')

     <div class="footerArea">
        <footer style="text-align: center">
            &copy; Lakeesha Ramanayake - Software Engineer <br>
        </footer>
     </div>
</body>

</html>
