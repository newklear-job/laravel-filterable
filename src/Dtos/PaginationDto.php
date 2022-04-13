<?php

namespace Filterable\Dtos;

use Illuminate\Support\Facades\Validator;

final class PaginationDto
{
    private function __construct(
        private int $page,
        private int $perPage,
    ) {
    }

    public static function create($page, $perPage)
    {
        self::validate(get_defined_vars());
        return new self (
            page   : $page,
            perPage: $perPage,
        );
    }

    private static function validate(array $args): void
    {
        Validator::validate(
            $args, [
                     'page'    => ['required', 'numeric'],
                     'perPage' => ['required', 'numeric'],
                 ]

        );
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }
}
