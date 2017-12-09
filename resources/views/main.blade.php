@extends('layout')

@section('content')
    <div class="row">
        @include('listgroup')
        <div class="col-12 col-md-6 ">
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
    <script src="{{ asset('js/main.js') }}"></script>
@endsection