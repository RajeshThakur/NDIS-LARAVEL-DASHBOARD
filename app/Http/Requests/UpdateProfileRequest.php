<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // return \Gate::allows('user_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'  => ['required'],
            'last_name'   => 'required',
            'email'       => 'required',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'business_name' => 'required',
            'organisation_id' => 'required',
            'ra_number' =>   'required',
            'renewal_date' => 'required',
            'parent_reg_group.*' => 'required|array',
            'state.*' => 'required| integer|not_in:0',
            // 'item.*.amount.*' => 'required| numeric',
            //'inhouse.*' => 'required| boolean',
            // 'ndis_cert' => ['required', 'file', 'max:5120'],
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required',
            'state.*' => 'At least 1 State required, where you are certified!',
            'state.required' => 'At least 1 State required, where you are certified!'
            // 'ndis_cert.required' => 'NDIS Certificate is required',
        ];
    }

    public function withValidator($validator)
    {
      
        // $validator->after(function ($validator) {
        //     // pr($this->all(),1);

        //     // pr($this->parent_reg_group);
        //     // pr($this->state);
        //     $parentStateSet = [];
            
        //     // create array of parent ans state to compare them with each other if same
        //     foreach( $this->parent_reg_group as $key=>$val ){
        //         $parentStateSet[$key] = [$this->parent_reg_group[$key], $this->state[$key]];
        //     }

        //     foreach( $parentStateSet as $key=>$val)
        //         for( $i=0; $i<sizeof($parentStateSet); $i++)
        //             if( $key != $i)
        //                 if( empty ( array_diff( $parentStateSet[$key], $parentStateSet[$i] ) ) )
        //                     $validator->errors()->add('field', 'You cannot select Registration group with same State more than once !');
            

        // });
    }
}
