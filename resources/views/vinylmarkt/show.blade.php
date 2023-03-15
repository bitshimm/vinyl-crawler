@extends('layouts.app')

@section('content')
    <div class="show_section">
        <div class="left_section shadow_inside">
            <div class="form_block shadow_outside">
                <x-form-fill-links />
            </div>
            <div class="shadow_outside">
                <x-form-update />
            </div>
            <div class="shadow_outside">
                <x-form-export />
            </div>
        </div>

        <div class="right_section shadow_inside">
            <x-productstable :$products />
        </div>
    </div>
    <style>
        .show_section {
            padding: 10px;
            display: flex;
            width: 100%;
            gap: 10px;
        }

        .left_section {
            width: 250px;
            display: flex;
            flex-flow: column;
            flex-wrap: wrap;
            gap: 10px;
        }
        .left_section .form_block form{
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            gap: 5px 0;
        }
        .left_section .form_block form input[type=number]{
            width: 50%;
            display: block;
            padding: 5px 10px;
            font-size: 16px;
            border: none;
        }

        .right_section {
            flex-grow: 1;
        }

        .right_section table {
            width: 100%;
        }

        .custom_checkbox_block label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            user-select: none;
            cursor: pointer;
            padding: 10px 5px;
            border-radius: 5px;
            position: relative;
            padding-left: 30px;
        }

        .custom_checkbox_block input {
            position: absolute;
            z-index: -1;
            opacity: 0;
        }

        .custom_checkbox_block label:hover {
            color: #5b0eeb;
            transition: 0.2s;
        }

        .custom_checkbox_block label::after {
            content: '';
            position: absolute;
            left: 3px;
            color: #5b0eeb;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            flex-grow: 0;
            width: 20px;
            height: 20px;
            border-radius: 0.25em;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 50% 50%;
            box-shadow: inset 1px 1px 3px #b8b9be, inset -1px -1px 3px #fff;
        }

        .custom_checkbox_block input:checked~label::after {
            content: '\1F5F8';
        }

        .custom_checkbox_block input:checked~label {
            color: #5b0eeb;
        }

        input[type=submit] {
            cursor: pointer;
            width: 100%;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 14px;
            background: #6d5dfc;
            /* box-shadow: inset 0.2rem 0.2rem 1rem #8abdff, inset -0.2rem -0.2rem 1rem #5b0eeb, 0.3rem 0.3rem 0.6rem #c8d0e7, -0.2rem -0.2rem 0.5rem #fff; */
        }
    </style>
@endsection
