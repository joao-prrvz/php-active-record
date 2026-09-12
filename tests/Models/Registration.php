<?php
namespace PHPActiveRecord\Tests\Models;

use PHPActiveRecord\ActiveRecord;
use PHPActiveRecord\Attributes as DB;

class Registration extends ActiveRecord
{
    public int $id;
    #[DB\ForeignKey("user_id", autoInclude:true)]
    public User $user;
    #[DB\ForeignKey("event_id", autoInclude:true)]
    public Event $event;
    #[DB\Column("created_at")]
    public string $createdAt;
}