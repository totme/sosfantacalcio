<?php


namespace App\Enum;

class QuestionType
{
    public const FORMATION = 'FORMATION';
    public const BOMBER = 'BOMBER';
    public const GENERIC = 'GENERIC';

    public static function getQuestionType()
    {
        return [
            self::GENERIC,
            self::FORMATION,
            self::BOMBER
        ];
    }
}
