<!DOCTYPE html>
<html>
<head>
    <title>Reservation</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }

        .badge-active-seat{
            background-color: darkgreen;
        }
        .badge{
            width: 28px;
        }
    </style>
</head>
<body onload="reservationBooking(0)">
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                Laravel
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/home') }}">Home</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<div style="padding-top: 15px;" class="text-center">
    <div id="row1"></div>
    <div id="row2"></div>
    <div id="row3"></div>
    <div id="row4"></div>
    <div id="row5"></div>
    <div id="row6"></div>
    <div id="row7"></div>
    <div id="row8"></div>
    <div id="row9"></div>
    <div id="row10"></div>
    <div id="row11"></div>
    <div id="row12"></div>
</div>
    <form method="get" onsubmit="return reservationBooking($('#seatsNo').val());" style="max-width: 500px; padding-top:15px; margin: 0 auto;">
        <div class="form-group col-sm-12"  >
            <input id="seatsNo" name="seatsNo" type="number" min="1" max="7" class="form-control" required>
        </div>

        <div class="form-group col-sm-12">
            <button type="submit" class="btn btn-primary pull-right" >Reservation</button>
            <button type="reset" onclick="return resetBooking();" class="btn btn-primary pull-right"style="margin-right: 5px" >Reset</button>
        </div>

    </form>
    <script>
        function reservationBooking(seat) {
            $.ajax({
                type:'get',
                url:'reservation/save?seatsNo='+seat,
                success: function (data) {
                    if(typeof data == "string"){
                        alert (data);
                        return;
                    }
                    drawSeats(data);
                }
            });
            return false;
        }
        function drawSeats(data){
            var num=1;
            for (var i = 0; i <= 11; i++ ){
                var limit=(i==11) ? 3 : 7;
                var $row=$('#row'+(i+1));
                $row.empty();
                for(var j=0;j<limit;j++) {
                    var classname= data ? (data[i][j] ? "badge badge-active-seat" : "badge") : "badge";
                    $('<span>', {"class": classname}).html(num).appendTo($row);
                    num++;
                }
            }
        }
        function resetBooking() {
            $.ajax({
                type:'get',
                url:'reservation/reset',
                success: function (data) {
                    if(data == "success") {
                        drawSeats();
                    }
                }
            });
            return false;
        }
    </script>
</body>
</html>

