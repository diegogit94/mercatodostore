<ul>
    @foreach($products as $product)
            <li>{{ $product->name }}</li>
        <li><a href="{{ $menu_item->link() }}"><i class="fa {{ $product->name }}"></i></a></li>
    @endforeach
</ul>
