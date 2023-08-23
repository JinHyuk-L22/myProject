<?php

return [

    'general' => [
        'title' => '일반자료실',
        'skin' => 'general',
        'use_notice' => true, // 게시판 공지 사용 여부
        'use_view_in_main' => true, // 메인 페이지에 표시 여부
        'use_link_url' => true, // 링크 URL 항목 사용 여부
        'use_popup' => true, // 팝업 사용 여부
        'use_reply' => false, // 답글 사용 여부
        'use_comment' => false, // 댓글(코멘트) 사용 여부
        'index' => 'bbs.list',
        'pageView' => 8,
        'first_menu_key' => 'board',
        'second_menu_key' => 'general',
        'type' => 1,
        'Search' => [ 'title'=>'제목', 'content'=>'내용' ],
        'permission' => [
            'admin' => function () {
                return Auth::check();
            },
            'create' => function () {
                return Auth::check();
            },
            'index' => function () {
                return true;
            },
            'show' => function () {
                return true;
            },
            'comment' => function () {
                return false;
            },
            'edit' => function () {
                return Auth::check();
            },
            'destroy' => function () {
                return Auth::check();
            },
            'list' => function () {
                return true;
            },
            'update' => function () {
                return Auth::check();
            },
        ],
    ],

    'schedule' => [
        'title' => '일정',
        'skin' => 'schedule',
        'use_notice' => true, // 게시판 공지 사용 여부
        'use_view_in_main' => true, // 메인 페이지에 표시 여부
        'use_link_url' => true, // 링크 URL 항목 사용 여부
        'use_popup' => true, // 팝업 사용 여부
        'use_reply' => false, // 답글 사용 여부
        'use_comment' => false, // 댓글(코멘트) 사용 여부
        'index' => 'bbs.calender',
        'pageView' => 8,
        'first_menu_key' => 'bbs',
        'second_menu_key' => 'schedule',
        'type' => 1,
        'Search' => [ 'title'=>'제목', 'content'=>'내용' ],
        'permission' => [
            // 'admin' => function () {
            //     return Auth::check();
            // },
            'create' => function () {
                return Auth::check();
            },
            // 'index' => function () {
            //     return true;
            // },
            'show' => function () {
                return true;
            },
            // 'comment' => function () {
            //     return false;
            // },
            'edit' => function () {
                return Auth::check();
            },
            'destroy' => function () {
                return Auth::check();
            },
            // 'list' => function () {
            //     return true;
            // },
            'calender' => function () {
                return true;
            },
            'update' => function () {
                return Auth::check();
            },
        ],
    ],

];
