<?php

    $weather="";
    $error="";
    
    
    if(array_key_exists('city', $_GET)) {
        
        $city = str_replace(' ','', $_GET['city']);
        
        $file_headers = @get_headers("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        
        if($file_headers[0] == 'HTTP/1.1 404 Not Found'){
            $error = "That city could not be found!";
            
        } else{
        
        $forecastPage = file_get_contents("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        
        $pageArray = explode('<div class="b-forecast__overflow"><div class="b-forecast__wrapper b-forecast__wrapper--js"><table class="b-forecast__table js-forecast-table"><thead><tr class="b-forecast__table-description b-forecast__hide-for-small days-summaries"><th></th><td class="b-forecast__table-description-cell--js" colspan="9"><span class="b-forecast__table-description-title"><h2>', $forecastPage);
        
        if(sizeof ($pageArray) > 1){
            $secondPageArray = explode('</span></p></td><td class="b-forecast__table-description-cell--js" colspan="9"><span class="b-forecast__table-description-title">', $pageArray[1]);
            
            if( sizeof(($secondPageArray) > 1)){
            
                $weather = $secondPageArray[0];
                
            }else{
                $error = "That city could not be found!";   
            }
        } else {
            $error = "That city could not be found!";
        }
        
        
        }
        
    }

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Weather Forecast</title>
      
      <style type="text/css">
        html { 
              background: url(weather_background.jpg) no-repeat center center fixed; 
              -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;
}
          body{
              background: none;
          }
          .container{
              text-align: center;
              margin: 200px;
              width: 500px;
              color: cornsilk;
              
          }
          
          input{
              margin: 20px;
          }
          label{
              font-size: 25px;
          }
      
      </style>
  </head>
  <body>
      <div class="container">
        <h1>Whats The Weather?</h1>
        
            <form>
          
            <fieldset class="form-group">
                
                <label for="inputText"> Enter the name of the city </label>
                
                <input type="text" class="form-control" id="city" name="city" placeholder="Eg. Mumbai" value = "<?php echo $_GET['city']; ?> "> 
 
                <button type="submit" class="btn btn-primary">Submit</button>
                
                
                </fieldset>
          
          </form>
      
           <div id = "weather" >
               <?php 
               
               if($weather) {
                   echo '<div class="alert alert-success" role="alert">'.$weather.'</div>';
               } else {
                   echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
               }
        ?>
      </div>

      </div>
      
     
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>