<?php
namespace PHPActiveRecord\Tests\Models;

use PHPActiveRecord\ActiveRecord;
use PHPActiveRecord\Attributes as DB;

class User extends ActiveRecord
{
    public int $id;
    public string $username;
    public string $password;
    public string $role;
    #[DB\ForeignKey("owner_id", Event::class)]
    public array $events;

    public function __construct(string $username, string $password, string $role = "member")
    {
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->role = $role;
    }
}