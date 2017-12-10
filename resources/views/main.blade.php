@extends('layout')

@section('content')
    <div class="row">
        @include('listgroup')
        <div class="col-12 col-md-6 ">
            <div class="alert alert-warning" role="alert">
                <span id="sido"></span> <span id="sigugun"></span> <span id="dongmyun"></span>에서 {{ $trashcanNear }}개의 쓰레기통을 찾았습니다.
            </div>
            <div class="form-group">
                <input type="text" id="search" name="search" style="border: none;" class="form-control"
                       placeholder="집 주변 쓰레기통을 찾아 보세요!">
            </div>
            <div class="card mb-3">
                <div id="map" style="width:100%;height:400px;"></div>
            </div>
        </div>
        <div class="col-12 col-md-3 ">
            <div id="tarshcan-info" class="card ">
                <div class="card-header">
                    <h3></h3>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/map.js') }}"></script>
    <script>
        var map = new naver.maps.Map("map", {
            center: new naver.maps.LatLng(37.3595316, 127.1052133),
            zoom: 10,
            mapTypeControl: true
        });

        var trashcans = [];

        var infowindow = new naver.maps.InfoWindow();

        var initLatitude = 37.5666805;
        var initLongitude = 121.9784147;

        var cookieLatitude = Cookies.get('latitude');
        var cookieLongitude = Cookies.get('longitude');

        if (cookieLatitude != null && cookieLongitude != null) {
            initLatitude = cookieLatitude;
            initLongitude = cookieLongitude;
        }

        map = new naver.maps.Map('map', {
            center: new naver.maps.LatLng(initLatitude, initLongitude),
            zoom: 10,
            mapTypeId: naver.maps.MapTypeId.NORMAL
        });

        function onSuccessGeolocation(position) {
            var location = new naver.maps.LatLng(position.coords.latitude,
                position.coords.longitude);
            map.setCenter(location); // 얻은 좌표를 지도의 중심으로 설정합니다.
            map.setZoom(10); // 지도의 줌 레벨을 변경합니다.
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

                infowindow.setContent('<div style="font-size: 10px; padding:20px;"><h5 style="margin-bottom:5px;color:#f00;">Geolocation not supported</h5>' + "latitude: " + center.lat() + "<br />longitude: " + center.lng() + '</div>');
                infowindow.open(map, center);
            }
        });

        function searchAddressToCoordinate(address) {
            naver.maps.Service.geocode({
                address: address
            }, function(status, response) {
                if (status === naver.maps.Service.Status.ERROR) {
                    return alert('Something Wrong!');
                }

                var item = response.result.items[0],
                    addrType = item.isRoadAddress ? '[도로명 주소]' : '[지번 주소]',
                    point = new naver.maps.Point(item.point.x, item.point.y);

                // infoWindow.setContent([
                //     '<div style="padding:10px;min-width:200px;line-height:150%;">',
                //     '<h4 style="margin-top:5px;">검색 주소 : '+ response.result.userquery +'</h4><br />',
                //     addrType +' '+ item.address +'<br />',
                //     '&nbsp&nbsp&nbsp -> '+ point.x +','+ point.y,
                //     '</div>'
                // ].join('\n'));


                map.setCenter(point);
                // infoWindow.open(map, point);
            });
        }

        $.get({
            url: '/trashcan/get',
            dataType: 'json',
            success: function (data) {
                data.forEach(function (item, index, arr) {
                    var marker = new naver.maps.Marker({
                        map: map,
                        position: new naver.maps.LatLng(item.latitude, item.longitude)
                    });

                    var trashcan_info = Array;
                    trashcan_info['id'] = item.id;
                    trashcan_info['in'] = item.in;
                    trashcan_info['out'] = item.out;
                    trashcan_info['humidity'] = item.humidity;
                    trashcan_info['ultrawave'] = item.ultrawave;
                    trashcan_info['weight'] = item.weight;

                    trashcan_info['height'] = item.height;
                    trashcan_info['area'] = item.area;
                    trashcan_info['capacity'] = item.capacity;
                    trashcan_info['address'] = item.address;
                    trashcan_info['latitude'] = item.latitude;
                    trashcan_info['longitude'] = item.longitude;

                    trashcans.push(trashcan_info);

                    var contentString = [
                        '<div style="max-width: 150px; overflow: hidden; font-size: 10px; padding: 15px 15px 0 15px;">',
                        '   <h6 style="max-width: 120px; max-height: 40px; overflow: hidden">' + item.address + '</h6>',
                        '   <p>',
                        '       내부 온도 : ' + item.in,
                        '       <br>외부 온도 : ' + item.out,
                        '       <br>습도 : ' + item.humidity,
                        '       <br>초음파 : ' + item.ultrawave,
                        '       <br>무게 : ' + item.weight,
                        '   </p>',
                        '</div>'
                    ].join('');

                    var infowindow = new naver.maps.InfoWindow({
                        content: contentString,
                    });

                    naver.maps.Event.addListener(marker, "click", function (e) {

                        trashcans.forEach(function (item, index, arr) {
                            if (item.latitude === e.coord.x) {
                                alert(item.latitude);
                            }
                        });

                        console.log(e);

                        if (infowindow.getMap()) {
                            infowindow.close();
                        } else {
                            infowindow.open(map, marker);
                        }
                    });
                })
            }
        });


        var infoWindow = new naver.maps.InfoWindow({
            anchorSkew: true
        });

        $('#search').on('keydown', function (e) {
            console.log(e.which);

            var keyCode = e.which;

            if (keyCode === 13) { // Enter Key
                searchAddressToCoordinate($('#search').val());
            }
        });

        // naver.maps.onJSContentLoaded = initGeocoder;

        $('#sido').html(Cookies.get("sido"));
        $('#sigugun').html(Cookies.get("sigugun"));
        $('#dongmyun').html(Cookies.get("dongmyun"));
    </script>
@endsection