<?php

namespace App\Traits;

trait FormatNumberTrait
{
    // Mutator untuk format angka
    public function setFormattedNumberAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = str_replace('.', '', $value);
    }

    // Accessor untuk format angka
    public function getFormattedNumberAttribute($value)
    {
        return number_format($value, 2, '.', '');
    }
}
