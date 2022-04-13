<?php

use Filterable\Dtos\FilterDto;

uses(\Tests\FeatureTestCase::class);

test('FilterDto parses arguments bag', function () {
    $arguments = [
        config('filterable.queryParam.page')             => 2,
        config('filterable.queryParam.perPage')          => 15,
        config('filterable.queryParam.orderBy')          => 'sort name',
        config('filterable.queryParam.orderByDirection') => 'desc',
        'name'                                           => 'value',
        'ids'                                            => [1, 2, 3],
    ];

    $dto = FilterDto::createFromArrayBag($arguments);

    expect ($dto)
        ->toBeInstanceOf(FilterDto::class);

    expect($dto->getSort())
        ->getName()->toBe('sort name')
        ->getDirection()->toBe('desc');

    expect($dto->getPagination())
        ->getPage()->toBe(2)
        ->getPerPage()->toBe(15);

    expect($dto->getFilters())
        ->toBeArray()
        ->toHaveLength(2);

    expect($dto->getFilters()[0])
        ->getName()->toBe('name')
        ->getValue()->toBe('value');

    expect($dto->getFilters()[1])
        ->getName()->toBe('ids')
        ->getValue()->toBe([1, 2, 3]);
});

test('FilterDto sets default orderByDirection', function () {
    $arguments = [config('filterable.queryParam.orderBy')          => 'sort name',];
    $dto = FilterDto::createFromArrayBag($arguments);

    expect($dto->getSort())
        ->getDirection()->toBe(config('filterable.orderByDirection'));
});

test('FilterDto sets default values when no arguments are provided', function () {
    $arguments = [];
    $dto = FilterDto::createFromArrayBag($arguments);

    expect($dto->getSort())
        ->toBeNull();

    expect($dto->getPagination())
        ->getPage()->toBe(config('filterable.page'))
        ->getPerPage()->toBe(config('filterable.perPage'));

    expect($dto->getFilters())
        ->toBeArray()
        ->toHaveLength(0);
});
