<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>
        @yield('title')
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href=" {{ asset('shopassets/vendor/fontawesome/css/all.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
</head>

<body>
    <div id="app" class="apphide">
        @include('shop.layout.mobilemenu')
        <div class="site">
            <div class="site__container">
                @include('shop.layout.header')
                <div class="site__body">
                    @yield('page')
                </div>
                @include('shop.layout.footer')
            </div>
        </div>
    </div>
    
    <script src="{{ asset('js/shop.js') }}"></script>
    <script src=" {{ asset('shopassets/vendor/nouislider/nouislider.min.js') }} "></script>

    @yield('script')
        
</body>

</html>