<?php

namespace Filterable\Dtos;

use Illuminate\Support\Facades\Validator;

final class FilterDto
{
    /* @var SingleFilterDto [] $filters */
    private function __construct(
        private array         $filters,
        private PaginationDto $pagination,
        private ?SortDto      $sort,
    ) {
    }

    public static function createFromArrayBag(array $requestBag)
    {
        $orderBy = $requestBag[self::orderByParam()] ?? null;
        $orderByDirection = $requestBag[self::orderByDirectionParam()] ?? 'asc';
        $page = $requestBag[self::pageParam()] ?? config('filterable.page');
        $perPage = $requestBag[self::perPageParam()] ?? config('filterable.perPage');

        unset(
            $requestBag[self::orderByParam()],
            $requestBag[self::orderByDirectionParam()],
            $requestBag[self::pageParam()],
            $requestBag[self::perPageParam()],
        );
        $filters = $requestBag;
        $singleFilters = [];

        foreach ($filters as $filterName => $filterValue) {
            $singleFilters [] = SingleFilterDto::create($filterName, $filterValue);
        }

        return new self (
            filters   : $singleFilters,
            pagination: PaginationDto::create($page, $perPage),
            sort      : $orderBy ? SortDto::create($orderBy, $orderByDirection) : null
        );
    }

    private static function orderByParam(): string
    {
        return config('filterable.queryParam.orderBy', 'orderBy');
    }

    private static function orderByDirectionParam(): string
    {
        return config('filterable.queryParam.orderByDirection', 'orderByDirection');
    }

    private static function pageParam(): string
    {
        return config('filterable.queryParam.page', 'page');
    }

    private static function perPageParam(): string
    {
        return config('filterable.queryParam.perPage', 'perPage');
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getPagination(): PaginationDto
    {
        return $this->pagination;
    }

    public function getSort(): ?SortDto
    {
        return $this->sort;
    }
}
