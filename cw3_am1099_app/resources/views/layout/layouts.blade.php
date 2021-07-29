<html>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS & Scripts -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="/css/index.css">

<nav class="navbar navbar-expand-md navbar-dark  bd-navbar" style="background-color: #222629">
    <h1 class="col  text-center center" id="title" >SARS-CoV-3 Hub</h1>

    <div class="navbar-nav-scroll">
        <ul class="navbar-nav bd-navbar-nav flex-row">

         @if ((Request::is('login')))
           
            <li class="nav-item active">
               <a class="nav-link" href="/users/signup">Register</a>
            </li>
         @elseif ((Request::is('users/signup')))
            <li class="nav-item active">
               <a class="nav-link" href="/login">Login </a>
            </li>
         @endif

        </ul>
     </div>
</nav>

</html>