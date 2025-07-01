<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
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
  <h2>Register</h2>
  <form action="{{ route('register') }}" method="post">
    @csrf
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" >
    <input type="phone" name="phone" placeholder="phone" >
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
  </form>
  <a href="{{ url('/landing') }}">Back to Home</a>
</body>
</html>
