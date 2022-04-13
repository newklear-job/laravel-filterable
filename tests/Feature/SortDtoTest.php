<?php

use Filterable\Dtos\SortDto;

uses(\Tests\FeatureTestCase::class);

test('SortDto is created', function () {
    $dto = SortDto::create(
        'test',
        'asc',
    );
    expect($dto)->toBeInstanceOf(SortDto::class);
});

test('SortFto handles validation', function (array $data, array $errors) {
    $data = [
        $data['name'] ?? 1,
        $data['direction'] ?? 1,
    ];
    expect(fn() => SortDto::create(
        ...$data
    ))->toBeInvalid($errors);
})->with([
             'name is not set'              => [
                 [
                     'name' => '',
                 ],
                 [
                     'name' => 'required'
                 ]
             ],
             'direction is not set'         => [
                 [
                     'direction' => '',
                 ],
                 [
                     'direction' => 'required'
                 ]
             ],
             'direction is not asc or desc' => [
                 [
                     'direction' => 'abc',
                 ],
                 [
                     'direction' => 'invalid'
                 ]
             ],
         ]);

