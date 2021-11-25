<table>
    <thead>
    <tr>
        <th style="background: #d9d9d9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>id_product</b>
        </th>
        <th style="background: #D9D9D9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>quantity</b>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->quantity }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
