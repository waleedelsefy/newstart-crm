<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use HasFactory;

    public function __get($value)
    {
        if ($value == 'shortDescription' && isset($this->getAttribute('data')['description'][app()->getLocale()])) {
            return $this->getAttribute('data')['description'][app()->getLocale()][0];
        }

        if (isset($this->getAttribute('data')[$value])) {
            if (isset($this->getAttribute('data')[$value][app()->getLocale()])) {

                if ($value == 'description') {
                    return implode('<br/>', $this->getAttribute('data')[$value][app()->getLocale()]);
                }

                return $this->getAttribute('data')[$value][app()->getLocale()];
            }

            return  $this->getAttribute('data')[$value];
        }


        return $this->getAttribute($value);
    }
}
