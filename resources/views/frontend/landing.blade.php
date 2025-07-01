<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Simple Landing Page</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      padding: 50px;
    }
    a {
      display: inline-block;
      margin: 10px;
      text-decoration: none;
      color: white;
      background-color: #007BFF;
      padding: 10px 20px;
      border-radius: 5px;
    }
    a:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <h1>Welcome to Our App</h1>
  {{-- @dd(auth()->user()) --}}
  @if (auth()->user())
    <p>Hellow: {{auth()->user()->name}}</p>

    <form action="{{route('logout')}}" method="POST">
      @csrf
      <button type="submit">Logout</button>
    </form>
     {{-- <a href="{{route('logout')}}">Logout</a> --}}
  @else

    <p>Please choose an option below:</p>
    <a href="{{url('landing-login')}}">Login</a>
    <a href="{{url('landing-register')}}">Register</a>
    <a href="{{url('landing-forgot-password')}}">Forgot Password</a>
  @endif
  
</body>
</html>
