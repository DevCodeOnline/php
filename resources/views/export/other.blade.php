<table>
    <thead>
    <tr>
        <th style="background: #D9D9D9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>id_image</b>
        </th>
        <th style="background: #D9D9D9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>image</b>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($others as $other)
        <tr>
            <td>{{ $other->id }}</td>
            <td>{{ asset("uploads/$other->image") }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
