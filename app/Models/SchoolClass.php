<?php

namespace App\Models;

use Dotenv\Util\Str;
use Exception;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use JsonSerializable;

class SchoolClass implements JsonSerializable
{
    public function jsonSerialize() {
        return $this->toNormal();
    }

    public static function validateNormal($normalNotation)
    {
        return (bool) preg_match('/^(([1-4]\.[A-D]4)|([1-8]\.[A-D]))$/', $normalNotation);
    }

    public static function validateYear($yearNotation)
    {
        return (bool) preg_match('/^\d{4}\.[A-Z]4?$/', $yearNotation);
    }

    public int $year;
    public string $letter;
    public bool $isFourYear;

    public function __construct($string)
    {
        $this->isFourYear = str_ends_with($string, "4");

        if(self::validateYear($string) === true) {
            $this->year = (int) substr($string, 0, 4);
            $this->letter = $string[5];
        }
        elseif(self::validateNormal($string) === true) {

            $schoolYearsUntilMaturita = ($this->isFourYear? 4 : 8) - (int) $string[0] + ( now()->month >= 9 ? 1 : 0) ;
            $this->year = now()->year + $schoolYearsUntilMaturita;
            $this->letter = $string[2];
        }
        else throw new Exception("Invalid class string: cannot convert '{$string}' to school class");
    }

    public function isInSchool()
    {
        return $this->yearsToMaturita() >= 0;
    }

    private function yearsToMaturita()
    {
        return $this->year - now()->year - ( now()->month >= 9 ? 1 : 0);
    }

    public function toNormal()
    {
        if($this->isInSchool() === false) return $this->toYear();

        $year = ($this->isFourYear? 4 : 8) - $this->yearsToMaturita();
        return $year . "." . $this->letter . ($this->isFourYear? "4" : "");
    }

    public function toYear()
    {
        return $this->year . "." . $this->letter . ($this->isFourYear? "4" : "");
    }

    public function __toString()
    {
        return $this->toNormal();
    }
}
