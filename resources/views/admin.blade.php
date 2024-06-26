<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="{{ asset('css/adminsetup.css') }}">
</head>
<body>
    <form id="form-container" method="POST" action="{{ route('admin-login') }}">
        @csrf
        <h1 class="title">Login</h1>
        <div class="label">Username</div>
        <input type="text" name="username" value="{{ old('username') }}" required/>
        <div class="label">Password</div>
        <input type="password" name="password" required/>

        <div class="response">
            @isset($response)
                {!! $response !!}
            @endisset
        </div>

        <button type="submit" class="submit" id="submitBtn">Login</button>
    </form>
</body>
</html>
