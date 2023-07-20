<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListadoDeVideosRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'limit'=>'integer|max:50|min:1',
            'page'=>'integer|min:1'
        ];
    }
    public function getLimit():int
    {
        return $this->get('limit', 30);
    }
    public function getPage():int
    {
        return $this->get('page',1);
    }

    public function getOffset():int
    {
        return ($this->getPage()-1) *$this->getLimit();
    }
}
