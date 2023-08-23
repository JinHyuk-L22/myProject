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
    $(function () {

        if( $("input[name=is_pop]:checked").val() == 'Y' ){
            $(".popUpTrs").show();
        } else {
            $(".popUpTrs").hide();
        }

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

                var cmsURL = "{{route('unisharp.lfm.show')}}?field_name=' + field_name";
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
                "{{ asset('/vendor/plupload/2.3.6/jquery.plupload.queue/css/jquery.plupload.queue.css') }}",
                "{{ asset('/vendor/jquery-datetimepicker/2.5.14/jquery.datetimepicker.min.css') }}",
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
                title: {
                    required: true
                },
                is_pop: {
                    required: true
                },
                template: {
                    required: {
                        depends: function () {
                            return $('input[name=template]').is(':checked');
                        }
                    }
                },
                pop_size_w: {
                    required: {
                        depends: function () {
                            return $('#is_popY').is(':checked');
                        }
                    },
                    digits: {
                        depends: function () {
                            return $('#is_popY').is(':checked');
                        }
                    },
                    min: {
                        param: 500,
                        depends: function () {
                            return $('#is_popY').is(':checked');
                        }
                    }
                },
                pop_size_h: {
                    required: {
                        depends: function () {
                            return $('#is_popY').is(':checked');
                        }
                    },
                    digits: {
                        depends: function () {
                            return $('#is_popY').is(':checked');
                        }
                    },
                    min: {
                        param: 400,
                        depends: function () {
                            return $('#is_popY').is(':checked');
                        }
                    }
                },
                pop_size_y: {
                    required: {
                        depends: function () {
                            return $('#is_popY').is(':checked');
                        }
                    },
                    digits: {
                        depends: function () {
                            return $('#is_popY').is(':checked');
                        }
                    },
                    min: {
                        param: 500,
                        depends: function () {
                            return $('#is_popY').is(':checked');
                        }
                    }
                },
                pop_size_x: {
                    required: {
                        depends: function () {
                            return $('#is_popY').is(':checked');
                        }
                    },
                    digits: {
                        depends: function () {
                            return $('#is_popY').is(':checked');
                        }
                    },
                    min: {
                        param: 400,
                        depends: function () {
                            return $('#is_popY').is(':checked');
                        }
                    }
                },
                pop_sdate: {
                    required: {
                        depends: function () {
                            return $('#is_popY').is(':checked');
                        }
                    },
                },
                pop_edate: {
                    required: {
                        depends: function () {
                            return $('#is_popY').is(':checked');
                        }
                    },
                },
                content: {
                    required: true
                },

            },
            groups: {
                popup_size: 'popup_width popup_height popup_position_top popup_position_left',
                popup_term: 'popup_term_start popup_term_end'
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

        $('#create-form input[name=popup_is_same_content]').on('click change', function () {
            var use_popup = $('#create-form input[name=use_popup]:checked').val() + '' === '1';
            var is_same_content = $('#create-form input[name=popup_is_same_content]:checked').val() + '' === '1';

            $('#create-form tr.popup_content_tr').css('display', (use_popup && !is_same_content) ? '' : 'none').find('textarea').prop('disabled', !(use_popup && !is_same_content));
            $('#create-form [name=popup_content]').valid();
        });

        $('#create-form input[name=use_popup]').on('click change', function () {
            var use_popup = $('input[name=use_popup]:checked').val() + '' === '1';

            $('#create-form tr.popup').css('display', use_popup ? '' : 'none').find('input').prop('disabled', !use_popup);
            $('#create_form_popup_is_same_content_1').change();
        }).change();

        $('#create-form .popup_preview').click(function () {
            var create_form = $(this).closest('form');
            var preview_form = $('#popup-preview-form');

            if( $('input[name=pop_content_type]:checked').val() == '0' ){
                if( !$("#create_form_content").val() ){
                    alert('내용을 입력해 주세요.');
                    return false;
                    }
            } else {
                if( !$("#create_form_content_pop").val() ){
                    alert('내용을 입력해 주세요.');
                    return false;
                }
            }
                

            preview_form.find('input[type="text"], textarea').val('');

            var popup_position_top = create_form.find('[name="pop_size_y"]').val();
            var popup_position_left = create_form.find('[name="pop_size_x"]').val();
            var popup_width = create_form.find('[name="pop_size_w"]').val();
            var popup_height = create_form.find('[name="pop_size_h"]').val();

            preview_form.find('[name="post_title"]').val(create_form.find('[name="title"]').val());
            preview_form.find('[name="popup_skin"]').val(create_form.find('[name="template"]:checked').val());
            preview_form.find('[name="popup_width"]').val(popup_width);
            preview_form.find('[name="popup_height"]').val(popup_height);
            preview_form.find('[name="popup_position_top"]').val(popup_position_top);
            preview_form.find('[name="popup_position_left"]').val(popup_position_left);
            preview_form.find('[name="popup_use_detail_btn"]').val(create_form.find('[name="pop_detail"]:checked').val());
            preview_form.find('[name="popup_detail_link"]').val('#');
            preview_form.find('[name="popup_term_start"]').val(create_form.find('[name="pop_sdate"]').val());
            preview_form.find('[name="popup_term_end"]').val(create_form.find('[name="pop_edate"]').val());

            if (create_form.find('[name="pop_content_type"]:checked').val() + '' == '1') {
                preview_form.find('[name="popup_content"]').val(create_form.find('[name="pop_content"]').val());
            } else {
                preview_form.find('[name="popup_content"]').val(create_form.find('[name="content"]').val());
            }

            window.on_popup_window_resize = function (popup_w) {
                var width = popup_w.innerWidth || popup_w.document.documentElement.clientWidth || popup_w.document.getElementsByTagName('body')[0].clientWidth;
                var height = popup_w.innerHeight|| popup_w.document.documentElement.clientHeight|| popup_w.document.getElementsByTagName('body')[0].clientHeight;

                create_form.find('[name="pop_size_w"]').val(width);
                create_form.find('[name="pop_size_h"]').val(height);
            };

            var openParam = 'width=' + popup_width + ',height=' + popup_height + ',top=' + popup_position_top + ',left=' + popup_position_left + ',scrollbars=no';
            window.open('', preview_form.attr('target'), openParam);
            preview_form.submit();
        });


        $("input[name=is_pop]").change(function(){
            if( $(this).val() == 'Y' ){
                $(".popUpTrs").show();
            } else {
                $(".popUpTrs").hide();
            }
        });

        $(".datepicker").datepicker({
            changeYear: true, // 년 박스
            changeMonth: true, // 월 박스
            yearRange: 'c-100:c+10', // 현재 기준 표시 범위
            dateFormat: "yy-mm-dd", // 입력 형식
            showMonthAfterYear: true , // 연월순. 
            dayNamesMin: ['월', '화', '수', '목', '금', '토', '일'], // 요일 포멧.
            monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'] // 월 포멧.
        });
    });

</script>
@endpush

@section('content')
<form id="popup-preview-form" target="popup_preview" method="post" action="{{ route('popup.preview') }}" style="display: none;">
    @csrf

    <input type="text" name="post_title" value="" />
    <input type="text" name="popup_skin" value="" />
    <input type="text" name="popup_width" value="" />
    <input type="text" name="popup_height" value="" />
    <input type="text" name="popup_position_top" value="" />
    <input type="text" name="popup_position_left" value="" />
    <input type="text" name="popup_use_detail_btn" value="" />
    <input type="text" name="popup_detail_link" value="" />
    <input type="text" name="popup_term_start" value="" />
    <input type="text" name="popup_term_end" value="" />
    <textarea name="popup_content"></textarea>
</form>

<div class="formArea bbsWrite">
        <form id="create-form" method="post" action="{{ route('bbs.store', ['bbs_name' => $bbs_name]) }}" tType="C">
            @csrf
            <input type="hidden" name="bbs_name" value="{{$bbs_name}}">
            <input type="hidden" name="user_id" value="{{ Auth::user()->member_id }}">
            <input type="hidden" name="name" value="{{ Auth::user()->name }}">
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
                        <th>작성자</th>
                        <td>{{ Auth::user()->member_id }}</td>
                    </tr>
                    <tr>
                        <th><label for="" class="essen" title="필수">제목</label></th>
                        <td class="multi">
                            <input name="title" id="title" type="text" style="width:calc(100% - 145px);" value="{{ old('title') }}">
                            @foreach( config('site.bbs_param.noticePushType') as $key => $val )
                            <label for="{{ $key }}">
                                <input type="checkbox" name="{{ $key }}" id="{{ $key }}" value="Y" {{ old($key) ? 'checked' : '' }}>{{ $val }}
                            </label>
                            @endforeach
                            @if( $errors->has('title') )
                            <p id="title-error" class="error note clear"> 
                                @foreach( $errors->get('title') as $key => $val )
                                    {{ $val }}
                                @endforeach
                            </p>
                            @endif
                        </td>
                    </tr>
                    <!-- <tr>
                        <th><label for="" class="essen" title="필수">이메일</label></th>
                        <td>
                            <input name="email" id="email" value="" type="text" style="width:100%;">
                        </td>
                    </tr> -->
                    <tr>
                        <th>팝업설정</th>
                        <td class="multi">
                            @foreach( config('site.bbs_param.is_pop') as $key => $val )
                                <input type="radio" name="is_pop" id="is_pop{{ $key }}" value="{{ $key }}" {{ old('is_pop') == $key ? 'checked' :  $key == 'N' && old('is_pop') != 'Y' ? 'checked' : '' }}><label for="is_pop{{ $key }}">{{ $val }}</label>
                            @endforeach
                        </td>
                    </tr>
                    <tr class="popUpTrs" style="display: none;">
                        <th>팝업 템플릿</th>
                        <td class="multi">
                            @foreach( config('site.bbs_param.template') as $key => $val )
                                <input type="radio" name="template" id="template{{ $key }}" value="{{ $key }}" {{ old('template') == $key ? 'checked' : '' }}><label for="template{{ $key }}">{{ $val }}</label>
                            @endforeach
                            <span class="btn lm30">
                                <a href="javascript:void(0);" class="btnGrey btnSmall popup_preview" style="width:100px;">팝업 미리보기</a>
                            </span>
                        </td>
                    </tr>
                    <tr class="popUpTrs" style="display: none;">
                        <th><label for="">팝업 내용 선택</label></th>
                        <td class="multi">
                            @foreach( config('site.bbs_param.pop_content_type') as $key => $val )
                                <input type="radio" name="pop_content_type" id="pop_content_type{{ $key }}" value="{{ $key }}" {{ old('pop_content_type') == $key ? 'checked' :  $key == 'N' && old('pop_content_type') != 'Y' ? 'checked' : '' }}><label for="pop_content_type{{ $key }}">{{ $val }}</label>
                            @endforeach
                        </td>
                    </tr>
                    <tr class="popUpTrs" style="display: none;">
                        <th><label for="">팝업 사이즈</label></th>
                        <td class="multi">
                            <ul class="popSize">
                                <li>
                                    <label for="">사이즈 :</label>
                                    <input type="text" name="pop_size_w" id="pop_size_w" value="{{ empty( old('pop_size_w') ) ? 500 : old('pop_size_w') }}"><span>X</span>
                                    <input type="text" name="pop_size_h" id="pop_size_h" value="{{ empty( old('pop_size_h') ) ? 400 : old('pop_size_h') }}"> <span class="note" style="width: 400px;">(500 x 400 이상 입력할 것! [팝업 미리보기]에서 창 크기 조절로 자동반영 가능)</span>
                                </li>
                                <li>
                                    <label for="">위치 :</label>
                                    <span style="width: 50px;">위에서 </span>
                                    <input type="text" name="pop_size_y" id="pop_size_y" value="{{ empty( old('pop_size_y') ) ? 500 : old('pop_size_y') }}"><span>px,</span>
                                    <span style="width: 75px;">왼쪽에서 </span>
                                    <input type="text" name="pop_size_x" id="pop_size_x" value="{{ empty( old('pop_size_x') ) ? 400 : old('pop_size_x') }}"><span>px</span>
                                </li>
                            </ul>
                            @if( $errors->has('pop_size_w') )
                            <p id="pop_size_w-error" class="error note clear">
                                @foreach( $errors->get('pop_size_w') as $key => $val )
                                    {{ $val }}
                                @endforeach
                            </p>
                            @endif
                            @if( $errors->has('pop_size_h') )
                            <p id="pop_size_h-error" class="note clear error">
                                @foreach( $errors->get('pop_size_h') as $key => $val )
                                    {{ $val }}
                                @endforeach
                            </p>
                            @endif
                            @if( $errors->has('pop_size_y') )
                            <p id="pop_size_y-error" class="note clear error">
                                @foreach( $errors->get('pop_size_y') as $key => $val )
                                    {{ $val }}
                                @endforeach
                            </p>
                            @endif
                            @if( $errors->has('pop_size_x') )
                            <p id="pop_size_x-error" class="error note clear">
                                @foreach( $errors->get('pop_size_x') as $key => $val )
                                    {{ $val }}
                                @endforeach
                            </p>
                            @endif
                        </td>
                    </tr>
                    <tr class="popUpTrs" style="display: none;">
                        <th><label for="">팝업 자세히 보기</label></th>
                        <td class="multi">
                            @foreach( config('site.bbs_param.pop_detail') as $key => $val )
                                <input type="radio" name="pop_detail" id="pop_detail{{ $key }}" value="{{ $key }}" {{ old('pop_detail') == $key ? 'checked' :  $key == 'N' && old('pop_detail') != 'Y' ? 'checked' : '' }}><label for="pop_detail{{ $key }}">{{ $val }}</label>
                            @endforeach
                        </td>
                    </tr>
                    <tr class="popUpTrs" style="display: none;">
                        <th><label for="">사이즈 변경</label></th>
                        <td class="multi">
                            @foreach( config('site.bbs_param.pop_resize') as $key => $val )
                                <input type="radio" name="pop_resize" id="pop_resize{{ $key }}" value="{{ $key }}" {{ old('pop_resize') == $key ? 'checked' :  $key == 'N' && old('pop_resize') != 'Y' ? 'checked' : '' }}><label for="pop_resize{{ $key }}">{{ $val }}</label>
                            @endforeach
                        </td>
                    </tr>
                    <tr class="popUpTrs" style="display: none;">
                        <th>팝업 시작일 / 종료일</th>
                        <td class="date">
                            @foreach( config('site.bbs_param.pop_date') as $key => $val )
                                <label for="">{{ $val['text']  }} : </label>
                                <input type="text" name="{{ $key }}" id="{{ $key }}" class="datepicker" readonly value="{{ old($key) }}">
                                <input type="image" src="{{ $val['img'] }}" alt="달력" onclick="return false;">
                            @endforeach
                            @if( $errors->has('pop_sdate') )
                            <p id="pop_sdate-error" class="error note clear">
                                @foreach( $errors->get('pop_sdate') as $key => $val )
                                    {{ $val }}
                                @endforeach
                            </p>
                            @endif
                            @if( $errors->has('pop_edate') )
                            <p id="pop_edate-error" class="error note clear">
                                @foreach( $errors->get('pop_edate') as $key => $val )
                                    {{ $val }}
                                @endforeach
                            </p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><span class="essen" title="필수">공개여부</span></th>
                        <td class="multi">
                            @foreach( config('site.bbs_param.status') as $key => $val )
                                <input type="radio" name="status" id="status{{ $key }}" value="{{ $key }}" {{ old('status') == $key ? 'checked' :  $key == 'N' && old('status') != 'Y' ? 'checked' : '' }}><label for="status{{ $key }}">{{ $val }}</label>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th><label for="">Link URL</label></th>
                        <td>
                            <input name="link_url" id="link_url" value="{{ old('link_url') }}" type="text" style="width:100%;">
                        </td>
                    </tr>
                    <tr>
                        <td class="pluginArea" colspan="2">
                            <textarea id="create_form_content" name="content" style="width:100%; height:300px;">{{ old('content') }}</textarea>

                            @if($errors->has('content'))
                                <p class="note clear error">

                                </p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="pluginArea" colspan="2">
                            <div id="plupload"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div class="btnArea btn">
                    <input type="submit" value="등록" class="upload">
                    <input type="button" value="취소" class="btnReset" onclick="location.href='{{ route('bbs.list', ['bbs_name' => $bbs_name]) }}'">
                </div>
            </fieldset>
        </form>
    </div>
@endsection