<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <title>Web Scrapping</title>
</head>

<body>
    <div class="loader_bg">
        <div class="loader"></div>
    </div>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="#">Web Scraping with PHP Curl</a>
                <div class="nav-collapse">
                    <ul class="nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
    </div><br><br>
    <div class="container-fluid">
        <!-- Main hero unit for a primary marketing message or call to action -->
        <div class="hero-unit"><br>
            <h1>Now, Its time to Web Scrap!</h1><br>
            <p>Just Click on the Button for Get the Complete Data of <a href="https://news.ycombinator.com/"
                    target="_blank">https://news.ycombinator.com/</a></p>
            <p><a href="{{ url('/load-data')}}" class="btn btn-primary btn-large">Load Data</a>
                <a href="{{ url('/refresh-data')}}" class="btn btn-danger btn-large">Refresh Data</a>
            </p>
        </div>
        <!-- Example row of columns -->
        <div class="row">
            <div class="container-fluid">
                <h2 class="">Data Get from Web Scrap</h2><br>
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>UserName</th>
                            <th>URL</th>
                            <th>Points</th>
                            <th>Comments</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($scraped))
                        @foreach ($scraped as $item)
                        <tr>
                            <td>{{$item->title}}</td>
                            <td>{{$item->username}}</td>
                            <td>{{$item->url}}</td>
                            <td>{{$item->points}}</td>
                            <td>{{$item->comments}}</td>
                            <td> <a href="{{ url('/delete', $item->id) }}" class="btn btn-danger btn-sm">Delete</a></td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $scraped->links() }}
            </div>
        </div>
        <hr>
    </div> <!-- /container -->
    <script src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js')}}"></script>
    <script>
        setTimeout(function(){
            $('.loader_bg').fadeToggle();
        }, 1500);
    </script>
    <script src="{{asset('https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>

</html>