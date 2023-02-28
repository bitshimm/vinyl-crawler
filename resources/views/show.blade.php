@extends('layouts.app')

@section('content')
    <div class="show_section">
        <div class="show_left_section">
            <div class="show_left_top_section">
                <a href="{{ route('vinylmarkt.fillLinks') }}">Обновить записи</a>
            </div>
            <div class="show_export_fields">
                <form action="/export" method="get">
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
            <table>
                <thead>
                    <tr>
                        <th>field 1</th>
                        <th>field 2</th>
                        <th>field 3</th>
                        <th>field 4</th>
                        <th>field 5</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1 ha-ha-ha-ha</td>
                        <td>2 ha-ha-ha-ha</td>
                        <td>3 ha-ha-ha-ha</td>
                        <td>4 ha-ha-ha-ha</td>
                        <td>5 ha-ha-ha-ha</td>
                    </tr>
                    <tr>
                        <td>1 ha-ha-ha-ha</td>
                        <td>2 ha-ha-ha-ha</td>
                        <td>3 ha-ha-ha-ha</td>
                        <td>4 ha-ha-ha-ha</td>
                        <td>5 ha-ha-ha-ha</td>
                    </tr>
                    <tr>
                        <td>1 ha-ha-ha-ha</td>
                        <td>2 ha-ha-ha-ha</td>
                        <td>3 ha-ha-ha-ha</td>
                        <td>4 ha-ha-ha-ha</td>
                        <td>5 ha-ha-ha-ha</td>
                    </tr>
                    <tr>
                        <td>1 ha-ha-ha-ha</td>
                        <td>2 ha-ha-ha-ha</td>
                        <td>3 ha-ha-ha-ha</td>
                        <td>4 ha-ha-ha-ha</td>
                        <td>5 ha-ha-ha-ha</td>
                    </tr>
                    <tr>
                        <td>1 ha-ha-ha-ha</td>
                        <td>2 ha-ha-ha-ha</td>
                        <td>3 ha-ha-ha-ha</td>
                        <td>4 ha-ha-ha-ha</td>
                        <td>5 ha-ha-ha-ha</td>
                    </tr>
                </tbody>
            </table>
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
            margin-bottom: auto;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            box-shadow: inset 3px 3px 6px #b8b9be, inset -3px -3px 6px #fff;
            display: flex;
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

        .custom_checkbox_block {
            display: block;
            margin-bottom: 10px;
            color: #9baacf;
        }

        .custom_checkbox_block label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            user-select: none;
            cursor: pointer;
            box-shadow: 3px 3px 6px #b8b9be, -3px -3px 6px #fff;
            padding: 10px 20px;
            border-radius: 5px;
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
            color: #5b0eeb;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            flex-grow: 0;
            border-radius: 0.25em;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 50% 50%;
            margin-left: 30px;
            box-shadow: inset 1px 1px 3px #b8b9be, inset -1px -1px 3px #fff;
        }

        .custom_checkbox_block input:checked~label::after {
            content: '\1F5F8';
        }

        .custom_checkbox_block input:checked~label {
            color: #5b0eeb;
        }

        .show_export_fields input[type=submit] {
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
    <script>
        $(document).ready(function() {
            $('table').DataTable();
        });
    </script>
@endsection
