@extends('layouts.app')

@push('scripts')
<script>
    function delBbs(){

        if( $("input[name=swalBool]").val() != 'true' ){
            var form = document.getElementById("delete-form");
            var swalMsg = <?= json_encode(config('site.swal.check'))?>;
            var swaltitle = swalMsg[$(form).attr('tType')];
            swalYesOrNo( swaltitle, form.id );
            return false;
        } 

    }

</script>
@endpush
@section('content')
    <div class="bbsView">
        <dl class="bbsBrief">
            <dt>{{ $bbsTbl->subject  }}</dt>
            <dd>
                <ul>
                    <li>{{ $bbsTbl->created_at->toDateString() }}</li>
                    <li><span>조회수 : </span>{{ $bbsTbl->read_count }}</li>
                    @if( $bbsTbl->linkurl != 'http://' )
                        <li><span>Link URL : </span><a href="{{ $bbsTbl->linkurl }}" target="_blank">{{ $bbsTbl->linkurl }}</a></li>
                    @endif
                </ul>
            </dd>
        </dl>

        <table class="bbsView">
            <colgroup>
                <col style="width: 15%;">
                <col style="width: *;">
            </colgroup>
            <tbody>
            <tr>
                <th>구분</th>
                <td>{{ config('site.bbs_param.s_gubun')[$bbsTbl->gubun] }}</td>
            </tr>
            <tr>
                <th>일시</th>
                <td>
                    @if( $bbsTbl->date_type == 'L' )
                        {{ $bbsTbl->sdate }} ~ {{ $bbsTbl->edate }}
                    @else
                        {{ $bbsTbl->sdate }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>장소</th>
                <td>{{ $bbsTbl->place }}</td>
            </tr>
            <tr>
                <th>주최</th>
                <td>{{ $bbsTbl->sponsor }}</td>
            </tr>
            <tr>
                <th>문의처</th>
                <td>{{ $bbsTbl->inquiry }}</td>
            </tr>
            </tbody>
        </table>
        @if($bbsTbl->bbs_files)
            <ul class="attachment">
            @foreach( $bbsTbl->bbs_files as $bbsfiles )
                <li><a href="{{ route('file.download', ['sid' => $bbsfiles->sid]) }}">{{ $bbsfiles->filename }}</a></li>
            @endforeach
            </ul>
        @endif

        <div class="bbsUtil btn">
            @if( Auth::check() )
            
            <form id="delete-form" name="delete-form" action="{{ route('bbs.destroy', ['bbs_name' => $bbs_name, 'sid' => $bbsTbl->sid]) }}" method="get" tType="D">
                <input type="hidden" name="swalBool" value="false">
            </form>

            <a href="{{ route('bbs.edit', ['bbs_name' => $bbs_name, 'sid' => $bbsTbl->sid]) }}" class=modify">수정</a>
            <a href="javascript:void(0);" class="delete" onclick="delBbs();">삭제</a>
                
            @endif
            <a href="{{ route('bbs.calender', ['bbs_name' => $bbs_name]) }}" class="list">목록</a>
        </div>
    </div>
@endsection
