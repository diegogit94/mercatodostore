<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Mercatodo</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat%7CRoboto:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    </head>
    <body>
        <div id="app">
            <header class="with-background">
                <div class="top-nav container">
                    <div class="top-nav-left">
                        <div class="logo"><img src="/img/store-logo.png" alt="store logo" width="80mx" height="80mx"></div>
{{--                        {{ menu('main', 'partials.menus.main') }}--}}
                    </div>
                    <div class="top-nav-right">
                        @include('partials.menus.main-right')
                    </div>
                </div> <!-- end top-nav -->
                <div class="hero container">
                    <div class="hero-copy">
                        <h1>MercaTodo</h1>
                        <p>Videogames</p>
                        <div class="hero-buttons">
                            <a href="https://www.youtube.com/playlist?list=PLEhEHUEU3x5oPTli631ZX9cxl6cU_sDaR" class="button button-white">Screencasts</a>
                            <a href="https://github.com/drehimself/laravel-ecommerce-example" class="button button-white">GitHub</a>
                        </div>
                    </div> <!-- end hero-copy -->

                    <div class="hero-image">
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="/img/carousel-1.jpeg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="/img/carousel-2.jpeg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="/img/carousel-3.jpeg" class="d-block w-100" alt="...">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    </div> <!-- end hero-image -->
                </div> <!-- end hero -->
            </header>

            <div class="featured-section">

                <div class="container">
                    <h1 class="text-center">Mercatodo</h1>

                    <p class="section-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore vitae nisi, consequuntur illum dolores cumque pariatur quis provident deleniti nesciunt officia est reprehenderit sunt aliquid possimus temporibus enim eum hic lorem.</p>

                    <div class="text-center button-container">
                        <a href="#" class="button">Featured</a>
                        <a href="#" class="button">On Sale</a>
                    </div>

{{--                     <div class="tabs">--}}
{{--                        <div class="tab">--}}
{{--                            Featured--}}
{{--                        </div>--}}
{{--                        <div class="tab">--}}
{{--                            On Sale--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="products text-center">
                        @if($products)
                        @foreach ($products as $product)
                            <div class="product">
                                <a href="{{ route('store.show', $product->slug) }}"><img src="{{ $product->image }}" alt="product" class="product-section-image"></a>
                                <a href="{{ route('store.show', $product->slug) }}"><div class="product-name">{{ $product->name }}</div></a>
                                <div class="product-price">{{ formatPrice($product->price) }}</div>
                            </div>
                        @endforeach
                        @else
                            <h3>No hay productos disponibles</h3>
                        @endif
                    </div> <!-- end products -->

                    <div class="text-center button-container">
                        <a href="{{ route('store.index') }}" class="button">Ver mas productos</a>
                    </div>

                </div> <!-- end container -->

            </div> <!-- end featured-section -->

            <blog-posts>
                <div class="blog-section">
                    <div class="container">
                        <h1 class="text-center">From Our Blog</h1>

                        <p class="section-description text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et sed accusantium maxime dolore cum provident itaque ea, a architecto alias quod reiciendis ex ullam id, soluta deleniti eaque neque perferendis.</p>

                        <div class="blog-posts">
                            <div class="blog-post" id="blog1">
                                <a href="#"><img src="img/carousel-1.jpeg" alt="blog image"></a>
                                <a href="#"><h2 class="blog-title">Blog Post Title 1</h2></a>
                                <div class="blog-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est ullam, ipsa quasi?</div>
                            </div>
                            <div class="blog-post" id="blog2">
                                <a href="#"><img src="img/carousel-2.jpeg" alt="blog image"></a>
                                <a href="#"><h2 class="blog-title">Blog Post Title 2</h2></a>
                                <div class="blog-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est ullam, ipsa quasi?</div>
                            </div>
                            <div class="blog-post" id="blog3">
                                <a href="#"><img src="img/carousel-3.jpeg" alt="blog image"></a>
                                <a href="#"><h2 class="blog-title">Blog Post Title 3</h2></a>
                                <div class="blog-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est ullam, ipsa quasi?</div>
                            </div>
                        </div> <!-- end blog-posts -->
                    </div> <!-- end container -->
                </div> <!-- end blog-section -->
            </blog-posts>

            @include('partials.footer')

        </div> <!-- end #app -->
        <script src="js/app.js"></script>
    </body>
</html>
