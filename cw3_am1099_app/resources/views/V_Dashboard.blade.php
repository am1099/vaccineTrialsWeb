<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/css/index.css">
<link rel="stylesheet" href="/css/form.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<!-- Bootstrap CSS & Scripts -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert2@7.1.3/dist/sweetalert2.all.js"></script>
<head>
    <title>Volunteer Dashboard</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <meta name="csrf_token" value="{{ csrf_token() }}">

</head>



<header>
    @include('layout.loggedin')
</header>

<body>

    <div class="container">
        <br>

        <div class="container">
            @if(session()->has('success'))
            <div class="alert alert-success text-center">
                <strong>{{ session()->get('success') }}</strong>
            </div>
            @endif
        </div> 

        {{-- If number of positive casses excced 10 then end trial and only display the volunteers information --}}
        @if (count($pos_numbers) >= 10)

        <h3 class="center">TRIAL HAS ENDED!</h3>

        <div class="row">
            <div class="col text-center center">
                <ul class=" center" style=" list-style-type: none;">
                <li> <b>Full name: </b>{{ $volunteers->fullname }}</li> 
                <li> <b>Age: </b>{{ $volunteers->age }}</li>

                   
                <li id="vaccine"> <b>Vaccine Type: </b>{{ $vaccineType[0]->type }}</li> 
                <li id="vaccine"> <b>Vaccine Name: </b>{{ $vaccineType[0]->name}}</li> 
                <li id="dose"> <b>Dose: </b>{{ $volunteers->dose }}</li>
            </ul>
            </div>
        </div>
 
        @else

        <div class="container">
            @if(session()->has('report'))
            <div class="alert alert-success text-center">
                <strong>{{ session()->get('report') }}</strong>
            </div>
            @endif
        </div> 

      
        <div class="row">
            <div class="col-xs-6 col-md-3 text-center center" >
                <button type="submit" name="webcam" class="btn btn-info text-center" onclick="scanQR()" style=" font-size:24px; width: 100%; height: 80px">Scan QRCode</button>
            </div>
        </div>
        
        <div class="row">
            <div class="col text-center center">
                <ul class=" center" style=" list-style-type: none;">
                <li> <b>Full name: </b>{{ $volunteers->fullname }}</li> 
                <li> <b>Age: </b>{{ $volunteers->age }}</li>
                        
                <li id="vaccine"> <b>Vaccine Group: </b>{{ $volunteers->vaccineGroup }}</li> 
                <li id="dose"> <b>Dose: </b>{{ $volunteers->dose }}</li>
            </ul>
            </div>
        </div>

        {{-- If user already reported positive then hide reportPositive button --}}
        @if ($volunteers->infected == 'yes')
            
        <label> <b>You have been reported Positive for SLCV2020 </b></label> 
            
        @else
            
        <div class="row"> 
            <div class="col-xs-6 col-md-3 text-center center" >
                <form id="reportForm" style="text-align: center;" method="post" action="{{ route('reportPositive', $volunteers->email)  }}">
                    @csrf
                    <button  id="reportPos" type="submit" name="submit" class="btn btn-danger text-center" style=" font-size:24px; width: 100%; height: 80px">Report Positive</button>
                </form>
            </div>
        </div>

        @endif

        <div class="row">
            <div class="col-xs-6 col-md-3 center">
                <video id="preview" width="400" height="300" style="margin-right:20px"></video>
            </div>
        </div>
  
        @endif
            
    </div>
</body>


<script type="text/javascript">
    function scanQR(){ 
          let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
          scanner.addListener('scan', function (content) {
            var qr_data = content;
            obj = JSON.parse(qr_data);
            vaccine = obj.vaccine;
            dose = obj.dose

            if (qr_data != ''){
                $.ajax({
                    url:'{{ route('storeValue', $volunteers->email) }}',
                    type: 'post',

                    data: { _token: '{{csrf_token()}}',
                            vaccine, dose },
                    success: function(response) {
                        scanner.stop()
                        document.getElementById("preview").remove();
                        swal("QR Code scanned", "details of your vaccine type have successfully been stored!  Vaccine type: " + vaccine + " dose: " + dose, "success");
                        document.getElementById("vaccine").innerHTML = "<li><b>Vaccine Type: </b>" + vaccine + "</li>"
                        document.getElementById("dose").innerHTML = "<li><b>Dose: </b>" + dose + "</li>"
                    }
                    }
                );
            }
          });
          Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
             scanner.start(cameras[0]);
            } else {
             console.error('No cameras found.');
            }
          }).catch(function (e) {
            console.error(e);
          });
    }
</script>

<script type="text/javascript">
    $('#reportPos').on('click', (event) => {
        console.log("before");
        event.preventDefault();
        console.log("before2");
        var $this = $(this);
        swal({

            title: 'Confirm',
            text: 'Are you sure you have been tested positive',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, report positive',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.value) {
                $("#reportPos").unbind('click').click();
                console.log("submitted");
    }
        });
              
    });
    
</script>
</html>