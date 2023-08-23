@extends('layouts.app')

@push('scripts')
<script>
    function delBbs( formId ){

        if( $("input[name=swalBool]").val() != 'true' ){
            var form = document.getElementById(formId);
            var swalMsg = <?= json_encode(config('site.swal.check'))?>;
            var swaltitle = swalMsg[$(form).attr('tType')];
            swalYesOrNo( swaltitle, form.id );
            return false;
        } 

    }

</script>
@endpush

@section('content')
    <!--
        메인페이지 class="main" 추가
    -->
    <div class="bbs">

        <div class="searchArea">
            <form action="{{ route('bbs.list', $bbs_name) }}" method="get" onsubmit="return search_check(this)">
                <fieldset>
                    <legend>검색</legend>
                    <select name="keyfield" id="keyfield">
                        @foreach( config('site.bbs')[$bbs_name]['Search'] as $key => $val )
                            <option value="{{ $key }}" {{ request()->query('keyfield') == $key ? 'selected' : '' }} >{{ $val }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="keyword" id="keyword" value="{{ request()->query('keyword') }}">

                    <input class="search" type="submit" value="검색">
                </fieldset>
            </form>
            <button class="reset" onclick="location.href='{{ route('bbs.list', $bbs_name) }}'"><img src="/image/icon/icon_reset.png" alt="">검색 초기화</button>
        </div>
        <!-- //searchArea -->

        <div class="bbsUtil btn">
            @if( Auth::check() )
                <a href="{{ route('bbs.create', $bbs_name) }}" class="upload">글쓰기</a>
            @endif
        </div>

        <table class="list">
            <colgroup>
                <col style="width: 8%;">
                <col style="width: *;">
                <col style="width: 8%;">
                <col style="width: 10%;">
                <col style="width: 12%;">
                <col style="width: 10%;">
                @if( Auth::check() )
                    <col style="width: 15%;">
                @endif
            </colgroup>
            <thead>
            <tr>
                <th>No</th>
                <th>제목</th>
                <th>첨부파일</th>
                <th>작성일</th>
                <th>공개여부</th>
                <th>조회수</th>
                @if( Auth::check() )
                    <th>관리</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @if($notice_posts->isEmpty() && $posts->isEmpty())
                <p class="noResult">
                    등록된 데이터가 없습니다.
                </p>
            @else
                @foreach($notice_posts as $post)
                    <tr class="notice">
                        <td>
                            <img src="/image/icon/icon_notice.png" alt="공지" class="notice">
                        </td>
                        <td class="tit">
                            <a href="{{ route('bbs.show',['bbs_name' => $bbs_name, 'sid' => $post->sid]) }}">
                                <span>{{ $post->title }}</span>
                            </a>
                        </td>
                        <td>
                            @if( count($post->bbs_files) > 0 )
                            <img src="/image/icon/bbs_download.png" alt="첨부파일 다운로드">
                            @endif
                        </td>
                        <td class="mDisplay">{{ $post->created_at->toDateString() }}</td>
                        <td class="admin">
                            <select name="" id="">
                                @foreach( config('site.bbs_param.status') as $key => $val )
                                <option value="{{ $key }}" {{ $post->status == $key ? 'selected' : '' }}>{{ $val }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="mDisplay">{{ $post->read_count }}</td>
                        @if( Auth::check() )
                            <td class="admin">
                                <a href="{{ route('bbs.edit', ['bbs_name' => $bbs_name, 'sid' => $post->sid]) }}">수정</a>
                                <a href="{{ route('bbs.destroy', ['bbs_name' => $bbs_name, 'sid' => $post->sid]) }}" class=""
                                   onclick="event.preventDefault();if (confirm('정말 글을 삭제하시겠습니까?')) {document.location.href = this.href;}">삭제</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
                @foreach($posts as $key => $val)
                    <tr>
                        <td>{{ $posts->currentPage() > 1 ? ( $posts->total()-( ($posts->currentPage()-1) * config('site.bbs.' . $bbs_name . '.pageView') ) )-$key : $posts->total()-$key }}</td>
                        <td class="tit">
                            <a href="{{ route('bbs.show',['bbs_name' => $bbs_name, 'sid' => $val->sid]) }}" class="<?= $val->created_at->addDay(2) > now() ? 'new' : ''?> reply">
                                <span>{{ $val->title }}</span>
                            </a>
                        </td>
                        <td>
                            @if( count( $val->bbs_files ) > 0 )
                            <img src="/image/icon/bbs_download.png" alt="첨부파일 다운로드">
                            @endif
                        </td>
                        <td class="mDisplay">{{ $val->created_at->toDateString() }}</td>
                        <td class="admin">
                            <select name="" id="" onchange="if (confirm('상태값을 변경 하시겠습니까?')){ document.location.href = `{{ route('bbs.change', ['bbs_name' => $bbs_name, 'sid' => $val->sid]) }}?status=${$(this).val()}`; }">
                                @foreach( config('site.bbs_param.status') as $pkey => $pval )
                                <option value="{{ $pkey }}" {{ $val->status == $pkey ? 'selected' : '' }}>{{ $pval }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="mDisplay">{{ $val->read_count }}</td>
                        @if( Auth::check() )
                            <td class="admin">
                            <form id="delete-form-{{$val->sid}}" name="delete-form-{{$val->sid}}" action="{{ route('bbs.destroy', ['bbs_name' => $bbs_name, 'sid' => $val->sid]) }}" method="get" tType="D">
                                <input type="hidden" name="swalBool" value="false">
                            </form>

                                <a href="{{ route('bbs.edit', ['bbs_name' => $bbs_name, 'sid' => $val->sid]) }}">수정</a>
                                <a href="javascript:void(0);" onclick="delBbs( 'delete-form-{{$val->sid}}' );">삭제</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endif

            </tbody>
        </table>
        {{ $posts->links('paginate', ['list'=>$posts]) }}

    </div>

    <!-- //contents -->

    <p id="goTop"><a href="#"><img src="/image/common/goTop.png" alt="Go top"></a></p>
    </div>
@endsection
