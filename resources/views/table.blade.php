
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>Laravel</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
            <!-- Fonts -->
            <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

            <!-- Styles -->
            <style>
                #customers {
                  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                  border-collapse: collapse;
                  width: 100%;
                }

                #customers td, #customers th {
                  border: 1px solid #ddd;
                  padding: 8px;
                }
                .container{

                    height: 100vh;
                }

                #customers tr:nth-child(even){background-color: #f2f2f2;}

                #customers tr:hover {background-color: #ddd;}

                #customers th {
                  padding-top: 12px;
                  padding-bottom: 12px;
                  text-align: left;
                  background-color: #4CAF50;
                  color: white;
                }
                </style>

        </head>

        <div class="container">
            <h3>with Laravel</h3>
            <table id="customers" >

            <tr>
              <th rowspan="2">Projects:</th>
              <th rowspan="2">total Anomalie:</th>
              <th colspan="2">bugs</th>
              <th colspan="2">Amélioration</th>

            <tr>
              <td>en cours</td>
              <td>Résolu</td>
              <td>en cours</td>
              <td>Résolu</td>
            </tr>

           </tr>


           @foreach ($projects as $item)
           <tr>
            <td rowspan="2">{{str_replace('CLI', ' ', $item->name)}}</td>
              <td rowspan="2">{{$item->total_anomalie}}</td>
              <tr>
              <td>{{$item->beug_encour}}</td>
              <td>{{$item->beug_resolu}}</td>
              <td>{{$item->amelioration_encour}}</td>
              <td>{{$item->amelioration_resolu}}</td>
              </tr>
           </tr>
           @endforeach

           </table>
        </div>






    </html>

