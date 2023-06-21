@extends('layouts.app')

@section('content')
    <ul class="links">
        <li class="link"><a href="{{ route('vinylmarkt.show') }}">таблица</a></li>
        <li class="link"><a href="{{ route('get-available') }}">получить доступные</a></li>
    </ul>
    <style>
        .links {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(3, 1fr);
            margin: auto;
            list-style-type: none;
            text-align: center
        }

        .link {
            border-color: #d1d9e6;
            transition: .2s;
        }

        .link:hover {
            box-shadow: inset 2px 2px 5px #b8b9be, inset -3px -3px 7px #fff;
            transition: .2s;
        }

        .link a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #31344b;
            font-size: 20px;
        }
    </style>
@endsection
