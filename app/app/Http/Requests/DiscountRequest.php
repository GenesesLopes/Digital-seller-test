<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;

class DiscountRequest extends FormRequest
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
            'email' => 'required|email:filter'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = User::where('email', $this->email)->first();
            /**Verificando deadline de cupons */
            if (!is_null($user)) {
                $user_discounts = $user->discounts()->wherePivotNull('updated_at')->first();
                if ($user_discounts !== null) {
                    if (date("Y-m-d H:i:s", strtotime($user_discounts->pivot->deadline)) >= date("Y-m-d H:i:s", strtotime("now")))
                        $validator->errors()->add('cupom', "Você ainda possui o cupom {$user_discounts->pivot->cupom} válido");
                }
            }
        });
    }
}
