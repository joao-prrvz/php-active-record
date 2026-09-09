<?php
namespace PHPActiveRecord\Tests\Models;

use PHPActiveRecord\ActiveRecord;
use PHPActiveRecord\Attributes as DB;

class User extends ActiveRecord
{
    public int $id;
    public string $name;
    public string $email;
    #[DB\ForeignKey("userId", Commande::class)]
    public array $commands;

    public static function new(string $name, string $email): User
    {
        $user = new User;
        $user->name = $name;
        $user->email = $email;
        return $user;
    }
}