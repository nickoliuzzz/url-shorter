<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class JsonValidationException extends ValidationException
{
    public function render(Request $request)
    {
        return response()->json([
            'errors' => $this->errors(),
        ], $this->status);
    }
}
