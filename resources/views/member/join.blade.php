@extends('layouts.home')

@push('styles')
    <link type="text/css" rel="stylesheet" href="{{ asset( mix('/css/join.css') )}}">
@endpush

    @section('content')
    <div class="wrapper">
        @include('layouts.partials.header')
			
        <div class="contents">
			
            <div class="join">
                <ul class="joinStep">
                    <li class="on">
                        <span>
                            <span>Step 01</span>
                            약관동의
                        </span>
                    </li>
                    <li>
                        <span>
                            <span>Step 02</span>
                            정보입력
                        </span>
                    </li>
                    <li>
                        <span class="noBg">
                            <span>Step 03</span>
                            가입완료
                        </span>
                    </li>
                </ul>

                <h3 class="hidden">Step01 약관동의</h3>
                
                <form action="/member/join/step02.php" method="post" onsubmit="return check_step01(this)">
                    <fieldset>
                        <legend>약관동의</legend>
                        
                        <div class="agree fl agreeflim">
                            <h4 class="borderTit">대한치과보존학회 회원가입 약관</h4>
                            
                            <div class="agreeCon">
                                <dl>
                                    <dt class="fwBold">제 3 장 회 원</dt>
                                    <dd>
                                        <dl>
                                            <dt>제 5 조</dt>
                                            <dd>
                                                <ul>
                                                    <li>① 본 회 회원은 취지에 찬동하는 치과의사로서 원에 의하고, 임원회의 결의로 입회할 수 있다.</li>
                                                    <li>② 본 회 회원은 취지에 찬동하는 치과대학 및 치의학전문대학원에 재학중인 학생으로서 원에 의하고, 임원회의 결과로 입회할 수 있다.</li>
                                                </ul>
                                            </dd>
                                            
                                            <dt>제 6 조</dt>
                                            <dd>본 회 입회를 원하는 자는 소정의 입회비를 납부하여야 한다.</dd>
                                            
                                            <dt>제 7 조</dt>
                                            <dd>
                                                <ul>
                                                    <li>① 본 회 회원은 본 회 소정의 회비를 납부하여 본 회 제반사업 및 회무에 협력할 의무가 있다.</li>
                                                    <li>② 단, 65세 이상의 회원은 회비를 면제한다.</li>
                                                </ul>
                                            </dd>
                                        </dl>
                                    </dd>
                                </dl>
                            </div>
                            <p>
                                <input name="agree1" id="agree1" type="checkbox"><label for="agree1">동의합니다.</label>
                            </p>								
                        </div>

                        
                        <div class="agree fr">
                            <h4 class="borderTit">개인정보 수집 및 활용 동의</h4>
                            <div class="agreeCon">
                                <dl>
                                    <dt class="fwBold">개인정보의 수집 및 이용목적</dt>
                                    <dd>대한치과보존학회가 회원님 개인의 정보를 수집하는 목적은 대한치과보존학회 사이트를 통하여 회원님께 최적의 맞춤화된 서비스를 제공해드리기 위한 것입니다. 대한치과보존학회는 각종의 학회 컨텐츠를 서비스해 드리고 있습니다. 이때 회원님께서 제공해주신 개인정보를 바탕으로 회원님께 보다 더 유용한 정보를 선택적으로 제공하는 것이 가능하게 됩니다. </dd>
                                    
                                    <dt class="fwBold">수집하는 개인정보의 항목</dt>
                                    <dd>대한치과보존학회는 회원가입 시 개인정보를 요구하고 있습니다. 회원님의 아이디(ID), 비밀번호, 이름(국문, 영문), 생년월일, 성별, 면허번호, E-mail 주소, 휴대전화번호, 우편물 수령지 주소 및 전화번호, E-mail 수신 동의, 학력 등을 필수입력 사항으로 수집하고 있습니다.</dd>
                                    
                                    <dt class="fwBold">개인정보의 보유 및 이용기간</dt>
                                    <dd>회원님이 대한치과보존학회가 제공하는 서비스를 받는 동안 회원님의 개인정보는 대한치과보존학회에서 계속 보유하며 서비스 제공을 위해 이용하게 됩니다. 회원님이 탈퇴를 요청할 경우 탈퇴요청과 동시에 가입 시 기재한 개인정보가 삭제됩니다.</dd>
                                </dl>
                            </div>
                            <p>
                                <input name="agree2" id="agree2" type="checkbox"><label for="agree2">동의합니다. </label>
                            </p>
                        </div>

                        <div class="btn">
                            <input value="회원가입" class="" type="submit" />
                        </div>
                        </fieldset>
                </form>


            </div>
            <!-- //join -->
        
        </div>
		

			<p id="goTop"><a href="#">TOP</a></p>
        </div> <!-- //contentsWrap -->
		
    @endsection