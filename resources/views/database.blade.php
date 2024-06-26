<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database BYOB</title>
    <link rel="stylesheet" href="{{ asset('css/database.css') }}">
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
            setCookie('last_page', 'test-database', 30);
            window.location.href = window.location.origin + "/setup/admin"
        }
    </script>
</head>
<body>
    <form id="form-container" method="POST" action="{{ route('test-database') }}">
        @csrf
        <h1 class="title">Database</h1>
        <div class="label">Database Name</div>
        <input type="text" name="db_name" required/>
        <div class="label">Database Username</div>
        <input type="text" name="db_username" required/>
        <div class="label">Database Password</div>
        <input type="password" name="db_password" required/>
        @isset($response)
            <label class="label">{!! $response !!}</label>
        @endisset
        <button type="submit" class="submit" id="submitBtn" onClick="setCookie('last_page', '/setup/db', 30);">Connect DB</button>
    </form>

    <script>
        // Check if the response exists and contains success message
        @isset($response)
            @if(strpos($response, 'Connection successful') !== false)
                document.querySelectorAll('input').forEach(function(input) {
                    input.disabled = true;
                    input.removeAttribute('required');
                });
                document.body.innerHTML = `
                    <div id="form-container">
                        <h1 class="title">Database</h1>
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
