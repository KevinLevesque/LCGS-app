<?php


namespace KLevesque\LCGS\Domain\Match;


class TeamColor
{
    const RED = 'red';
    const BLUE = 'blue';

    public string $value;


    private array $allowedValues = [self::RED, self::BLUE];

    public function __construct(string $color)
    {
        if(!in_array($color, $this->allowedValues)){
            throw new \RuntimeException("Invalid team color :  $color");
        }

        $this->value = $color;
    }


    public static function blue() : self {
        return new TeamColor(self::BLUE);
    }

    public static function red() : self {
        return new TeamColor(self::RED);
    }


}