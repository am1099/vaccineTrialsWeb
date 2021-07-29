<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/css/index.css">
<link rel="stylesheet" href="/css/form.css">



<!-- Bootstrap CSS & Scripts -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<head>
    <title>Sign up</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

</head>

<header>
    @include('layout.layouts')
    <!-- @yield('header') -->
</header>

<body>

    <h3 class="text-center pt-2">Please enter your details below</h3> 
        
    {{-- @else
    <h3 class="text-center pt-2">Please enter your details and test reuslt below</h3> --}}
        


    <hr class="solid " style="width: 60%;">
    <div class="container mt-4">
        <form style="text-align: center;" method="post" action="{{ route('createvolunteer') }}">
            @csrf

            <div class="card-header border-info " style="background-color: #677077"><b style="color: white"> SARS-CoV-3 Volunteer details:</b></div>
            <div class="card-body">

                <!-- LINE 1 -->
                <div class="form-row">

                    <div class="col-sm-2 pt-1">
                        <label style="text-align: center;" for="Email"> Email <b style="color: red;">*</b>: </label>
                    </div>
                    <div class="col-sm-4" id="email-group">
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email..." name="email" value="{{ old('email') }}" required autofocus>

                        {{-- ERROR VALIDATION MESSAGE --}}
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                         @enderror
                    </div>

                    <div class="col-sm-2 pt-2">
                        <label style="text-align: center;" for="passwordHash">Password <b style="color: red;">*</b>:</label>
                    </div>
                    <div class="col-sm-4" id="password-group">
                        <input value="{{ old('passwordHash') }}" id="passwordHash" name="passwordHash" type="password" class="form-control @error('passwordHash') is-invalid @enderror" placeholder="Enter a password..." required>
                        
                        {{-- ERROR VALIDATION MESSAGE --}}
                        @error('passwordHash')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                         @enderror
                    </div>
                </div>


                <!-- LINE 2 -->

                <div class="form-row">

                    <div class="col-sm-2 pt-3">
                        <label style="text-align: center;" for="Fullname">Full name <b style="color: red;">*</b>:</label>
                    </div>
                    <div class="col-sm-4 pt-2" id="fullname-group">
                        <input id="fullname" class="form-control @error('fullname') is-invalid @enderror" value="{{ old('fullname') }}" name="fullname" placeholder="Enter your full name..." >
                        {{-- ERROR VALIDATION MESSAGE --}}
                        @error('fullname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                         @enderror
                    </div>

                    <div class="col-sm-2 pt-3 pb-1">
                        <label for="Gender">Gender <b style="color: red;">*</b>:</label>
                    </div>
                    <div class="col-sm-4 pt-2" id="gender-group">
                        <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender" >
                            <option value="" selected>Select your gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="Other">Other</option>
                        </select>

                        {{-- ERROR VALIDATION MESSAGE --}}
                        @error('gender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                         @enderror
                    </div>
                </div>
                <!-- LINE 3 -->


                <div class="form-row">
                    <div class="col-sm-2 pt-3">
                        <label style="text-align: center;" for="Age">Age <b style="color: red;" >*</b>:</label>
                    </div>

                    <div class="col-sm-4 pt-2 text-left" id="address-group">
                        <input class="form-control @error('age') is-invalid @enderror " value="{{ old('age') }}" type="number" id="age" name="age" min="1" max="150" >

                        {{-- ERROR VALIDATION MESSAGE --}}
                        @error('age')
                            <span class="invalid-feedback text-center" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                         @enderror
                    </div>

                    <div class="col-sm-2 pt-3 pb-1">
                        <label style="text-align: center;" for="Address">Address <b style="color: red;">*</b>:</label>
                    </div>

                    <div class="col-sm-4 pt-2" id="postcode-group">
                        <input id="address" value="{{ old('address') }}" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Enter your street name and street number">

                        {{-- ERROR VALIDATION MESSAGE --}}
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                         @enderror
                    </div>
                </div>

                <!-- LINE 4 -->

                <div class="form-row">
                    <div class="col-sm-2 pt-3 pb-1">
                        <label style="text-align: center;" for="health_condition">Health conditions :</label>
                    </div>

                    <div class="col-sm-4 pt-2" id="health_condition-group">
                        <textarea rows="3" id="health_condition" class="form-control " name="health_condition" placeholder="Enter any health conditions"> {{ old('health_condition') }}</textarea>

                    </div>


                </div>

                <div class="row">

                    <div class="container text-left pt-4 pl-4 pb-2 pr-4">
                        <a class="btn btn-info" type="button" href="/login">Back</a>
                        <button class="btn btn-info" type="reset">Reset</button>

                        <button type="submit" name="submit" class="btn btn-success form-group" style="float: right">Submit</button>

                    </div>
                </div>
        </form>
        
    </div>

</body>

</html>