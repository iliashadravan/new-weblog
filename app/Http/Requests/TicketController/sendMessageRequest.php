<?php

namespace App\Http\Requests\TicketController;

use App\Http\Requests\Request;

class sendMessageRequest extends Request
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
            'message'   => 'required|string',
            'parent_id' => 'nullable|exists:ticket_messages,id'
        ];
    }
}
