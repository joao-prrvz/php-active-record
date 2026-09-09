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

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }
}