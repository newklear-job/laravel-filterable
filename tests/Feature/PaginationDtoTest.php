<?php

use Filterable\Dtos\PaginationDto;

uses(\Tests\FeatureTestCase::class);

test('PaginationDto is  on created', function () {
    $dto = PaginationDto::create(
        2,
        2,
    );
    expect($dto)->toBeInstanceOf(PaginationDto::class);
});

test('PaginationDto handles validation', function (array $data, array $errors) {
    $data = [
        $data['page'] ?? 1,
        $data['perPage'] ?? 1,
    ];
    expect(fn() => PaginationDto::create(
        ...$data
    ))->toBeInvalid($errors);
})->with([
             'page is not set'         => [
                 [
                     'page' => '',
                 ],
                 [
                     'page' => 'required'
                 ]
             ],
             'page is not a number'    => [
                 [
                     'page' => 'abc',
                 ],
                 [
                     'page' => 'number'
                 ]
             ],
             'perPage is not set'      => [
                 [
                     'perPage' => '',
                 ],
                 [
                     'perPage' => 'required'
                 ]
             ],
             'perPage is not a number' => [
                 [
                     'perPage' => 'abc',
                 ],
                 [
                     'perPage' => 'number'
                 ]
             ],
         ]);

