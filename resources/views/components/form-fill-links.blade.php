<form action="{{ route('vinylmarkt.fillLinks') }}" class="form_data_move">
    <input type="number" name="fill_from" placeholder="От" min="1">
    <input type="number" name="fill_to" placeholder="До" min="1">
    <input type="submit" value="Обновить идентификаторы">
</form>