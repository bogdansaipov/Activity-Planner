<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class ListEventsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'from' => 'required|date',
            'to'   => 'required|date|after_or_equal:from',
        ];
    }
}
