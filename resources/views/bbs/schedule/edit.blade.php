@extends('layouts.app')

@push('styles')
    <link type="text/css" rel="stylesheet" href="{{ asset('/vendor/plupload/2.3.6/jquery.plupload.queue/css/jquery.plupload.queue.css')}}" />

    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css') }}" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('scripts')

    <script type="text/javascript" src="{{ asset('/vendor/naver_smart_editor_2/js/service/HuskyEZCreator.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('/vendor/tinymce/4.5.8/tinymce.min.js') }}" charset="utf-8"></script>

    <script type="text/javascript" src="{{ asset('/vendor/plupload/2.3.6/plupload.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/plupload/2.3.6/i18n/ko.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/plupload/2.3.6/jquery.plupload.queue/jquery.plupload.queue.min.js') }}"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js') }}" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
        
    $(function(){
        $('.datepicker').datepicker();

        tinymce.init({
            selector:'#create_form_content',
            cache_suffix: '?v=4.5.8',
            theme: 'modern',
            language: 'ko_KR',
            plugins: 'print link lists advlist table charmap emoticons fullscreen nonbreaking image media autolink searchreplace textpattern textcolor colorpicker code contextmenu',
            menubar: false,
            toolbar_items_size: 'small',
            toolbar1: "newdocument | undo redo | cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | link unlink image media table nonbreaking charmap emoticons | code print fullscreen",
            toolbar2: "bold underline italic strikethrough forecolor backcolor superscript subscript | removeformat | alignleft aligncenter alignright alignjustify | formatselect fontselect fontsizeselect",
            font_formats: '맑은고딕=맑은고딕,Malgun Gothic;돋움체=돋움체,DotumChe,AppleGothic;바탕=바탕,Batang,AppleMyungjo;궁서=궁서,Gungsuh,GungSeo;Arial=Arial;Tahoma=Tahoma;Times New Roman=Times New Roman;Verdana=Verdana;Courier New=Courier New;나눔고딕=나눔고딕,NanumGothic;나눔명조=나눔명조,NanumMyeongjo;나눔고딕코딩=나눔고딕코딩,NanumGothicCoding;나눔바른고딕=나눔바른고딕,NanumBarunGothic,NanumBarunGothicOTF;나눔바른펜=나눔바른펜,NanumBarunpen;',
            image_advtab: true,
            setup: function (editor) {
                editor.on('init', function(e) {
                    $(editor.iframeElement.contentDocument).find('html').css('width', 'unset').css('height', 'unset').css('padding', '10px');
                });
                editor.on('change', function () {
                    editor.save();
                    $('#' + editor.id).valid();
                });
            },
            path_absolute : '/',
            relative_urls: false,
            file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = '{{ route('unisharp.lfm.show') }}?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : '파일 탐색기',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });
            },
            content_css: [
                '/vendor/plupload/2.3.6/jquery.plupload.queue/css/jquery.plupload.queue.css',
                '/vendor/jquery-datetimepicker/2.5.14/jquery.datetimepicker.min.css',
            ]
        });

        $('#plupload').pluploadQueue({
            runtimes : 'html5,flash',
            flash_swf_url : '/script/Moxie.swf',
            silverlight_xap_url : '/script/Moxie.xap',
            url : '{{ route('file.upload', $bbs_name) }}',
            dragdrop: true,
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            filters : {
                max_file_size : '20mb'
            },
            init: {
                PostInit: function(up) {
                    $(up.getOption('container')).find('.plupload_button.plupload_start').hide();
                },
                Error: function (up, err) {
                    if (err.code === plupload.HTTP_ERROR) {
                        up.stop();
                        alert('파일 업로드 에러 - ' + err.message);
                    }
                },
                FileUploaded: function (up, file, info) {
                    var data = JSON.parse(info.response);

                    if (data.stored_path !== undefined) {
                        var file_index = $('#' + file.id).index();
                        $('#plupload').append('<input type="hidden" name="plupload_' + file_index + '_stored_path" value="' + data.stored_path + '" />');
                    }
                }
            }
        });

        $('#create-form').validate({
        ignore: [],
        onkeyup:false,
        rules: {
            subject: {
                required: true
            },
            gubun: {
                required: true
            },
            date_type: {
                required: true
            },
            sdate: {
                required: true
            },
            edate: {
                required: {
                    depends: function () {
                        return $("#date_type_l").is(":checked")
                    }
                }
            },

        },
        messages: {
            'subject': {
                'required': '행사명을 입력해주세요.',
            },
            'gubun': {
                'required': '행사구분을 선택해주세요.',
            },
            'date_type': {
                'required': '행사기간을 선택해주세요.',
            },
            'sdate': {
                'required': '행사기간을 선택해주세요.',
            },
            'edate': {
                'required': '행사기간을 선택해주세요.',
            },
        },
        errorElement: 'p',
        errorClass: 'note clear error',
        validClass: 'note clear valid',
        errorPlacement: function (label, element) {
            label.appendTo($(element).closest('td'));
        },
        highlight: function (element, errorClass) {
            //
        },
        unhighlight: function (element, errorClass) {
            //
        },
        submitHandler: function(form) {

            if( $("input[name=swalBool]").val() != 'true' ){
                var swalMsg = <?= json_encode(config('site.swal.check'))?>;
                var swaltitle = swalMsg[$(form).attr('tType')];
                swalYesOrNo( swaltitle, form.id );
                return false;
            } 

            $(form).find('input[type=submit]').prop('disabled', true);

            var $plupload_queue = $('#plupload').pluploadQueue();
            if ($plupload_queue.files.length > 0) {
                $plupload_queue.bind('UploadComplete', function(up, files) {
                    if ($plupload_queue.total.failed === 0) {
                        $(form).find('input[type=submit]').prop('disabled', false);
                        form.submit();
                    }
                });

                $plupload_queue.start();
            } else {
                form.submit();
            }

            return false;
        }
    });

    });

    $.datepicker.setDefaults({
        dateFormat: 'yy-mm-dd',
        prevText: '이전 달',
        nextText: '다음 달',
        monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        dayNames: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        showMonthAfterYear: true,
        yearSuffix: '년'
    });

</script>
@endpush
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="formArea bbsWrite">
        <form id="create-form" name="create-form" action="{{ route('bbs.update', ['bbs_name' => $bbs_name, 'sid' => $bbsTbl->sid]) }}" method="post" tType="U">
            @csrf
            <input type="hidden" name="sid" value="{{ $bbsTbl->sid }}">
            <input type="hidden" name="swalBool" value="false">
            <fieldset>
                <legend>등록</legend>
                <table class="inputTbl">
                    <colgroup>
                        <col style="width:15%;">
                        <col style="width:*;">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th><label for="" class="essen" title="필수">행사명</label></th>
                        <td class="multi">
                            <input name="subject" id="subject" type="text" style="width:calc(100% - 145px);" value="{{ $bbsTbl->subject }}">
                            <input type="checkbox" name="push" id="push" value="Y" @if( $bbsTbl->push == 'Y') checked @endif;><label for="">메인 Push</label>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="" class="essen" title="필수">구분</label></th>
                        <td>
                            @foreach( config('site.bbs_param.s_gubun') as $key => $val )
                            <input type="radio" name="gubun" id="gubun{{$key}}" value="{{$key}}" {{ $bbsTbl->gubun == $key ? 'checked' : '' }}>
                            <label for="gubun{{$key}}">{{$val}}</label>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th><span class="essen" title="필수">행사기간</span></th>
                        <td class="multi">
                            @foreach( config('site.bbs_param.s_date_type') as $key => $val )
                            <input type="radio" name="date_type" id="date_type{{$key}}" value="{{$key}}" {{ $bbsTbl->date_type == $key ? 'checked' : '' }}>
                            <label for="date_type{{$key}}">{{$val}}</label>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th><span class="essen" title="필수">행사일</span></th>
                        <td class="date">
                            <input type="text" name="sdate" id="sdate" class="datepicker" readonly value="{{ $bbsTbl->sdate }}">
                            <input type="image" src="/image/icon/calendar.png" alt="달력">
                            <span>~</span>
                            <input type="text" name="edate" id="edate" class="datepicker" readonly value="{{ $bbsTbl->edate }}">
                            <input type="image" src="/image/icon/calendar.png" alt="달력">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="" class="" title="필수">장소</label></th>
                        <td>
                            <input name="place" id="place" type="text" style="width:100%;" value="{{ $bbsTbl->place }}">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="">주최</label></th>
                        <td>
                            <input name="sponsor" id="sponsor" type="text" style="width:100%;" value="{{ $bbsTbl->sponsor }}">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="">문의처</label></th>
                        <td>
                            <input name="inquiry" id="inquiry" type="text" style="width:100%;" value="{{ $bbsTbl->inquiry }}">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="">Link URL</label></th>
                        <td>
                            <input name="linkurl" id="linkurl" value="{{ $bbsTbl->linkurl }}" type="text" style="width:100%;">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="">첨부파일</label></th>
                        <td class="pluginArea" colspan="2">
                            @foreach($bbsTbl->bbs_files as $files)
                                @if( $files->type != 9 )
                                    <label for="edit_form_delete_files_{{ $files->id }}" class="lm0 tm5 bm5" style="display: block;">
                                        <input type="checkbox" id="edit_form_delete_files_{{ $files->sid }}" name="delete_files[]" value="{{ $files->sid }}">
                                        삭제 - <img src="{{ $files->getIconUrl() }}" alt="" /> {{ $files->filename }}
                                    </label>
                                @endif
                            @endforeach
                            <div id="plupload"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div class="btnArea btn">
                    <input type="submit" value="수정" class="upload">
                    <input type="button" value="취소" class="btnReset" onclick="location.href='{{ route('bbs.calender', ['bbs_name' => 'schedule']) }}'">
                </div>
            </fieldset>
        </form>
    </div>

    <div class="mobileNote">
        <img src="/image/common/pcOnly.png" alt="해당 메뉴는 PC에서만 서비스 가능합니다.">
    </div>

@endsection

