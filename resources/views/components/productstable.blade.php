@if (session()->has('successMsg'))
    <div class="successMsg">
        {{ session()->get('successMsg') }}
    </div>
@endif
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>website</th>
            <th>url</th>
            <th>brand</th>
            <th>description</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->website }}</td>
                <td>{{ $product->product_url }}</td>
                <td>{{ $product->brand }}</td>
                <td>{{ $product->description }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('table').DataTable({
            responsive: true
        });
    });
</script>
