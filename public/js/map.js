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
/******/ 	return __webpack_require__(__webpack_require__.s = 43);
/******/ })
/************************************************************************/
/******/ ({

/***/ 43:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(44);


/***/ }),

/***/ 44:
/***/ (function(module, exports) {

$(function () {
    function onSuccessGetLocation(position) {
        Cookies.set('latitude', position.coords.latitude);
        Cookies.set('longitude', position.coords.longitude);

        var jsonText = '{"x":' + position.coords.longitude + ', "y":' + position.coords.latitude + ', "_lat":' + position.coords.latitude + ', "_lng":' + position.coords.latitude + "}";
        var coordObj = JSON.parse(jsonText);
        searchCoordinateToAddress(coordObj);
    }

    function onErrorGetLocation() {}

    $(window).on("load", function () {
        if (Cookies.get("latitude") && Cookies.get("longitude")) {
            var jsonText = '{"x":' + Cookies.get("longitude") + ', "y":' + Cookies.get("latitude") + ', "_lat":' + Cookies.get("latitude") + ', "_lng":' + Cookies.get("longitude") + "}";
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

                htmlAddresses.push(i + 1 + '. ' + addrType + ' ' + item.address);
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

/***/ })

/******/ });