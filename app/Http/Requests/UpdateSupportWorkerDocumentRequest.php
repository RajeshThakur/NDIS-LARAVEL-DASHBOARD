<?php

namespace App\Http\Requests;

use App\SupportWorkerDocument;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSupportWorkerDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('support_worker_document_edit');
    }

    public function rules()
    {
        return [
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
        ];
    }
    
    
}
