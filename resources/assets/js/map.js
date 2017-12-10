$(function() {
    function onSuccessGetLocation(position) {
        Cookies.set('latitude', position.coords.latitude);
        Cookies.set('longitude', position.coords.longitude);

        var jsonText = '{"x":'+position.coords.longitude+', "y":'+position.coords.latitude+', "_lat":'+position.coords.latitude+', "_lng":'+position.coords.latitude+"}";
        var coordObj = JSON.parse(jsonText);
        searchCoordinateToAddress(coordObj);
    }

    function onErrorGetLocation() {

    }

    $(window).on("load", function () {
        if(Cookies.get("latitude") && Cookies.get("longitude")) {
            var jsonText = '{"x":'+Cookies.get("longitude")+', "y":'+Cookies.get("latitude")+', "_lat":'+Cookies.get("latitude")+', "_lng":'+Cookies.get("longitude")+"}";
            var coordObj = JSON.parse(jsonText);
            searchCoordinateToAddress(coordObj);
        }
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(onSuccessGetLocation, onErrorGetLocation);
        }
    });

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

            console.log(items);
            // alert(items[0].addrdetail.sido);

            Cookies.set("sido", items[0].addrdetail.sido);
            Cookies.set("sigugun", items[0].addrdetail.sigugun);
            Cookies.set("dongmyun", items[0].addrdetail.dongmyun);

            location.reload();
        });
    }
});