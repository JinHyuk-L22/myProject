@extends('layouts.app')
@section('content')
    <div class="bbsView">
        <dl class="bbsBrief">
            <dt>
                @if( $bbsTbl->is_notice == 'Y' )
                <img src="/image/icon/icon_notice.png" alt="공지" class="notice">
                @endif
                {{ $bbsTbl->title }}
            </dt>
            <dd>
                <ul>
                    <li>{{ $bbsTbl->created_at->toDateString() }}</li>
                    <li><span>조회수 : </span>{{ $bbsTbl->read_count }}</li>
                    <li><span>Link URL : </span><a href="{{ $bbsTbl->link_url }}" target="_blank">{{ $bbsTbl->link_url }}</a></li>
                </ul>
            </dd>
        </dl>

        <div class="bbsCon">
            {!! $bbsTbl->content !!}
        </div>

        @if( count($bbsTbl->bbs_files) > 0 )
            <ul class="attachment">
                @foreach($bbsTbl->bbs_files as $file)
                    <li><a href="{{ route('file.download', ['sid' => $file]) }}">{{ $file->filename }}</a></li>
                @endforeach
            </ul>
        @endif

        <div class="bbsUtil btn">
            @if( Auth::check() )
                <a href="{{ route('bbs.edit', ['bbs_name' => $bbs_name, 'sid' => $bbsTbl->sid]) }}" class="modify">수정</a>
                <a href="{{ route('bbs.destroy', ['bbs_name' => $bbs_name, 'sid' => $bbsTbl->sid]) }}" class="delete"
                   onclick="event.preventDefault();if (confirm('정말 글을 삭제하시겠습니까?')) {document.location.href = this.href;}">삭제</a>
            @endif
            <a href="{{ route('bbs.list', ['bbs_name' => $bbs_name]) }}" class="list">목록</a>
        </div>
    </div>
@endsection
