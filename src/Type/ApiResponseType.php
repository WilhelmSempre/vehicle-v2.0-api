<?php
declare(strict_types=1);

namespace App\Type;

class ApiResponseType
{
    const JSON = 'json';
    const XML = 'xml';

    public function getTypes(): array
    {
        return [
            self::JSON,
            self::XML,
        ];
    }
}