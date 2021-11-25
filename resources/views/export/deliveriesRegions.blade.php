<table>
    <thead>
    <tr>
        <th style="background: #D9D9D9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>title</b>
        </th>
        <th style="background: #d9d9d9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>region</b>
        </th>
        <th style="background: #D9D9D9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>days</b>
        </th>
        <th style="background: #d9d9d9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>value</b>
        </th>
        <th style="background: #d9d9d9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>percent</b>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($deliveries as $delivery)
        @foreach($delivery->region as $region)
            <tr>
                <td>{{ $delivery->title }}</td>
                <td>{{ $region->title }}</td>
                <td>{{ $region->pivot->days }}</td>
                <td>{{ $region->pivot->value }}</td>
                <td>{{ $region->pivot->percent }}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>
