@extends('layout')

@section('stylesheet')
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-4 col-md-offset-4">
            <div class="card">
                <fb:login-button
                        scope="public_profile,email"
                        onlogin="checkLoginState();">
                </fb:login-button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '{your-app-id}',
                cookie     : true,
                xfbml      : true,
                version    : '{latest-api-version}'
            });

            FB.AppEvents.logPageView();

        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endsection