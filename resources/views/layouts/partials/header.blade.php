<div id="headerWrap">
    <dl id="skipNavi">
        <dt>Skip Navigation</dt>
        <dd><a href="#container">Skip to contents</a></dd>
    </dl>

    <h1><a href="/"><img src="/image/common/header_logo_m.png" alt="코로나19백신안정성연구센터"></a></h1>
    <div class="viewMenu"><a href="#">메뉴 전체 보기</a></div>

    <div class="gnbWrap">
        <ul id="gnb">
            @foreach(config('menu') as $menu)
                @if($menu['is_show_header'])
                    <li>
                        <a href="{{ route( $menu['route_name'], $menu['route_parameter'] ) }}">{{ $menu['title'] }}</a>

                        @if( isset($menu['sub']) && is_array($menu['sub']) && !empty($menu['sub']) )
                            <ul>
                                @foreach($menu['sub'] as $sub_menu)
                                    @if($sub_menu['is_show_header'])
                                        <li><a href="{{ route($sub_menu['route_name'], $sub_menu['route_parameter']) }}">{{ $sub_menu['title'] }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
        
        <ul class="gnbUtil">
            <li><a href="{{ route('index') }}">Home</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="">Admin</a></li>
        </ul>

        <dl class="login pcOnly">
            @if( !Auth::check() )
            <dt>
                <a href="{{ route('member.login') }}">
                    <img src="/image/common/header_user.png" alt="user">
                </a>
            </dt>
            @else
            <dt>
                <a href="javascript:void(0);">
                    <img src="/image/common/header_user.png" alt="user">
                </a>
            </dt>
            <dd>
                <p>
                    <strong>{{ Auth::user()->name }}</strong>님<br>
                    현재 관리자 로그인 상태입니다.
                </p>
                <ul>
                    <li>
                        @if( Auth::user()->level == 'M' )
                        <a href="javascript:void(0);" onclick="adminPopUp('');">계정관리</a>
                        @endif
                    </li>
                    <li>
                        <a href="javascript:void(0);" onclick="memberLogout();return false;">로그아웃</a>
                        <form action="{{ route('member.logout') }}" method="post" style="display: none;" id="logout-form">
                            @csrf
                        </form>
                    </li>
                </ul>
            </dd>
            @endif
        </dl>

        <div class="gnbClose"><a href="#">Menu Close</a></div>
    </div>
    <!-- //gnbWrap -->

</div>
