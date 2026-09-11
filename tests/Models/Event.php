<?php
namespace PHPActiveRecord\Tests\Models;

use PHPActiveRecord\ActiveRecord;
use PHPActiveRecord\Attributes as DB;

class Event extends ActiveRecord
{
    public string $id;
    public string $title;
    public string $description;
    public string $event_date;
    public int $capacity;
    #[DB\ForeignKey("owner_id")]
    public User $owner;

    public function __construct(string $title, string $description, string $event_date, int $capacity, User $owner)
    {
        $this->title = $title;
        $this->description = $description;
        $this->event_date = $event_date;
        $this->capacity = $capacity;
        $this->owner = $owner;
    }
}