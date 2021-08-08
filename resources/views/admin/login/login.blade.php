<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="{{ asset('css/admin.login.css') }}" type="text/css">

</head>

<body>

    <div class="wrapper fadeInDown">
        <div id="formContent">
            <div class="fadeIn first">
                <img src="{{ asset('images/admin-login.png') }}" id="icon" alt="User Icon" />
            </div>
            <form action="{{ route('admin.loginPost') }}" method="POST">
                @csrf
                <input type="text" id="login" class="fadeIn second" name="admin" placeholder="admin"
                    value="{{ old('admin') }}" required>
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="password"
                    required>
                <div class="alert alert-danger fadeIn third">{{ session('msg') }}</div>
                <input type="submit" class="fadeIn fourth" value="Log In">
            </form>
        </div>
    </div>
</body>

</html>
