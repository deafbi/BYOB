<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install BYOB</title>
    <link rel="stylesheet" href="{{ asset('css/install.css') }}">
    <script src="https://kit.fontawesome.com/4ccfd0940c.js" crossorigin="anonymous"></script>
    <script>
        // JavaScript function to handle form submission and redirect
        function submitForm() {
            window.location.href = "/setup/db"
        }
    </script>
</head>
<body>
    <div id="form-container" method="POST" action="../mods/redirect_script.php">
        <h1 class="title">SETUP</h1>
        <div class="info">
            <i class="fas fa-sliders-h fa-3x"></i>
            <div class="label">Let BYOB make your bio site experience amazing and have a easy setup within minutes!</div>
        </div>
        
        <input type="button" class="submit" value="Setup" onclick="submitForm()" />
    </div>
</body>
</html>