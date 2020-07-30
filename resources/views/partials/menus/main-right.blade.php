<ul>
    @auth
        @if (Auth::user()->user_type == 'admin')
            <li><a href="{{ route('users.index') }}">Admin</a></li>
        @endif
        <li><a href="{{ route('store') }}">Store</a></li>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="#"><img src="/img/cart.png" alt="cart image" width="30mx" height="30mx"></a></li>

    @else

        <li><a href="{{ route('register') }}">Register</a></li>
        <li><a href="{{ route('login') }}">Login</a></li>
    @endauth

{{--    <li><a href="{{ route('cart.index') }}">Cart--}}
{{--    @if (Cart::instance('default')->count() > 0)--}}
{{--    <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>--}}
{{--    @endif--}}
{{--    </a></li>--}}
    {{-- @foreach($items as $menu_item)
        <li>
            <a href="{{ $menu_item->link() }}">
                {{ $menu_item->title }}
                @if ($menu_item->title === 'Cart')
                    @if (Cart::instance('default')->count() > 0)
                    <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>
                    @endif
                @endif
            </a>
        </li>
    @endforeach --}}
</ul>
