<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Thông tin cá nhân</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/footer.welcome.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/book_interface.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/navbar.book.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}" type="text/css">
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
    @include('book_interface.navbar')
    <div class="bootstrap snippet profile">
        <div class="profile-heading">
            <h1 class="profile-heading-text">HỒ SƠ CỦA TÔI</h1>
        </div>
        <form action="{{ route('user.profile.edit') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm-3">
                    <div class="text-center sub-profile">
                        <div class="form-upload">
                            <input class="link-img" name="images"
                                value="{{ asset(old('images', Auth::user()->images)) }}" readonly>
                            <img src="{{ asset(old('images', Auth::user()->images)) }}"
                                class="avatar img-circle img-thumbnail" alt="avatar">
                            <input type="file" class="hidden">
                            <div class="alert alert-upload">{{ $errors->first('images') }}</div>
                            <button type="button" class="btn-pro btn-upload-img btn-upload">Đăng ảnh</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="tab-content main-profile">
                        <form class="form" action="" method="post" id="registrationForm" autocomplete="off">
                            <div class="edit-profile">
                                <h3 class="edit-profile-heading section-heading">Chỉnh sửa thông tin</h3>
                                <div class="form-group">
                                    <label class="lb account">
                                        <h4>Tên Đăng Nhập</h4>
                                    </label>
                                    <input type="text" class="form-control" name="username" autocomplete="off"
                                        value="{{ Auth::user()->username }}" disabled>
                                </div>
                                <div class="alert alert-danger"></div>
                                <div class="form-group">
                                    <label class="lb name">
                                        <h4>Họ Tên</h4>
                                    </label>
                                    <input type="text" class="form-control" name="name" autocomplete="off"
                                        value="{{ old('name', Auth::user()->name) }}" maxlength="50"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>
                                <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                <div class="form-group">
                                    <label class="lb email">
                                        <h4>Email</h4>
                                    </label>
                                    <input type="text" class="form-control" name="email" autocomplete="off"
                                        value="{{ old('email', Auth::user()->email) }}" maxlength="50"
                                        data-type="email"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>
                                <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                <div class="form-group">
                                    <label class="lb phone">
                                        <h4>Số Điện Thoại</h4>
                                    </label>
                                    <input type="number" class="form-control" name="phone" autocomplete="off"
                                        value="{{ old('phone', Auth::user()->phone) }}" maxlength="11"
                                        data-type="phone"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>
                                <div class="alert alert-danger">{{ $errors->first('phone') }}</div>
                                <div class="form-group">
                                    <label class="lb address">
                                        <h4>Địa Chỉ</h4>
                                    </label>
                                    <input type="text" class="form-control" name="address" autocomplete="off"
                                        value="{{ old('address', Auth::user()->address) }}" maxlength="100"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>
                                <div class="alert alert-danger">{{ $errors->first('address') }}</div>
                                <div class="form-group">
                                    <label class="lb sex">
                                        <h4>Giới tính</h4>
                                    </label>
                                    <div class="form-group">
                                        <div class="sex-item">
                                            <input type="radio" class="sex-input" name="sex" value="1"
                                                {{ old('sex', Auth::user()->sex) == 1 ? 'checked' : '' }}> Nam
                                        </div>
                                        <div class="sex-item">
                                            <input type="radio" class="sex-input" name="sex" value="2"
                                                {{ old('sex', Auth::user()->sex) == 2 ? 'checked' : '' }}> Nữ
                                        </div>
                                        <div class="sex-item">
                                            <input type="radio" class="sex-input" name="sex" value="0"
                                                {{ old('sex', Auth::user()->sex) === 0 ? 'checked' : '' }}> Khác
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="lb birth">
                                        <h4>Ngày Sinh</h4>
                                    </label>
                                    <input type="date" class="form-control" name="birth" autocomplete="off"
                                        value="{{ old('birth', Auth::user()->birth) }}" min="1900-01-01"
                                        max="2009-12-31">
                                </div>
                                <div class="alert alert-danger">{{ $errors->first('birth') }}</div>
                            </div>
                            <div class="btn-act">
                                <a href="{{ route('user.profile.view.changepass') }}"
                                    class="change-password-heading section-heading">Đổi mật khẩu</a>
                                <button class="btn-pro" type="submit">
                                    <i class="glyphicon glyphicon-ok-sign"></i> Lưu thông tin</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @include('layouts.footer')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/admin/user.js') }}"></script>
</body>

</html>
