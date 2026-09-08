<?php
namespace PHPActiveRecord\Tests\Models;

use PHPActiveRecord\ActiveRecord;

class User extends ActiveRecord
{
    public int $id;
    public string $name;
    public string $email;

    public static function new(string $name, string $email): User
    {
        $user = new User;
        $user->name = $name;
        $user->email = $email;
        return $user;
    }
}