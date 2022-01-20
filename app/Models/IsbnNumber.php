<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Isbn\Isbn;
use JsonSerializable;

class IsbnNumber implements JsonSerializable
{
    public static function validate(string $isbn)
    {
        $instance = App::make(Isbn::class);
        return $instance->validation->isbn($isbn);
    }

    public static function make(string $unhyphenatedString)
    {
        if($unhyphenatedString === null) return null;
        return App::makeWith(IsbnNumber::class, ['unhyphenatedString' => $unhyphenatedString]);
    }

    private string $unhyphenatedString;
    private Isbn $isbnService;

    public function __construct(Isbn $isbnService, string $unhyphenatedString)
    {
        $this->isbnService = $isbnService;
        $this->unhyphenatedString = $unhyphenatedString;
    }

    public function __toString()
    {
        return $this->toUnhyphenatedString();
    }

    public function toUnhyphenatedString()
    {
        return $this->unhyphenatedString;
    }

    public function toHyphenatedString()
    {
        return $this->isbnService->hyphens->addHyphens($this->unhyphenatedString);
    }

    public function JsonSerialize()
    {
        return $this->toUnhyphenatedString();
    }


}
