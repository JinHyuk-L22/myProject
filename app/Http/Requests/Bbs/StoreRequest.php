<?php

namespace App\Http\Requests\Bbs;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [];
        if( $this->route()->parameter('bbs_name') == 'general' ){
            $rules['title']             = ['required', 'max:255'];
            $rules['is_pop']            = ['required', 'max:1'];
            $rules['status']            = ['required', 'max:1'];
            $rules['content']           = ['required'];
            if( $this->post('is_pop') == 'Y' ){
                $rules['template']          = ['required', 'max:1'];
                $rules['pop_content_type']  = ['required', 'max:1'];
                $rules['pop_size_w']        = ['required', 'integer'];
                $rules['pop_size_h']        = ['required', 'integer'];
                $rules['pop_size_x']        = ['required', 'integer'];
                $rules['pop_size_y']        = ['required', 'integer'];
                $rules['pop_detail']        = ['required', 'max:1'];
                $rules['pop_resize']        = ['required', 'max:1'];
                $rules['pop_sdate']         = ['required', 'date', 'before_or_equal:pop_edate'];
                $rules['pop_edate']         = ['required', 'date', 'after_or_equal:pop_sdate'];
            }
        } else if( $this->route()->parameter('bbs_name') == 'schedule' ){
            $rules['subject']       = ['required', 'max:255'];
            $rules['gubun']         = ['required'];
            $rules['date_type']     = ['required'];
            if( $this->post('date_type') == 'L' ){
                $rules['sdate']         = ['required', 'date', 'before_or_equal:edate'];
                $rules['edate']         = ['date', 'after_or_equal:sdate'];
            } else {
                $rules['sdate']         = ['required', 'date'];
            }
            $rules['place']         = ['max:255'];
            $rules['sponsor']       = ['max:255'];
            $rules['inquiry']       = ['max:255'];
            $rules['linkurl']       = ['max:255'];
        }

        return $rules;

    }

    public function messages()
    {

        return [
            'required'              => ':attribute 입력해주세요.'
            , 'max'                 => ':attribute 항목을 :max 이내로 입력해주세요.'
            , 'integer'             => ':attribute 항목은 정수만 입력 가능합니다.' 
            , 'before_or_equal'     => ':attribute 종료일 이전 날짜로 입력해주세요.'
            , 'after_or_equal'      => ':attribute 시작일 이후 날짜로 입력해주세요.'
        ];
    }

}
