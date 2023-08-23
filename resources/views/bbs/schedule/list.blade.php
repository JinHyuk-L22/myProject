@extends('layouts.app')
@section('content')
<?php
use Carbon\Carbon;

?>
    <div class="calendarUtil">
        <div class="btn fl">
        </div>

        <div class="calendarSort fr">
            <form id="boardForm" name="boardForm" action="{{ route('bbs.calender', ['bbs_name' => $bbs_name]) }}" method="get">
                <fieldset>
                    <legend>달력 보기</legend>
                    <select name="year" id="year" onchange="$('#boardForm').submit()">
                        @for($i = date('Y') - 5; $i <= date('Y') + 5; $i++)
                            @if(request()->query('year'))
                                <option value="{{$i}}" @if($i == request()->query('year')) selected @endif >{{$i}}년</option>
                            @else
                                <option value="{{$i}}" @if($i == date('Y')) selected @endif >{{$i}}년</option>
                            @endif
                        @endfor
                    </select>
                    <select name="month" id="month" onchange="$('#boardForm').submit()">
                        @for($j = 1; $j <= 12; $j++)
                            @if(request()->query('month'))
                                <option value="{{$j}}" @if($j == request()->query('month')) selected @endif >{{ $j < 10 ? '0'.$j : $j}}월</option>
                            @else
                                <option value="{{$j}}" @if($j == date('m')) selected @endif >{{ $j < 10 ? '0'.$j : $j}}월</option>
                            @endif
                        @endfor
                    </select>
                </fieldset>
            </form>
        </div>
    </div>

    <div class="calendar">

        <div class="month">
            <a href="{{ route('bbs.calender', ['bbs_name'=>$bbs_name, 'year'=>$datas['date']['prev_year'], 'month' => $datas['date']['prev_month']]) }}" class="prev">이전</a>
            <span>{{ $datas['date']['year'] }}년 {{ $datas['date']['month'] }}월</span>
            <a href="{{ route('bbs.calender', ['bbs_name'=>$bbs_name, 'year'=>$datas['date']['next_year'], 'month' => $datas['date']['next_month']]) }}" class="next">다음</a>
        </div>

        <table class="calendar">
            <colgroup>
                <col style="width:15%;">
                <col style="width:14%;">
                <col style="width:14%;">
                <col style="width:14%;">
                <col style="width:14%;">
                <col style="width:14%;">
                <col style="width:15%;">
            </colgroup>
            <thead>
            <tr>
                <th class="sun">일</th>
                <th>월</th>
                <th>화</th>
                <th>수</th>
                <th>목</th>
                <th>금</th>
                <th class="sat">토</th>
            </tr>
            </thead>
            <tbody>
            @for( $i = 1; $i <= $datas['date']['maxWeek']; $i++ )
                <tr>
                    @for( $j=0; $j<7; $j++ )
                        <td class="@if( $j == 0 ) sun @elseif( $j == 6 ) sat @endif">
                            @if( ( $i==1 && $j < $datas['date']['startDay'] ) || ( $i == $datas['date']['maxWeek'] && $j > $datas['date']['endDay'] ) )
                                <span></span>
                            @else
                                    <?php $this_day = $datas['date']['year'].'-'.$datas['date']['month'].'-'.sprintf('%02d', $datas['date']['day'] ); ?>

                                <span>{{ $datas['date']['day'] }}</span>

                                @foreach( $datas['posts'] as $key => $val )
                                    @if( $val['date_type'] == 'L' )
                                        @if( Carbon::parse($val->sdate)->format('j') <= $datas['date']['day']  && Carbon::parse($val->edate)->format('j') >= $datas['date']['day'] )
                                            @if( $val->gubun != 2 )
                                                <a href="{{ route('bbs.show', ['bbs_name'=>$bbs_name, 'sid'=>$val['sid']]) }}"><img src="/image/icon/calendar_01.png" alt="국내">{{ $val->subject }}</a>
                                            @else
                                                <a href="{{ route('bbs.show', ['bbs_name'=>$bbs_name, 'sid'=>$val['sid']]) }}"><img src="/image/icon/calendar_02.png" alt="국외">{{ $val->subject }}</a>
                                            @endif
                                        @endif
                                    @elseif( $val['date_type'] == 'D' )
                                        @if( Carbon::parse($val->sdate)->format('j') == $datas['date']['day'] )
                                            @if( $val->gubun != 2 )
                                                <a href="{{ route('bbs.show', ['bbs_name'=>$bbs_name, 'sid'=>$val['sid']]) }}"><img src="/image/icon/calendar_01.png" alt="국내">{{ $val->subject }}</a>
                                            @else
                                                <a href="{{ route('bbs.show', ['bbs_name'=>$bbs_name, 'sid'=>$val['sid']]) }}"><img src="/image/icon/calendar_02.png" alt="국외">{{ $val->subject }}</a>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach

                                    <?php $datas['date']['day']++; ?>
                            @endif
                        </td>
                    @endfor
                </tr>
            @endfor
            </tbody>
        </table>

        <table class="tblDef">
            <colgroup>
                <col style="width:30%;">
                <col style="width:70%;">
            </colgroup>
            <tbody>
            @if( !$datas['posts'] )
            <tr>
                <td colspan="2" class="noEvent">
                    행사가 없습니다.
                </td>
            </tr>
            @else
                @foreach( $datas['posts'] as $key => $val )
            <tr>
                <th>
                    @if( $val['date_type'] == 'L' )
                    {{ Carbon::parse($val->sdate)->format('Y-m-d') }} ~ {{ Carbon::parse($val->edate)->format('Y-m-d') }}
                    @else
                    {{ Carbon::parse($val->sdate)->format('Y-m-d') }}
                    @endif
                </th>
                <td>
                    @if( $val->gubun != 2 )
                        <a href="{{ route('bbs.show', ['bbs_name'=>$bbs_name, 'sid'=>$val['sid']]) }}"><img src="/image/icon/calendar_01.png" alt="국내">{{ $val->subject }}</a>
                    @else
                        <a href="{{ route('bbs.show', ['bbs_name'=>$bbs_name, 'sid'=>$val['sid']]) }}"><img src="/image/icon/calendar_02.png" alt="국외">{{ $val->subject }}</a>
                    @endif
                </td>
            </tr>
                @endforeach
            @endif
            </tbody>
        </table>

    </div>
    <!-- //calendar -->

    <div class="bbsUtil btn">
        @if( Auth::check() )
        <a href="{{route('bbs.create',['bbs_name' => $bbs_name])}}" class="upload">글쓰기</a>
        @endif
    </div>

@endsection
