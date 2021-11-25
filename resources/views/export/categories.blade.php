<table>
    <thead>
    <tr>
        <th style="background: #D9D9D9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>id_category</b>
        </th>
        <th style="background: #D9D9D9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>title</b>
        </th>
        <th style="background: #D9D9D9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>image</b>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->title }}</td>
            <td>{{ asset("uploads/$category->image") }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
