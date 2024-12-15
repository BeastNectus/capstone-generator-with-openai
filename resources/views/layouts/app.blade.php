<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Capstone Idea Hub | Generate Effortlessly</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Agbalumo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Global Styles */
        body, html {
            margin: 0;
            height: 100%;
            font-family: 'Nunito', sans-serif;
            background-color: #06132d;
        }

        main {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 1200px;
        }

        /* Card Styles */
        .card {
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #eee;
            text-align: center;
            padding: 1.5rem;
        }

        .card-body {
            padding: 2rem;
        }

        #result {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
        }

        /* Text and Font Styles */
        .website-title {
            font-family: 'Agbalumo', sans-serif;
            font-size: 3rem;
            color: white;
        }

        .website-description {
            font-size: 1.2rem;
            color: #c9c9c9;
        }

        .developed-by, .developed-by2{
            font-size: 0.9rem;
            color: #c9c9c9;
            text-align: center;
            margin-top: 1rem;
        }

        .developed-by a, .developed-by2 a {
            text-decoration: none;
            color: #c9c9c9;
        }

        #projectTitle {
            font-weight: 700;
            color: #333;
        }

        .project-link {
            font-size: 0.9rem;
            text-decoration: none;
            color: inherit;
        }

        .project-link:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        /* Placeholder Styles */
        #result-placeholder-container {
            height: 100%;
            background: #f8f9fa;
            border-radius: 10px;
        }

        #result-placeholder-container h3 {
            margin-top: 0;
            color: #343a40;
        }

        p {
            margin-bottom: 0 !important;
        }

        .developed-by2{
            display: none;
        }

        @media (max-width: 991px) {
            .developed-by {
                display: none;
            }

            .developed-by2{
                display: block;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
