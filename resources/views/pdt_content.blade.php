@extends('master')

@section('title', $product->name)

@section('content')

    <link rel="stylesheet" href="/css/swiper.min.css">

    <div class="page bk_content">
    <style>
        html, body {
            position: relative;
            height: 100%;
        }
        body {
            background: #eee;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color:#000;
            margin: 0;
            padding: 0;
        }
        .swiper-container {
            width: 100%;
            height: 50%;

        }
        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;

            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }
    </style>
{{--    <div class="addWrap">--}}
{{--    <div class="swipe" id="mySwipe">--}}
{{--        <div class="swipe-wrap">--}}
{{--            @foreach($pdt_images as $pdt_image)--}}
{{--                <div>--}}
{{--                    <a href="javascript:;" class="img-responsive" src="{{$pdt_image->image_path}}"></a>--}}
{{--                </div>--}}
{{--                @endforeach--}}
{{--        </div>--}}
{{--    </div>--}}
{{--        <ul id="position">--}}
{{--            @foreach($pdt_images as $index => $pdt_image)--}}
{{--                <li class={{$index == 0 ? 'cur':''}}></li>--}}
{{--                @endforeach--}}
{{--        </ul>--}}
{{--    </div>--}}
    <!-- Swiper -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach($pdt_images as $pdt_image)
            <div class="swiper-slide"><a href="javascript:;" ><img src="{{$pdt_image->image_path}}" alt=""></a></div>
            @endforeach

        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>







   <div class="weui_cells_title">
       <span class="bk_title">{{$product->name}}</span>
       <span class="bk_price" style="float:right">¥ {{$product->price}}</span>
   </div>

    <div class="weui_cells">
        <div class="weui_cell">
            <p class="bk_summary">{{$product->summary}}</p>
        </div>
    </div>



    <div class="weui_cells_title">详细介绍</div>
    <div class="weui_cells">
        <div class="weui_cell">

            @if($pdt_content != null)
                {!! $pdt_content->content!!}
                @else
                @endif



        </div>
    </div>
    </div>

    <div class="bk_fix_bottom">
        <div class="bk_half_area">
            <bottom class="weui_btn weui_btn_primary" onclick="_addCart();">加入购物车</bottom>
        </div>
        <div class="bk_half_area">
            <bottom class="weui_btn weui_btn_default" onclick="_toCart();" >查看购物车<span id="cart_num" class="m3_price">{{$count}}</span></bottom>
        </div>

    </div>


    @endsection
@section('my-js')
    <!-- Swiper JS -->
    <script src="/js/swiper.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper('.swiper-container', {
            spaceBetween: 30,
            centeredSlides: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });


        function _addCart(){
            var product_id = "{{$product->id}}";
            $.ajax({
                type: "GET",
                url: '/service/cart/add/'+product_id,
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if(data == null) {
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html('服务端错误');
                        setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                        return;
                    }
                    if(data.status != 0) {
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html(data.message);
                        setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                        return;
                    }

                    var num = $('#cart_num').html();
                    if(num == '') num = 0;
                    $('#cart_num').html(Number(num) + 1);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        }
        function _toCart(){
            location.href = '/cart';
        }
    </script>
@endsection