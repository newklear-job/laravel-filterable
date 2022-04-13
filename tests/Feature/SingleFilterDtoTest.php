<?php

use Filterable\Dtos\SingleFilterDto;

uses(\Tests\FeatureTestCase::class);

test('SingleFilterDto is created', function () {
    $dto = SingleFilterDto::create(
        'name',
        'value',
    );
    expect($dto)->toBeInstanceOf(SingleFilterDto::class)
                ->getName()->toBe('name')
                ->getValue()->toBe('value');
});

test('SingleFilterDto handles different types of value', function (array $data) {
    expect(
        SingleFilterDto::create(
            'name',
            $data['value'],
        )
    )->getValue()->toBe($data['value']);
})->with([
             'value is null'  => [
                 [
                     'value' => null,
                 ]
             ],
             'value is array' => [
                 [
                     'value' => [1, 2, 3]
                 ],
             ],
         ]);


test('SingleFilterDto handles validation', function (array $data, array $errors) {
    $data = [
        $data['name'] ?? 'name',
        $data['value'] ?? 'value',
    ];
    expect(fn() => SingleFilterDto::create(
        ...$data
    ))->toBeInvalid($errors);
})->with([
             'name is not set'       => [
                 [
                     'name' => '',
                 ],
                 [
                     'name' => 'required'
                 ]
             ],
             'name is > 255 symbols' => [
                 [
                     'name' => str_repeat('a', 256)
                 ],
                 [
                     'name' => '255'
                 ]
             ],
         ]);

