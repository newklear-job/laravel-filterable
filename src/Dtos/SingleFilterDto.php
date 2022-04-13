<?php

namespace Filterable\Dtos;

use Illuminate\Support\Facades\Validator;

final class SingleFilterDto
{
    private function __construct(
        private string $name,
        private mixed  $value,
    ) {
    }

    public static function create($name, $value)
    {
        self::validate(get_defined_vars());
        return new self (
            name : $name,
            value: $value,
        );
    }

    private static function validate(array $args): void
    {
        Validator::validate(
            $args, [
                     'name'  => ['required', 'string', 'max:255'],
                     'value' => [
                         'nullable',
                     ],
                 ]

        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}
