<?php
namespace PHPActiveRecord\Attributes;

use Attribute;
use PHPActiveRecord\ActiveRecord;

/** Represents the link between two tables*/
#[Attribute(Attribute::TARGET_PROPERTY)]
class ForeignKey
{
    /** Column name in the foreign table */
    public string $name;

    /**
     * Class of the ActiveRecord model representing the foreign table 
     *
     * @var ?class-string<ActiveRecord>
     */
    public ?string $type;

    /**
     * @param string $name
     * @param ?class-string<ActiveRecord> $type
     */
    public function __construct(string $name, ?string $type = null)
    {
        $this->name = $name;
        $this->type = $type;
    }
}
