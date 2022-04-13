<?php

namespace Filterable\Dtos;

use Illuminate\Support\Facades\Validator;

final class SortDto
{
    private function __construct(
        private string $name,
        private string $direction,
    ) {
    }

    public static function create($name, $direction)
    {
        self::validate(get_defined_vars());
        return new self (
            name     : $name,
            direction: $direction,
        );
    }

    private static function validate(array $args): void
    {
        Validator::validate(
            $args, [
                     'name'      => ['required', 'string'],
                     'direction' => ['required', 'string', 'in:asc,desc'],
                 ]

        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }
}
