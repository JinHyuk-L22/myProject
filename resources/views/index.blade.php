@extends('layouts.home')
    @section('content')
    <div class="wrapper">
        @include('layouts.partials.header')

        <div id="container" class="main">

        <div class="contents">

            <div class="mainVisual">
                <h2 class="mainTit">
                    <img src="/image/main/main_text.png" alt="코로나19 백신안전성연구센터" class="pcOnly">
                    <img src="/image/main/main_text_m.png" alt="코로나19 백신안전성연구센터" class="mOnly">
                </h2>

                <div class="mainBg">
                    <img src="/image/main/main_bnr_v1.png" alt="">
                    <img src="/image/main/main_bnr_v2.png" alt="">
                    <img src="/image/main/main_bnr_v3.png" alt="">
                    <img src="/image/main/main_bnr_v4.png" alt="">
                </div>
            </div>

            <div class="mainCon">
                <dl class="notice">
                    <dt><img src="/image/main/main_notice_tit.png" alt="알림"></dt>
                    <dd>
                        <ul class="menu">
                            <li onclick="changeList(this,1);"><a href="javascript:void(0);">공지사항</a></li>
                            <li class="on" onclick="changeList(this,2);"><a href="javascript:void(0);">일정</a></li>
                        </ul>
                         <ul class="menuList" id="noticeList" style="display:none;">
                             <li>
                                 <a href="">
                                     <span>[공지사항]</span><span class="date"></span>
                                 </a>
                             </li>
                        </ul>
                        <div class="intro" style="padding-top:10px;">
                            <img src="/image/main/main_intro_01.png" alt="intro" class="">
                        </div>
                    </dd>
                </dl>

                <dl class="mainQuick">
                    <dt><img src="/image/main/main_link_tit.png" alt="알림"></dt>
                    <dd>
                        <ul>
                            <li><a href="">소개<img src="/image/main/linkIcon01.png" alt=""></a></li>
                            <li><a href="">주요사업<img src="/image/main/linkIcon02.png" alt=""></a></li>
                            <li><a href="">자료실<img src="/image/main/linkIcon03.png" alt=""></a></li>
                            <li><a href="">국제협력<img src="/image/main/linkIcon04.png" alt=""></a></li>
                        </ul>
                    </dd>
                </dl>
            </div>
            <!-- //mainCon -->


        </div>
        <!-- //contents -->
        <div class="mainSponsor">
            <ul>
                <li><a href="#"><img src="/image/sponsor/sponsor.png" alt=""></a></li>
                <li><a href="#"><img src="/image/sponsor/sponsor.png" alt=""></a></li>
                <li><a href="#"><img src="/image/sponsor/sponsor.png" alt=""></a></li>
                <li><a href="#"><img src="/image/sponsor/sponsor.png" alt=""></a></li>
                <li><a href="#"><img src="/image/sponsor/sponsor.png" alt=""></a></li>
                <li><a href="#"><img src="/image/sponsor/sponsor.png" alt=""></a></li>
                <li><a href="#"><img src="/image/sponsor/sponsor.png" alt=""></a></li>
                <li><a href="#"><img src="/image/sponsor/sponsor.png" alt=""></a></li>
                <li><a href="#"><img src="/image/sponsor/sponsor.png" alt=""></a></li>
                <li><a href="#"><img src="/image/sponsor/sponsor.png" alt=""></a></li>
            </ul>
        </div>
        <!-- <p id="goTop"><a href="#"><img src="/image/common/goTop.png" alt="Go top"></a></p> -->
    </div>
    @endsection
