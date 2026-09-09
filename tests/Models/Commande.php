<?php
namespace PHPActiveRecord\Tests\Models;

use PHPActiveRecord\ActiveRecord;
use PHPActiveRecord\Attributes as DB;

class Commande extends ActiveRecord 
{
    public int $id;
    #[DB\ForeignKey("userId")]
    public User $user;
    public string $product;
    public float $amount;

    public function __construct(User $user, string $product, float $amount)
    {
        $this->user = $user;
        $this->product = $product;
        $this->amount = $amount;
    }
}