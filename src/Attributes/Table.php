<?php
namespace PHPActiveRecord\Attributes;

use Attribute;
/** Defines the table name in the database */
#[Attribute(Attribute::TARGET_CLASS)]
class Table
{
    /** Name of the table in the database */
    public string $name;
    
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}