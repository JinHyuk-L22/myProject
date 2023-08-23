@extends('layouts.home')
@section('content')
<script type="text/javascript">
    $(function () {
        $('#login-form').validate({
            rules: {
                'member_id': 'required',
                'password': 'required'
            },
            invalidHandler: function (event, validator) {
                if (validator.numberOfInvalids() > 0) {
                    var first_error = validator.errorList[0];

                    var name = first_error.element.getAttribute('name');

                    if (name === 'member_id') {
                        alert('아이디를 입력하세요.');
                        return false;
                    } else if (name === 'password') {
                        alert('비밀번호를 입력하세요.');
                        return false;
                    }
                }
            },
            errorPlacement: function (label, element) {
                //
            },
            success: function (label, element) {
                //
            },
            highlight: function (element, errorClass) {
                //
            },
            unhighlight: function (element, errorClass) {
                //
            }
        });
    });
</script>
    <div class="login">
        <div class="formArea">
            <h3>
                <img src="/image/sub/loginTIt.png" alt="">
                <strong>
                    <span class="fcBlue">ADMIN</span>LOGIN
                </strong>
            </h3>

            <form id="login-form" name="login-form" action="{{ route('member.login') }}" method="post">
                @csrf
                <fieldset>
                    <legend>로그인</legend>
                    <dl>
                        <dt><label for="">ID</label></dt>
                        <dd><input type="text" name="member_id" id="member_id" value="{{ old('member_id') }}"></dd>
                    </dl>
                    <dl>
                        <dt><label for="">PW</label></dt>
                        <dd><input type="password" name="password" id="password"></dd>
                    </dl>
                    <div class="btn"><input type="submit" name="" id="" value="LOGIN"></div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection
