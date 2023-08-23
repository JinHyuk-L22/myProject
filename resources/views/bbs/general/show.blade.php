@extends('layouts.app')

@push('scripts')
<script>
    function delBbs(){

        if( $("input[name=swalBool]").val() != 'true' ){
            var form = $("#delete-form");
            var swalMsg = <?= json_encode(config('site.swal.check'))?>;
            var swaltitle = swalMsg[form.attr('tType')];
            swalYesOrNo( swaltitle, form.attr('id') );
            return false;
        } 

    }

</script>
@endpush

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

            <form id="delete-form" name="delete-form" action="{{ route('bbs.destroy', ['bbs_name' => $bbs_name, 'sid' => $bbsTbl->sid]) }}" method="get" tType="D">
                <input type="hidden" name="swalBool" value="false">
            </form>

            <a href="{{ route('bbs.edit', ['bbs_name' => $bbs_name, 'sid' => $bbsTbl->sid]) }}" class="modify">수정</a>
            <a href="javascript:void(0);" class="delete" onclick="delBbs();">삭제</a>
            @endif
            <a href="{{ route('bbs.list', ['bbs_name' => $bbs_name]) }}" class="list">목록</a>
        </div>
    </div>
@endsection
