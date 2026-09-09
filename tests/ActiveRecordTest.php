<?php
namespace PHPActiveRecord\Tests;

use PHPActiveRecord\Tests\Models\Commande;
use PHPActiveRecord\Tests\Models\User;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ActiveRecordTest extends TestCase {
    
    #[Test]
    public function table_name_same_class_name()
    {
        $this->assertSame("User", User::getTable());
    }

    #[Test]
    public function columns_binded_properties()
    {
        $this->assertEquals([
            "id" => "id",
            "name" => "name",
            "email" => "email",
        ], User::getColumns());
    }

    #[Test]
    public function insert()
    {
        $user = new User("Test", "test@test.com");
        $user->save();
        $this->assertNotNull(User::findById($user->id));
    }

    #[Test]
    public function insert_with_foreign_object()
    {
        $user = User::findById(1);
        $commande = new Commande($user, "Test prod", 1);
        $commande->save();
        $this->assertNotNull(Commande::findById($commande->id));
    }

    #[Test]
    public function update()
    {
        $user = new User("Test2", "test2@test.com");
        $user->save();
        $this->assertSame("Test2", User::findById($user->id)->name);
        $user->name = "Test2 - updated";
        $user->save();
        $this->assertSame("Test2 - updated", User::findById($user->id)->name);
    }

    #[Test]
    public function delete()
    {
        $user = new User("Test3", "test3@test.com");
        $user->save();
        $this->assertSame("Test3", User::findById($user->id)->name);
        $user->delete();
        $this->assertNull(User::findById($user->id));
    }

    #[Test]
    public function include_single()
    {
        $command = Commande::findById(1);
        $command->include("user");
        $this->assertInstanceOf(User::class, $command->user);
    }

    #[Test]
    public function include_multiple()
    {
        $user = User::findById(1);
        $user->include("commands");
        foreach ($user->commands as $command)
            $this->assertInstanceOf(Commande::class, $command);
    }
}