<?php

namespace Filterable;

use Filterable\Dtos\SingleFilterDto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class QueryFilter
{
    protected Builder $builder;
    private array $filters;

    public function __construct()
    {
    }

    /**
     * @param $filters SingleFilterDto[]
     */
    public function setFilters(array $filters)
    {
        $this->filters = $filters;
        return $this;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder; // all filters are applied to this builder.

        foreach ($this->filters as $singeFilterData) {
            $method = Str::camel($singeFilterData->getName());
            if (method_exists($this, $method)) {
                $this->$method($singeFilterData->getValue());
            }
        }
    }
}

