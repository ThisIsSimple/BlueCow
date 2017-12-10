<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>쓰레기통 통합 관리 시스템 : BlueCow</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    @yield('stylesheet')
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#"><b>Blue</b>Cow</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">메인</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">쓰레기통 관리</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">쓰레기통 추가</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">통계</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">설정</a>
                </li>
            </ul>
        </div>

        {{--<div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
            {{--<ul class="nav nav-pills">--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link active" href="#">Home</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" href="#">Trash</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" href="#">Elevator</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link disabled" href="#">Contact</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</div>--}}
    </div>
</nav>

<div class="container-fluid py-5">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js " integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh " crossorigin="anonymous "></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js " integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ " crossorigin="anonymous "></script>

<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?clientId=EY4l8Gflyudbw26AcaD2&submodules=geocoder"></script>
@yield('script')
</body>

</html>