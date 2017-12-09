@extends('layout')

@section('content')
    <div class="row">
        <div class="col-12 col-md-3">
            <div class="card">
                <div class="card-header">
                    Featured
                </div>
                <div class="card-body">
                    <div class="list-group ">
                        <a href="# " class="list-group-item list-group-item-action active ">
                            Cras justo odio
                        </a>
                        <a href="# " class="list-group-item list-group-item-action ">Dapibus ac facilisis in</a>
                        <a href="# " class="list-group-item list-group-item-action ">Morbi leo risus</a>
                        <a href="# " class="list-group-item list-group-item-action ">Porta ac consectetur ac</a>
                        <a href="# " class="list-group-item list-group-item-action disabled ">Vestibulum at eros</a>
                    </div>
                </div>
                <div class="card-footer text-muted ">
                    <a href="# ">Logout</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 ">
            <div class="card ">
                <div id="map" style="width:100%;height:400px;"></div>
            </div>
        </div>
        <div class="col-12 col-md-3 ">
            <div class="card ">
                <div class="card-header">
                    asd
                </div>
                <div class="card-body">
                    asdf
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/map.js') }}"></script>
    <script>
        var infowindow = new naver.maps.InfoWindow();

        var initLatitude = 37.5666805;
        var initLongitude = 126.9784147;

        var cookieLatitude = Cookies.get('latitude');
        var cookieLongitude = Cookies.get('longitude');

        if(cookieLatitude != null && cookieLongitude != null) {
            initLatitude = cookieLatitude;
            initLongitude = cookieLongitude;


        }

        var map = new naver.maps.Map('map', {
            center: new naver.maps.LatLng(initLatitude, initLongitude),
            zoom: 10,
            mapTypeId: naver.maps.MapTypeId.NORMAL
        });

        function onSuccessGeolocation(position) {
            var location = new naver.maps.LatLng(position.coords.latitude,
                position.coords.longitude);
            var marker = new naver.maps.Marker({
                map: map,
                position: location
            });

            map.setCenter(location); // 얻은 좌표를 지도의 중심으로 설정합니다.
            map.setZoom(10); // 지도의 줌 레벨을 변경합니다.

            infowindow.setContent('<div style="padding:20px;">' +
                'latitude: ' + location.lat() + '<br />' +
                'longitude: ' + location.lng() + '</div>');

            infowindow.open(map, location);
        }

        function onErrorGeolocation() {
            var center = map.getCenter();

            infowindow.setContent('<div style="padding:20px;">' +
                '<h5 style="margin-bottom:5px;color:#f00;">Geolocation failed!</h5>' + "latitude: " + center.lat() + "<br />longitude: " + center.lng() + '</div>');

            infowindow.open(map, center);
        }

        $(window).on("load", function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(onSuccessGeolocation, onErrorGeolocation);
            } else {
                var center = map.getCenter();

                infowindow.setContent('<div style="padding:20px;"><h5 style="margin-bottom:5px;color:#f00;">Geolocation not supported</h5>' + "latitude: " + center.lat() + "<br />longitude: " + center.lng() + '</div>');
                infowindow.open(map, center);
            }
        });
    </script>
@endsection