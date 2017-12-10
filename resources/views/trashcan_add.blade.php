@extends('layout')

@section('content')
    <div class="row">
        @include('listgroup')
        <div class="col-12 col-md-6 ">
            @if($status === 'success')
                <div class="alert alert-success" role="alert">
                    성공적으로 등록되었습니다!
                </div>
            @else
                <div class="alert alert-success" role="alert">
                    자신만의 쓰레기통을 등록하세요!
                </div>
            @endif
            <input type="text" id="search" name="search" style="border: none;" class="form-control mb-3"
                   placeholder="집 주변 쓰레기통을 찾아 보세요!">
            <div class="card mb-3">
                <div id="map" style="width:100%;height:400px;"></div>
            </div>
        </div>
        <div class="col-12 col-md-3 ">
            <div id="tarshcan-info" class="card ">
                <form class="form-group" method="post" action="/trashcan/add">
                    {{ csrf_field() }}
                    <div class="card-header">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" placeholder="이름">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="latitude" readonly>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="longitude" readonly>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="address" placeholder="주소" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="height" placeholder="높이" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="area" placeholder="바닥 면적" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="capacity" placeholder="용량" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="pid" placeholder="아두이노 아이디" required>
                        </div>
                        <input type="submit" class="btn btn-primary btn-block" value="추가">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/map.js') }}"></script>
    <script>
        $('input[name=latitude]').val(Cookies.get('latitude'));
        $('input[name=longitude]').val(Cookies.get('longitude'));

        var position = new naver.maps.LatLng(Cookies.get('latitude'), Cookies.get('longitude'));

        var map = new naver.maps.Map('map', {
            center: position,
            zoom: 10
        });

        var marker = new naver.maps.Marker({
            position: position,
            map: map
        });

        naver.maps.Event.addListener(map, 'click', function (e) {
            console.log(e);
            $('input[name=latitude]').val(e.coord.y);
            $('input[name=longitude]').val(e.coord.x);
            marker.setPosition(e.coord);
        });

        // search by tm128 coordinate
        function searchCoordinateToAddress(latlng) {
            var tm128 = naver.maps.TransCoord.fromLatLngToTM128(latlng);

            naver.maps.Service.reverseGeocode({
                location: tm128,
                coordType: naver.maps.Service.CoordType.TM128
            }, function (status, response) {
                if (status === naver.maps.Service.Status.ERROR) {
                    return alert('Something Wrong!');
                }

                var items = response.result.items,
                    htmlAddresses = [];

                for (var i = 0, ii = items.length, item, addrType; i < ii; i++) {
                    item = items[i];
                    addrType = item.isRoadAddress ? '[도로명 주소]' : '[지번 주소]';

                    htmlAddresses.push((i + 1) + '. ' + addrType + ' ' + item.address);
                    htmlAddresses.push('&nbsp&nbsp&nbsp -> ' + item.point.x + ',' + item.point.y);
                }

                $('input[name=address]').val(items[0].address);
                console.log(items);

                infoWindow.setContent([
                    '<div style="padding:10px;min-width:200px;line-height:150%;">',
                    '<h4 style="margin-top:5px;">검색 좌표 : ' + response.result.userquery + '</h4><br />',
                    htmlAddresses.join('<br />'),
                    '</div>'
                ].join('\n'));

                infoWindow.open(map, latlng);
            });
        }

        function initGeocoder() {
            map.addListener('click', function (e) {
                searchCoordinateToAddress(e.coord);
            });
        }

        naver.maps.onJSContentLoaded = initGeocoder;

        // 주소 검색
        function searchAddressToCoordinate(address) {
            naver.maps.Service.geocode({
                address: address
            }, function (status, response) {
                if (status === naver.maps.Service.Status.ERROR) {
                    return alert('Something Wrong!');
                }

                var item = response.result.items[0],
                    addrType = item.isRoadAddress ? '[도로명 주소]' : '[지번 주소]',
                    point = new naver.maps.Point(item.point.x, item.point.y);

                map.setCenter(point);
            });
        }

        $('#search').on('keydown', function (e) {
            var keyCode = e.which;

            if (keyCode === 13) { // Enter Key
                searchAddressToCoordinate($('#search').val());
            }
        });
    </script>
@endsection