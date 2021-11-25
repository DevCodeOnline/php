<table>
    <thead>
    <tr>
        <th style="background: #d9d9d9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>id_best_product</b>
        </th>
        <th style="background: #d9d9d9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>id_new_product</b>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($mains as $main)
        <tr>
            <td>{{ $main->best_product_id }}</td>
            <td>{{ $main->new_product_id }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
