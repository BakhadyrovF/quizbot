<?php

namespace App\Utilities;

class ModelUtility
{
    /**
     * @param object $model
     * @return string
     */
    public static function getTranslatedText(object $model, string $propertyWithoutPostfix): string
    {
        $property = $propertyWithoutPostfix . '_' . app()->getLocale();
        return $model->$property;
    }
}
