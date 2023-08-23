<?php

return [

    'noticePushType' => [
        'is_notice' => '공지'
        , 'is_push' => 'PUSH'
    ],

    'is_pop' => [
        'Y' => '사용'
        , 'N' => '미사용'
    ],

    'template' => [
        '0' => '없음'
        , '1' => '팝업 템플릿 1'
        , '2' => '팝업 템플릿 2'
    ],

    'pop_content_type' => [
        '0' => '공지 내용과 동일'
       , '1' => '팝업 내용 새로 작성'
    ],

    'pop_detail' => [
        'Y' => '설정함'
        , 'N' => '설정 안함'
    ],

    'pop_resize' => [
        'Y' => '설정함'
        , 'N' => '설정 안함'
    ],

    'pop_date' => [
        'pop_sdate' => array(
            'text' => '시작일'
            , 'img' => '/image/icon/calendar.png'
        )
        , 'pop_edate' => array(
            'text' => '종료일'
            , 'img' => '/image/icon/calendar.png'
        )
    ],

    'status' => [
        'Y' => '공개'
        , 'N' => '비공개'
    ],

    's_gubun' => [
        1 => '세미나'
        , 2 => '학술대회'
        , 3 => '포럼'
        , 4 => '행사'
        , 5 => '회의'
    ],

    's_date_type' => [
        'D' => '하루행사'
        , 'L' => '장기행사'
    ]

];
