<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đổi mật khẩu</title>
    <link rel="stylesheet" href="{{ asset('css/user.login.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
</head>

<body>
    <div class="register" style="background-image: url('{{ asset('images/banner.jpg') }}');">
        <input type="hidden" name="success" value="{{ session('msg') ? session('msg') : '' }}">
        <div class="overlay" id="overlay"></div>
        <div id="popup" class="popup">
            <div class="container">
                <div class="content-popup">
                    <strong>{{ session('msg') }}</strong>
                </div>
                <div class="clearfix">
                    <a href="{{ route('user.login') }}" role="button" class="submitbtn">OK</a>
                </div>
            </div>
        </div>
    </div>
    <div class="login" style="background-image: url('{{ asset('images/banner.jpg') }}');">
        <div class="form-box">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn">Quên mật khẩu</button>
                <button type="button" class="toggle-btn login-btn">Đăng nhập</button>
            </div>
            <div class="social-icon">
                <img src="{{ asset('images/fb.png') }}">
                <img src="{{ asset('images/tw.png') }}">
                <img src="{{ asset('images/gp.png') }}">
            </div>
            <form id="login" class="input-group" method="POST" action="{{ route('user.forgetpass.post') }}">
                @csrf
                <div class="input-group-item">
                    <input type="phone" class="input-field" placeholder=" " name="username"
                        value="{{ old('username') }}" maxlength="24"
                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                    <label class=" label-field">Tên đăng nhập</label>
                </div>
                <div class="alert alert-danger">{{ $errors->first('username') }}</div>
                <div class="input-group-item">
                    <input type="email" class="input-field" placeholder=" " name="email" value="{{ old('email') }}"
                        maxlength="50" data-type="email"
                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                    <label class=" label-field">Email</label>
                </div>
                <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                <div class="alert alert-danger">{{ $errors->first('password_old') }}</div>
                <div class="input-group-item">
                    <input type="password" class="input-field" placeholder=" " name="password" maxlength="24"
                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                    <label class="label-field">Mật khẩu mới</label>
                </div>
                <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                <div class="input-group-item">
                    <input type="password" class="input-field" placeholder=" " name="password_confirmation"
                        maxlength="24"
                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                    <label class="label-field">Nhập lại mật khẩu</label>
                </div>
                <button type="submit" class="submit-btn">Đổi mật khẩu</button>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
