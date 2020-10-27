<?php


namespace App\Enum;

class PlayerRole
{
    public const PORTIERE = 'Portiere';
    public const DIFENSORE = 'Difensore';
    public const CENTROCAMPISTA = 'Centrocampista';
    public const ATTACCANTE = 'Attaccante';


    public static function convertByFantagazzetta($role)
    {
        switch ($role) {
            case 'A':
                return self::ATTACCANTE;
            case 'C':
                return self::CENTROCAMPISTA;
            case 'D':
                return self::DIFENSORE;
            case 'P':
                return self::PORTIERE;
        }
    }
}
