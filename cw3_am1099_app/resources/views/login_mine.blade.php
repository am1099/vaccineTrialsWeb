<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/css/login.css">


<!-- Bootstrap CSS & Scripts -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<head>
    <title>Login</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


</head>

<header>
    @include('layout.layouts')
</header>

<body>

    <div class="container">
        @if(session()->has('success'))
        <div class="alert alert-success text-center">
            <strong>{{ session()->get('success') }}</strong>
        </div>
        @endif
    </div> 

    <div class="container">
        @if(session()->has('danger'))
        <div class="alert alert-danger text-center">
            <strong>{{ session()->get('danger') }}</strong>
        </div>
        @endif
    </div> 
    
    @if($errors)
    <div class="container">
        <div class="alert text-center text-danger">
            @foreach($errors->all() as $V)
            <strong>{{ $V }}</strong><br>
            @endforeach
        </div>
    </div>
    @endif


<div class="container">
    <div class="login-page">
        <div class="form" style="background: #222629">
            <form class="login-form" method="post" action="{{ route('signin') }}">
                @csrf
                <div class="imgcontainer">
                    <img src="{{ URL::asset('images/icon1.png') }}" alt="Avatar" class="avatar" style="width: 150px;">
                </div>
                <br>
                <div class="form-row " id="username-group">
                    <label style="color: white;"><b>Email address: </b></label>
                    <!-- input the last admin's username -->
                    <input type="text" placeholder="Email address" value="{{ old('email') }}" class="@error('email') is-invalid @enderror" name="email" required autofocus/>
                    @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
                <div class="form-row" id="password-group">
                    <label style="color: white;"><b>Password: </b></label>
                    <input type="password" placeholder="password" name="passwordHash" id="password" required/>
                </div>

                <div class="container pt-4">
                    <button id="login" type=" submit" name="submit" class="btn btn-light form-group">Login</button>
                </div>

                <hr style="border-color: white;" noshade="noshade">
                <a type="button" id="public" href="/users/signup" class="btn btn-outline-light">Register</a>

            </form>
        </div>
    </div>
</div>

</body>

</html>