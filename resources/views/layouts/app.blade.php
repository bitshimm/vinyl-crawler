<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crawler</title>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <x-navbar />
    <div class="content_wrapper">
        <div class="content">
            @if (session()->has('successMsg'))
                <div class="successMsg shadow_outside">
                    {{ session()->get('successMsg') }}
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            height: 100vh;
            background-color: #e6e7ee;
        }

        .content_wrapper {
            margin-left: 250px;
            padding: 10px 15px;
        }

        .successMsg {
            font-size: 20px;
            text-align: center;
            width: 100%;
            color: #fff;
            margin-bottom: 1em;
            background-color: #6d5dfc;
        }

        .shadow_inside {
            padding: 10px;
            border-radius: 5px;
            box-shadow: inset 2px 2px 5px #b8b9be, inset -3px -3px 7px #fff;
        }

        .shadow_outside {
            padding: 5px;
            border-radius: 5px;
            border-color: #d1d9e6;
            box-shadow: 3px 3px 6px #b8b9be, -3px -3px 6px #fff;
        }
    </style>
</body>

</html>
