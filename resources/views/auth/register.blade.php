<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="{{ asset('css/user.register.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
</head>

<body>
    <div class="register" style="background-image: url('{{ asset('images/banner.jpg') }}');">
        <input type="hidden" name="success" value="{{ session('success') ? session('success') : '' }}">
        <div class="overlay" id="overlay"></div>
        <div id="popup" class="popup">
            <div class="container">
                <div class="content-popup">
                    <strong>Chúc mừng bạn đã đăng kí thành công. Vui lòng đăng nhập!</strong>
                </div>
                <div class="clearfix">
                    <a href="{{ route('user.login') }}" role="button" class="submitbtn">OK</a>
                </div>
            </div>
        </div>
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
            <form id="register" class="input-group" action="{{ route('user.registerPost') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group-item">
                            <input type="text" class="input-field" placeholder=" " name="name"
                                value="{{ old('name') }}" maxlength="50"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            <label class="label-field">Họ và Tên</label>
                        </div>
                        <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                        <div class="input-group-item">
                            <input type="phone" class="input-field" placeholder=" " name="username"
                                value="{{ old('username') }}" maxlength="24"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            <label class=" label-field">Tên đăng nhập</label>
                        </div>
                        <div class="alert alert-danger">{{ $errors->first('username') }}</div>
                        <div class="input-group-item">
                            <input type="password" class="input-field" placeholder=" " name="password" maxlength="24"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            <label class="label-field">Mật khẩu</label>
                        </div>
                        <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                        <div class="input-group-item">
                            <input type="password" class="input-field" placeholder=" " name="password_confirmation"
                                maxlength="24"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            <label class="label-field">Nhập lại mật khẩu</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group-item">
                            <input type="number" class="input-field" placeholder=" " name="phone"
                                value="{{ old('phone') }}" maxlength="11" data-type="phone"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            <label class=" label-field">Số điện thoại</label>
                        </div>
                        <div class="alert alert-danger">{{ $errors->first('phone') }}</div>
                        <div class="input-group-item">
                            <input type="email" class="input-field" placeholder=" " name="email"
                                value="{{ old('email') }}" maxlength="50" data-type="email"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            <label class=" label-field">Email</label>
                        </div>
                        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                        <div class="input-group-item">
                            <input type="date" class="input-field" placeholder=" " name="birth" min="1900-01-01"
                                max="2009-12-31" value="{{ old('birth') }}">
                            <label class=" label-field">Ngày sinh</label>
                        </div>
                        <div class="alert alert-danger">{{ $errors->first('birth') }}</div>
                        <div class="input-group-item">
                            <input type="text" class="input-field" placeholder=" " name="address"
                                value="{{ old('address') }}" maxlength="100"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            <label class=" label-field">Địa chỉ</label>
                        </div>
                        <div class="alert alert-danger">{{ $errors->first('address') }}</div>
                    </div>
                </div>
                <button type="submit" class="submit-btn mt-20">Đăng ký</button>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
