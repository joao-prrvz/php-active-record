<?php
namespace PHPActiveRecord\Tests\Models;

use PHPActiveRecord\ActiveRecord;
use PHPActiveRecord\Attributes as DB;
use PHPActiveRecord\QueryCondition;

class Event extends ActiveRecord
{
    public string $id;
    public string $title;
    public string $description;
    #[DB\Column("event_date")]
    public string $eventDate;
    public int $capacity;
    #[DB\ForeignKey("owner_id")]
    public User $owner;

    #[DB\Block]
    public int $capacityLeft {
        get {
            $sql = static::$builder->select(Registration::getTable(), ["COUNT(*)"], [new QueryCondition("event_id = ?")], false);
            $sttmt = static::run($sql, [$this->id]);
            return $this->capacity - (int)$sttmt->fetch()["COUNT(*)"];
        }
    }

    public function __construct(string $title, string $description, string $eventDate, int $capacity, User $owner)
    {
        $this->title = $title;
        $this->description = $description;
        $this->eventDate = $eventDate;
        $this->capacity = $capacity;
        $this->owner = $owner;
    }
}