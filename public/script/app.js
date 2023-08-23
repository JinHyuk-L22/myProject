$(function () {
    var token = $('html > head meta[name="csrf-token"]').get(0);
    if (token) {
        window.$.ajaxSetup({
            headers: {'X-CSRF-TOKEN': token.content}
        });
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }

    // $.validator.addMethod('notPattern', function (value, element, param) {
    //     return this.optional( element ) || !$.validator.methods.pattern.call( this, value, element, param );
    // }, 'Invalid different format.');
    //
    // $.validator.addMethod('notSameCharCon', function (value, element) {
    //     return this.optional( element ) || !/(\w)\1\1/.test( value );
    // }, '동일 문자를 연속으로 사용할 수 없습니다.');
    //
    // window.$.datetimepicker.setLocale('ko');
    //
    // $('.pageUtil a.font-size-down, .pageUtil a.font-size-up').click(function () {
    //     var change_size = (this.className === 'font-size-up') ? 1 : -1;
    //     $('.contents').css('font-size', parseInt($('.contents').css('font-size')) + change_size + 'px');
    // });
});
