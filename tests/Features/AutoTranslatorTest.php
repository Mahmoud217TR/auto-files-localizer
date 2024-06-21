<?php

use Illuminate\Support\Facades\File;

it('testTranslationSavedToJson', function () {
    $sentance = 'Welcome';
    $locale = 'en';

    $translation = __($sentance);
    $this->assertEquals($sentance, $translation);

    $jsonPath = locale_json_file_path($locale);
    expect(File::exists($jsonPath))->toBe(true);

    $translations = json_decode(File::get($jsonPath), true);
    expect($sentance)->toEqual($translations[$sentance]);
});

it('testTranslationNotSavedToJson', function () {
    $sentance = 'Welcome :user';
    $locale = 'en';
    $alternativeLocale = 'ar';

    __($sentance, [], $alternativeLocale);

    $jsonPath = locale_json_file_path($locale);
    $translations = json_decode(File::get($jsonPath), true);
    expect(isset($translations[$sentance]))->toBe(false);
});
