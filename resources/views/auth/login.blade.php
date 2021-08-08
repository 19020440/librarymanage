<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="{{ asset('css/user.login.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
</head>

<body>
    <div class="login" style="background-image: url('{{ asset('images/banner.jpg') }}');">
        <div class="form-box">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn login-btn">Đăng nhập</button>
                <button type="button" class="toggle-btn register-btn">Đăng ký</button>
            </div>
            <div class="social-icon">
                <img src="{{ asset('images/fb.png') }}">
                <img src="{{ asset('images/tw.png') }}">
                <img src="{{ asset('images/gp.png') }}">
            </div>
            <form id="login" class="input-group" method="POST" action="{{ route('user.loginPost') }}">
                @csrf
                <div class="input-group-item">
                    <input type="text" class="input-field" placeholder=" " name="username">
                    <label class="label-field">Tên đăng nhập</label>
                </div>
                <div class="input-group-item">
                    <input type="password" class="input-field" placeholder=" " name="password">
                    <label class="label-field">Mật khẩu</label>
                </div>
                @if (session('not_success'))
                    <div class="alert alert-danger">*Thông tin đăng nhập không chính xác.</div>
                @endif
                <div class="input-group-item">
                    <a href="{{ route('user.forgetpass') }}" class="forget-pass">Quên mật khẩu ?</a>
                </div>
                <div class="input-group-item">
                    <a href="{{ route('home') }}" class="forget-pass">Về trang chủ</a>
                </div>
                <button type="submit" class="submit-btn">Đăng nhập</button>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
