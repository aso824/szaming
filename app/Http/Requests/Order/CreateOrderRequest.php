<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'shop' => 'required',
            'orders' => 'required|array|min:1|max:50',
            'orders.*.name' => 'required|max:50',
            'orders.*.price' => 'required|numeric|min:0',
            'orders.*.quantity' => 'required|numeric|min:1',
            'orders.*.people' => 'required|array|min:1|max:20',
            'orders.*.people.*' => 'integer|exists:users,id',
        ];
    }
}
