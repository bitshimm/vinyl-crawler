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
