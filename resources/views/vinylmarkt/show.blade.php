@extends('layouts.app')

@section('content')
    <div class="show_section">
        <div class="show_left_section">
            <div class="show_left_top_section">
                <form action="{{ route('vinylmarkt.fillLinks') }}" class="form_data_move">
                    <input type="number" name="fill_from" placeholder="От" min="1">
                    <input type="number" name="fill_to" placeholder="До" min="1">
                    <input type="submit" value="Обновить идентификаторы">
                </form>
                
            </div>
            <div class="show_left_top_section">
                <form action="{{ route('vinylmarkt.updateProducts') }}" class="form_data_move">
                    {{-- <input type="number" name="update_from" placeholder="От" min="1">
                    <input type="number" name="update_to" placeholder="До" min="1"> --}}
                    <input type="submit" value="Заполнить данные">
                </form>
            </div>
            <div class="show_export_fields">
                <form action="{{ route('vinylmarkt.export') }}" method="get">
                    <div class="custom_checkbox_block">
                        <input type="checkbox" name="fields[]" value="tilda_uid" id="tilda_uid">
                        <label for="tilda_uid">Tilda UID </label>
                    </div>
                    <div class="custom_checkbox_block">
                        <input type="checkbox" name="fields[]" value="brand" id="brand">
                        <label for="brand">Brand </label>
                    </div>
                    <div class="custom_checkbox_block">
                        <input type="checkbox" name="fields[]" value="description" id="description">
                        <label for="description">Description </label>
                    </div>
                    <div class="custom_checkbox_block">
                        <input type="checkbox" name="fields[]" value="category" id="category">
                        <label for="category">Category </label>
                    </div>
                    <div class="custom_checkbox_block">
                        <input type="checkbox" name="fields[]" value="title" id="title">
                        <label for="title">Title </label>
                    </div>
                    <div class="custom_checkbox_block">
                        <input type="checkbox" name="fields[]" value="text" id="text">
                        <label for="text">Text </label>
                    </div>
                    <div class="custom_checkbox_block">
                        <input type="checkbox" name="fields[]" value="photo" id="photo">
                        <label for="photo">Photo </label>
                    </div>
                    <div class="custom_checkbox_block">
                        <input type="checkbox" name="fields[]" value="seo_title" id="seo_title">
                        <label for="seo_title">SEO title </label>
                    </div>
                    <div class="custom_checkbox_block">
                        <input type="checkbox" name="fields[]" value="seo_descr" id="seo_descr">
                        <label for="seo_descr">SEO descr </label>
                    </div>
                    <div class="custom_checkbox_block">
                        <input type="checkbox" name="fields[]" value="seo_keywords" id="seo_keywords">
                        <label for="seo_keywords">SEO keywords </label>
                    </div>
                    <div class="custom_checkbox_block">
                        <input type="checkbox" name="fields[]" value="price" id="price">
                        <label for="price">Price</label>
                    </div>
                    <div class="custom_checkbox_block">
                        <input type="checkbox" name="fields[]" value="video" id="video">
                        <label for="video">УРЛ Видео</label>
                    </div>
                    <div class="custom_checkbox_block">
                        <input type="checkbox" name="fields[]" value="text_product_card" id="text_product_card">
                        <label for="text_product_card">Текст карточки товара </label>
                    </div>
                    <div class="custom_checkbox_block">
                        <input type="checkbox" name="fields[]" value="track_list" id="track_list">
                        <label for="track_list">Трек-лист </label>
                    </div>
                    <input type="submit" value="Выгрузить">
                </form>
            </div>
        </div>

        <div class="show_table">
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

        .show_left_section {
            width: 250px;
            display: flex;
            flex-flow: column;
            flex-wrap: wrap;
        }

        .show_left_top_section {
            margin-bottom: 20px;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            box-shadow: inset 3px 3px 6px #b8b9be, inset -3px -3px 6px #fff;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;

        }

        .show_left_top_section a {
            display: block;
            text-decoration: none;
            text-align: center;
            color: #9baacf;
            box-shadow: 3px 3px 6px #b8b9be, -3px -3px 6px #fff;
            padding: 10px 20px;
            width: 100%;
            border-radius: 5px;
        }

        .form_data_move {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            padding: 5px;
            box-shadow: 3px 3px 6px #b8b9be, -3px -3px 6px #fff;
            gap: 5px 0 ;
        }

        .form_data_move input {
            width: 50%;
            display: block;
            padding: 5px 10px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
        }

        .show_table {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            box-shadow: inset 3px 3px 6px #b8b9be, inset -3px -3px 6px #fff;
        }

        .show_table table {
            width: 100%;
        }

        .show_export_fields {
            padding: 10px;
            border-radius: 5px;
            box-shadow: inset 3px 3px 6px #b8b9be, inset -3px -3px 6px #fff;

        }

        .show_export_fields form {
            box-shadow: 3px 3px 6px #b8b9be, -3px -3px 6px #fff;
        }

        .custom_checkbox_block label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            user-select: none;
            cursor: pointer;
            /* box-shadow: 3px 3px 6px #b8b9be, -3px -3px 6px #fff; */
            padding: 10px 5px;
            border-radius: 5px;
            position: relative;
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

        /* .custom_checkbox_block label::after {
                                    content: '';
                                    position: absolute;
                                    left: 1px;
                                    color: #5b0eeb;
                                    display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        flex-shrink: 0;
                                        flex-grow: 0;
                                    width: 15px;
                                    height: 15px;

                                    border-radius: 0.25em;
                                        background-repeat: no-repeat;
                                        background-position: center center;
                                        background-size: 50% 50%;
                                    margin-left: 30px;
                                    box-shadow: inset 1px 1px 3px #b8b9be, inset -1px -1px 3px #fff;
                                } */

        /* .custom_checkbox_block input:checked~label::after {
                                    content: '\1F5F8';
                                } */

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
            box-shadow: inset 0.2rem 0.2rem 1rem #8abdff, inset -0.2rem -0.2rem 1rem #5b0eeb, 0.3rem 0.3rem 0.6rem #c8d0e7, -0.2rem -0.2rem 0.5rem #fff;
        }
    </style>
@endsection
