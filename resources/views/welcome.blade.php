<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Book Rental App</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Assuming you're using Laravel Mix -->
</head>
<body>
    <div class="container">
        <form action="{{ route('login') }}" method="POST" class="login-form">
            @csrf
            <h2>Login</h2>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
        
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
        
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
