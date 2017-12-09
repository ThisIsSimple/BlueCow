$(function() {
    function onSuccessGetLocation(position) {
        Cookies.set('latitude', position.coords.latitude);
        Cookies.set('longitude', position.coords.longitude);
    }

    function onErrorGetLocation() {

    }

    $(window).on("load", function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(onSuccessGetLocation, onErrorGetLocation);
        }
    });
});