<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/css/index.css">
<link rel="stylesheet" href="/css/form.css">
<link rel="stylesheet" href="/css/stats.css">



<!-- Bootstrap CSS & Scripts -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- Google charts script -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<head>
    <title>Vaccine Developer Dashboard</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

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
      

        <div class="row">
            <div class="col-12 col-xs-6 col-md-6 text-center center " >
                       <div class="stats">
                          <div class="box-header">Total number of Volunteers</div>
                          <div class="box-content">
                             <div class="num">{{ count($stats) }}</div>
                            
                          </div>
                       </div>
        
                       <div class="stats">
                          <div class="box-header">Total positive cases by volunteers</div>
                            <div class="box-content">
                                <div class="num">{{ count($stats_pos) }}</div>
                            </div>
                       </div>    
            </div>
        </div>

        <hr class="solid">

        @if (count($stats_pos) >= 1)

        <div class="row">
            <div class="col-12 col-xs-6 col-md-6 text-center center">
                <div id="POS_vaccine" style="width: 80%; height: 300px;"></div>
            </div>

            <div class="col-12 col-xs-6 col-md-6 text-center center">
                <div id="vaccine_efficacy_dose" style="width: 80%; height: 300px;"></div>
            </div>
        
        </div>

        <div class="row">
            <div class="col-12 col-xs-6 col-md-6 text-center center">
                <div id="vaccine_efficacy" style="width: 90%; height: 300px;"></div>
            </div>
            
        </div>

            
        
            
        @endif

        

    </div>

</body>

{{-- Bar chart of Positive cases in the vaccinated/unvaccinated groups --}}
<script type="text/javascript">

    google.charts.load("current", {packages:["bar"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Type of vaccination", " "],
        ["SLCV2020 (Type: B / Vaccinated)", {{ count($vaccinated) }}],
        ["Unknown (Type: A) /Unvaccinated", {{ count($unvaccinated) }}]
      ]);

      var view = new google.visualization.DataView(data);
 

      var barchart_options = {
        title: "Positive cases in the vaccinated/unvaccinated groups :",
        height: 250,
        bar: {groupWidth: "50%"},
        colors: ['#1b9e77', 'rgb(9, 57, 88)'],  
        
         };

      var barchart_postcode = new google.charts.Bar(document.getElementById('POS_vaccine'));
      barchart_postcode.draw(data, google.charts.Bar.convertOptions(barchart_options));
  }

 </script>

{{-- donut chart of Estimated vaccine efficacy rate (overall, regardless of dose) --}}

<script type="text/javascript">

      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['efficacy', 'Hours per Day'],
          ['efficacy rate of SLCV2020',{{round((($unvaccinated->count() - $vaccinated->count() )/ $unvaccinated->count()) *100,2)}}],
          ['', (100 - {{round((($unvaccinated->count() - $vaccinated->count() )/ $unvaccinated->count()) *100,2)}})]
          
        ]);

        var options = {
          title: 'Estimated vaccine efficacy rate (overall, regardless of dose):',
          pieHole: 0.4,
          is3D: false,
          pieSliceTextStyle: {
            color: 'white',
          },
          slices: {
            1: { color: 'rgb(247, 244, 244)', textStyle : {color:'transparent'} }
          }
        };

        var chart = new google.visualization.PieChart(document.getElementById('vaccine_efficacy'));
        chart.draw(data, options);
      }

</script>

{{-- donut chart of Estimated vaccine efficacy rate for single and half dose --}}
<script type="text/javascript">

    google.charts.load("current", {packages:["bar"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ["Amount of dose", " "],
        ["Single dose (1.0)", {{round((($unvaccinated_fullDose->count() - $vaccinated_fullDose->count() )/ $unvaccinated_fullDose->count()) *100,2)}}+'%'],
        ["Half dose (0.5)", {{round((($unvaccinated_halfDose->count() - $vaccinated_halfDose->count() )/ $unvaccinated_halfDose->count()) *100,2)}}+'%']
      ]);

      var view = new google.visualization.DataView(data);
 

      var barchart_options = {
        title: "Estimated vaccine efficacy rate for single and half dose :",
        
        height: 250,
        bar: {groupWidth: "50%"},
        colors: ['#1b9e77', 'rgb(8, 107, 124)'],  
        
         };

      var barchart_postcode = new google.charts.Bar(document.getElementById('vaccine_efficacy_dose'));
      barchart_postcode.draw(data, google.charts.Bar.convertOptions(barchart_options));
  }

 </script>
</html>