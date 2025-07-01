<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 50px;
      max-width: 400px;
      margin: auto;
    }
    input, button {
      display: block;
      width: 100%;
      margin: 10px 0;
      padding: 10px;
    }
    a {
      text-decoration: none;
      color: #007BFF;
    }
  </style>
</head>
<body>
  <h2>Login</h2>
  <form action="{{ route('login') }}" method="post">
    @csrf
    <input type="text" name="email_or_phone" placeholder="Email Or Phone" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
  <a href="{{ url('/landing-forgot-password') }}">Forgot Password?</a>
  <br><br>
  <a href="{{ url('/landing') }}">Back to Home</a>
</body>
</html>
