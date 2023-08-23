@extends('layouts.clean')
@push('scripts')
    @if(Route::getCurrentRoute()->getName() === 'popup.preview')
        <script type="text/javascript">
            $(function () {
                $(window).on('resize', function () {
                    window.opener.on_popup_window_resize(window);
                });
            });
        </script>
    @endif
@endpush

@section('content')
    <div class="skinWrap skin01">
        <div class="popHeader">
                <div class="tit">{{ $post_data['post_title'] }}</div>
        </div>

        <div class="contWrap">
            <div class="content">
                {!! $post_data['popup_content'] !!}

                    @if( $post_data['popup_use_detail_btn'] == 'Y' )
                    <div class="btnWrap">
                        <div class="btn"><a href="{{ $post_data['popup_detail_link'] ?? '#'}}" class="btnDef" onclick="event.preventDefault();window.opener.document.location.href=this.href;window.close();">바로보기</a></div>
                    </div>
                    @endif

            </div>
        </div>

        <div id="popClose">
            <form id="close-form" method="post" action="{{ route('popup.close') }}">
                @csrf

                @if(Route::getCurrentRoute()->getName() !== 'popup.preview')
                    <input type="hidden" id="close_form_popup_id" name="popup_id" value="{{ $post_data->sid }}" />
                @endif

                <fieldset>
                    <legend>팝업창 닫기</legend>
                    <input type="checkbox" id="close_form_is_not_open" name="is_not_open" value="1" />
                    <label for="close_form_is_not_open">오늘 하루 열지 않기</label>

                    <a href="#" class="lm20" onclick="event.preventDefault();$('#close-form').submit();">[ 닫기 ]</a>
                </fieldset>
            </form>
        </div>
    </div>
@endsection
