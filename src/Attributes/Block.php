<?php
namespace PHPActiveRecord\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Block
{
    public const int ALL = 0;
    public const int INSERT = 1;
    public const int UPDATE = 2;

    public int $value;

    public function __construct(int $value = Block::ALL)
    {
        $this->value = $value;
    }
}