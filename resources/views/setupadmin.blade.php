<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Setup</title>
    <link rel="stylesheet" href="{{ asset('css/adminsetup.css') }}">
    <script>
        function setCookie(name, value, seconds) {
            var expires = "";
            if (seconds) {
                var date = new Date();
                date.setTime(date.getTime() + (seconds * 1000)); // Convert seconds to milliseconds
                expires = "; expires=" + date.toUTCString();
            }
            var cookieString = name + "=" + (value || "") + expires + "; path=/; SameSite=None; Secure";
            document.cookie = cookieString;
        }

        function continueFunction() {
            window.location.href = window.location.origin + "/admin";
        }
    </script>
</head>
<body>
    <form id="form-container" method="POST" action="{{ route('setup-admin') }}">
        @csrf
        <h1 class="title">Admin</h1>
        <div class="label">Username</div>
        <input type="text" name="username" value="{{ old('username') }}" required/>
        <div class="label">Password</div>
        <input type="password" name="password" required/>
        <div class="label">Confirm Password</div>
        <input type="password" name="confirm_password" required/>

        <div class="response">
            @isset($response)
                {!! $response !!}
            @endisset
        </div>

        <button type="submit" class="submit" id="submitBtn" onClick="setCookie('last_page', 'setup-admin', 30);">Set Up</button>
    </form>

    <script>
        @isset($response)
            @if(strpos($response, 'Admin setup successful') !== false)
                document.querySelectorAll('input').forEach(function(input) {
                    input.disabled = true;
                    input.removeAttribute('required');
                });
                document.body.innerHTML = `
                    <div id="form-container">
                        <h1 class="title">Admin</h1>
                        @isset($response)
                            <label class="label">{!! $response !!}</label>
                        @endisset
                        <button type="submit" class="submit" id="submitBtn" onClick="continueFunction()">Continue</button>
                    </div>
                `;
            @endif
        @endisset
    </script>
</body>
</html>
