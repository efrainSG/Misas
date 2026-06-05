<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Validation\ValidationRule;

class ServiceResponse
{
    public function __construct(
        public bool $success,
        public string $message,
        public mixed $data = null,
        public int $status = 200,
        public ?float $execution_time_ms = null
    ) {}
}
