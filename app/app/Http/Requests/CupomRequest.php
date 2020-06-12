<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Users_discont;
use Illuminate\Validation\Rule;


class CupomRequest extends FormRequest
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
        return [
            "cupom" => "required"
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            //caso a validação de nulo não passe
            if (!is_null($this->cupom)) {
                $cupom = Users_discont::where('cupom', $this->cupom)->first();
                if($cupom == null ){
                    $validator->errors()->add('cupom', "Cupom Inválido");
                }
                else if (!is_null($cupom->updated_at)) {
                    $validator->errors()->add('cupom', "O cupom {$cupom->cupom} Já foi utilizado");
                } else if (date("Y-m-d H:i:s", strtotime($cupom->deadline)) < date("Y-m-d H:i:s", strtotime("now"))) {
                    $validator->errors()->add('cupom', "Cupom fora do prazo de utilização");
                }
            }
        });
    }
}
