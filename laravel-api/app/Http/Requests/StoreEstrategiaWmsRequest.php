<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreEstrategiaWmsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dsEstrategia' => 'required|string|max:255',
            'nrPrioridade' => 'required|integer|min:1',
            'horarios' => 'required|array',
            'horarios.*.dsHorarioInicio' => 'required|string|date_format:H:i',
            'horarios.*.dsHorarioFinal' => 'required|string|date_format:H:i|after:horarios.*.dsHorarioInicio',
            'horarios.*.nrPrioridade' => 'required|integer'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'successo'   => 'false',
            'mensagem'   => 'Validação de erros',
            'erros'      => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório!',
            'integer' => 'O campo :attribute deve ser um número inteiro!',
            'min' => 'O campo :attribute deve ser pelo menos :min.',
            'array' => 'O campo :attribute deve ser um array!',
            'after' => 'O campo :attribute deve ser posterior ao Horário de Início.',
            'date_format' => 'O campo :attribute não corresponde ao formato :format.',
        ];
    }
}
