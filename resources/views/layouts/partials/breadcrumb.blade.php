<?php
$selected_first_menu = config('menu.' . $selected_first_menu_key);
$selected_second_menu = Arr::get($selected_first_menu, 'sub.' . $selected_second_menu_key);
?>
    <h2 class="pageTit">{{ $selected_second_menu['title'] ?? '' }}</h2>
    
    <div class="lnbWrap">
        <div>
            <p class="home"><a href="{{ route('index') }}"><img src="/image/common/inb_home.png" alt="home"></a></p>
            <dl class="gnb">
                <dt><a href="#" class="trigger">{{ $selected_first_menu['title'] }}</a></dt>
                <dd class="toggleCon">
                    <ul>
                        @foreach(config('menu') as $menu)
                            @if($menu['is_show_breadcrumb'])
                                <li><a href="{{ route($menu['route_name'], $menu['route_parameter']) }}">{{ $menu['title'] }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </dd>
            </dl>
            <dl class="lnb">
                <dt><a href="#" class="trigger">{{ $selected_second_menu ? $selected_second_menu['title'] : '' }}</a></dt>
                <dd class="toggleCon">
                    @if(isset($selected_first_menu['sub']) && is_array($selected_first_menu['sub']) && !empty($selected_first_menu['sub']))
                        <ul>
                            @foreach($selected_first_menu['sub'] as $menu)
                                @if($menu['is_show_breadcrumb'])
                                    <li><a href="{{ route($menu['route_name'], $menu['route_parameter']) }}">{{ $menu['title'] }}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </dd>
            </dl>
        </div>
    </div>