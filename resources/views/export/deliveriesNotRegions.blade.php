<table>
    <thead>
    <tr>
        <th style="background: #D9D9D9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>title</b>
        </th>
        <th style="background: #d9d9d9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>region</b>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($deliveries as $delivery)
        @foreach($delivery->notRegion as $region)
            <tr>
                <td>{{ $delivery->title }}</td>
                <td>{{ $region->pivot->title }}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>
