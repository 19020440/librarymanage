<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/contact.welcome.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/footer.welcome.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slider.welcome.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/navbar.welcome.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/content.welcome.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/load.css') }}" type="text/css">
</head>

<body>
    <input type="hidden" name="success" value="{{ session('msg') ? 1 : '' }}">
    <div class="overlay" id="overlay"></div>
    <div id="popup" class="popup">
        <div class="container">
            <div class="content-popup">
                <strong>{{ session('msg') }}</strong>
            </div>
            <div class="clearfix">
                <a role="button" class="submitbtn">OK</a>
            </div>
        </div>
    </div>
    <div class="main-section">
        @include('layouts.navbar')
        <div id="home" class="section sec-act"></div>
        @include('layouts.slider')
        @include('layouts.content')
        @include('layouts.contact')
        @include('layouts.footer')
        @include('book_interface.cart')
        <a class="toTop smooth" href="#home">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="toTop-icon bi bi-arrow-up" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
            </svg>
        </a>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/admin/welcome.js') }}"></script>
</body>

</html>
