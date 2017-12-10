@extends('layout')

@section('content')
    <div class="row">
        @include('listgroup')
        <div class="col-12 col-md-6 ">
            <div class="card mb-3">
                <div id="map" style="width:100%;height:400px;"></div>
            </div>
            <div class="card mb-3">
                <div class="row" style="height: 150px; overflow: scroll">
                    @foreach($trashcans as $trashcan)
                        <div class="col-3 trashcan-item" data-id="{{ $trashcan->id }}">
                            <div class="card" style="height: 24px; overflow: hidden;">
                                <div class="trashcan" data-id="{{ $trashcan->id }}" data-lat="{{ $trashcan->latitude }}"
                                     data-lng="{{ $trashcan->longitude }}">
                                    {{ $trashcan->name }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 ">
            <div id="tarshcan-info" class="card ">
                <form class="form-group" method="post" action="/trashcan/update">
                    {{ csrf_field() }}
                    <input type="hidden" class="form-control" name="id">
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
                        <input type="submit" class="btn btn-primary btn-block" value="수정">
                        <a id="delete" data-id="#" class="btn btn-danger btn-block" style="color: #fff;">삭제</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/map.js') }}"></script>
    {{--<script src="{{ asset('js/main.js') }}"></script>--}}
    <script>
        $(function () {
            var map = new naver.maps.Map('map', {
                zoom: 10,
                mapTypeId: naver.maps.MapTypeId.NORMAL
            });

            $.get({
                url: '/trashcan/get',
                dataType: 'json',
                success: function (data) {
                    data.forEach(function (item, index, arr) {
                        var marker = new naver.maps.Marker({
                            map: map,
                            position: new naver.maps.LatLng(item.latitude, item.longitude)
                        });
                    });
                }
            });

            $('.trashcan').on('click', function () {
                var lat = $(this).data('lat');
                var lng = $(this).data('lng');

                var id = $(this).data('id');

                console.log('/trashcan/get?id=' + id);

                var position = new naver.maps.LatLng(lat, lng);

                map.setCenter(position);

                $('input[name=latitude]').val(lat);
                $('input[name=longitude]').val(lng);

                $.get({
                    'url': '/trashcan/get?id=' + id,
                    'dataType': 'json',
                    'success': function (data) {
                        console.log(data[0]);
                        $('input[name=id]').val(data[0].id);
                        $('input[name=name]').val(data[0].name);
                        $('input[name=address]').val(data[0].address);
                        $('input[name=height]').val(data[0].height);
                        $('input[name=area]').val(data[0].area);
                        $('input[name=capacity]').val(data[0].capacity);
                        $('input[name=pid]').val(data[0].pid);
                        $('#delete').attr('data-id', data[0].id);
                    }
                });
            });

            $('#delete').on('click', function() {
                var vid = 0;
                vid = $('input[name=id]').val();

                console.log('/trashcan/delete?id=' + vid);

                $.get({
                    'url': '/trashcan/delete?id=' + vid,
                    'dataType': 'json',
                    'success': function (data) {
                        $('div[data-id='+vid+']').remove();
                        $('input[name=id]').val('');
                        $('input[name=latitude]').val('');
                        $('input[name=longitude]').val('');
                        $('input[name=name]').val('');
                        $('input[name=address]').val('');
                        $('input[name=height]').val('');
                        $('input[name=area]').val('');
                        $('input[name=capacity]').val('');
                        $('input[name=pid]').val('');
                        $('#delete').attr('data-id', '#');
                        return false;
                    }
                });
            });
        });
    </script>
@endsection