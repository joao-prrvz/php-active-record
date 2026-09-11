<?php
namespace PHPActiveRecord\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Column
{
    /** Column name in the database */
    public string $name;
    
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}