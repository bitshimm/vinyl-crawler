@if (session()->has('successMsg'))
    <div class="successMsg">
        {{ session()->get('successMsg') }}
    </div>
    <style>
        .successMsg {
            color: #fff;
            margin-bottom: 1em;
            background-color: #6d5dfc;
        }
    </style>
@endif
<div class="products_table">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>website</th>
                <th>tilda_uid</th>
                <th>brand</th>
                <th>description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->website }}</td>
                    <td>{{ $product->tilda_uid }}</td>
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
</div>
