/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 45);
/******/ })
/************************************************************************/
/******/ ({

/***/ 45:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(46);


/***/ }),

/***/ 46:
/***/ (function(module, exports) {

$(function () {
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

    var map = new naver.maps.Map('map', {
        center: new naver.maps.LatLng(initLatitude, initLongitude),
        zoom: 10,
        mapTypeId: naver.maps.MapTypeId.NORMAL
    });

    function onSuccessGeolocation(position) {
        var location = new naver.maps.LatLng(position.coords.latitude, position.coords.longitude);
        // map.setCenter(location); // 얻은 좌표를 지도의 중심으로 설정합니다.
        // map.setZoom(10); // 지도의 줌 레벨을 변경합니다.
    }

    function onErrorGeolocation() {
        var center = map.getCenter();

        infowindow.setContent('<div style="padding:20px;">' + '<h5 style="margin-bottom:5px;color:#f00;">Geolocation failed!</h5>' + "latitude: " + center.lat() + "<br />longitude: " + center.lng() + '</div>');

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

    $.get({
        url: '/trashcan/get',
        dataType: 'json',
        success: function success(data) {
            data.forEach(function (item, index, arr) {
                var marker = new naver.maps.Marker({
                    map: map,
                    position: new naver.maps.LatLng(item.latitude, item.longitude)
                });

                console.log(marker.map);

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

                var contentString = ['<div style="padding: 20px 20px 0 20px;">', '   <h5>' + item.address + '</h5>', '   <p>', '       내부 온도 : ' + item.in, '       <br>외부 온도 : ' + item.out, '       <br>습도 : ' + item.humidity, '       <br>초음파 : ' + item.ultrawave, '       <br>무게 : ' + item.weight, '   </p>', '</div>'].join('');

                var infowindow = new naver.maps.InfoWindow({
                    content: contentString
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
            });
        }
    });
});

/***/ })

/******/ });