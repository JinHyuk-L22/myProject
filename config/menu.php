<?php

return [

    'about' => [
        'title' => '소개',
        'route_name' => 'bbs.list',
        'route_parameter' => [
            'general'
        ],
        'is_show_header' => true,
        'is_show_breadcrumb' => true,
        'sub' => [
            'message' => [
                'title' => '인사말',
                'route_name' => 'bbs.list',
                'route_parameter' => [
                    'general'
                ],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
            'organization' => [
                'title' => '조직도',
                'route_name' => 'bbs.list',
                'route_parameter' => [
                    'general'
                ],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
            'year' => [
                'title' => '연혁',
                'route_name' => 'bbs.list',
                'route_parameter' => [
                    'general'
                ],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
            'gigu' => [
                'title' => '기구',
                'route_name' => 'bbs.list',
                'route_parameter' => [
                    'general'
                ],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
            'rule' => [
                'title' => '규정/지침',
                'route_name' => 'bbs.list',
                'route_parameter' => [
                    'general'
                ],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
            'participation' => [
                'title' => '참여연구진',
                'route_name' => 'bbs.list',
                'route_parameter' => [
                    'general'
                ],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
        ],
    ],

    'bbs' => [
        'title' => '알림',
        'route_name' => 'bbs.list',
        'route_parameter' => ['notice'],
        'is_show_header' => true,
        'is_show_breadcrumb' => true,
        'sub' => [
            'notice' => [
                'title' => '공지사항',
                'route_name' => 'bbs.list',
                'route_parameter' => ['notice'],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
            'schedule' => [
                'title' => '일정',
                'route_name' => 'bbs.calender',
                'route_parameter' => ['schedule'],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
        ],
    ],

    'business' => [
        'title' => '주요사업',
        'route_name' => 'bbs.list',
        'route_parameter' => [
            'general'
        ],
        'is_show_header' => true,
        'is_show_breadcrumb' => true,
        'sub' => [
            'business' => [
                'title' => '주요사업',
                'route_name' => 'bbs.list',
                'route_parameter' => [
                    'general'
                ],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
            'forum' => [
                'title' => '포럼',
                'route_name' => 'bbs.list',
                'route_parameter' => [
                    'general'
                ],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
        ],
    ],

    'cooperation' => [
        'title' => '국제협력',
        'route_name' => 'bbs.list',
        'route_parameter' => [
            'general'
        ],
        'is_show_header' => true,
        'is_show_breadcrumb' => true,
        'sub' => [
            'business' => [
                'title' => '주요사업',
                'route_name' => 'bbs.list',
                'route_parameter' => [
                    'general'
                ],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
            'collabo' => [
                'title' => 'Brighton Collaboration',
                'route_name' => 'bbs.list',
                'route_parameter' => [
                    'collabo'
                ],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
        ],
    ],

    'board' => [
        'title' => '자료실',
        'route_name' => 'bbs.list',
        'route_parameter' => [
            'newsletter'
        ],
        'is_show_header' => true,
        'is_show_breadcrumb' => true,
        'sub' => [
            'newsletter' => [
                'title' => '뉴스레터',
                'route_name' => 'bbs.list',
                'route_parameter' => [
                    'newsletter'
                ],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
            'report' => [
                'title' => '질환별 분석보고서',
                'route_name' => 'bbs.list',
                'route_parameter' => [
                    'report'
                ],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
            'book' => [
                'title' => '발간도서',
                'route_name' => 'bbs.list',
                'route_parameter' => [
                    'book'
                ],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
            'general' => [
                'title' => '일반 자료실',
                'route_name' => 'bbs.list',
                'route_parameter' => [
                    'general'
                ],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
			 'gallery' => [
                'title' => '사진/동영상 자료실',
                'route_name' => 'bbs.list',
                'route_parameter' => [
                    'gallery'
                    , 'type=1'
                ],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],
        ],
    ],

    'organization' => [
        'title' => '유관단체',
        'route_name' => 'bbs.list',
        'route_parameter' => [
            'general'
        ],
        'is_show_header' => true,
        'is_show_breadcrumb' => true,
        'sub' => [
            'site' => [
                'title' => '웹사이트',
                'route_name' => 'bbs.list',
                'route_parameter' => [
                    'general'
                ],
                'is_show_header' => true,
                'is_show_breadcrumb' => true,
            ],

        ],
    ],

];
