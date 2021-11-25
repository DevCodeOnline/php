<table>
    <thead>
    <tr>
        <th style="background: #d9d9d9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>id_product</b>
        </th>
        <th style="background: #D9D9D9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>title</b>
        </th>
        <th style="background: #D9D9D9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>link_product</b>
        </th>
        <th style="background: #d9d9d9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>images</b>
        </th>
        <th style="background: #D9D9D9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>categories</b>
        </th>
        <th style="background: #d9d9d9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>best</b>
        </th>
        <th style="background: #d9d9d9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>description</b>
        </th>
        <th style="background: #D9D9D9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>reviews</b>
        </th>
        <th style="background: #D9D9D9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>quantity</b>
        </th>
        <th style="background: #d9d9d9;border-bottom: 2px solid black;border-right: 2px solid black;">
            <b>price</b>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->title }}</td>
            <td>{{ route('product', ['slug' => $product->slug]) }}</td>
            <td>{{ str_replace('\\', '/', asset("uploads/$product->image") . ';')}}@foreach($product->images as $image){{str_replace('\\', '/', asset(trim("uploads/$image->image")))}}{{($loop->last ? '' : ';')}}@endforeach</td>
            <td>@foreach($product->categories as $category){{trim($category->title)}}{{($loop->last ? '' : ';')}}@endforeach</td>
            <td>@foreach($product->best as $best){{trim($best->id)}}{{($loop->last ? '' : ';')}}@endforeach</td>
            <td>{{ $product->description }}</td>
            <td>@foreach($product->comments as $comment){{trim($comment->content)}}{{($loop->last ? '' : ';')}}@endforeach</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->price }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
