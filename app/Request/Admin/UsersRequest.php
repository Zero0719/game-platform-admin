<?php

declare(strict_types=1);

namespace App\Request\Admin;

use Hyperf\Validation\Request\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->isMethod('delete') && $this->route('id') == 1) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        if ($this->isMethod('delete')) {
            return [];
        }

        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if ($this->route('id')) {
            unset($rules['password']);
        };

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'username' => '用户名',
            'password' => '密码'
        ];
    }
}
