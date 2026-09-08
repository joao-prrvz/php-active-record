<?php
namespace PHPActiveRecord\Tests;

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
        $user = User::new("Test", "test@test.com");
        $user->save();
        $this->assertNotNull(User::findById($user->id));
    }

    #[Test]
    public function update()
    {
        $user = User::new("Test2", "test2@test.com");
        $user->save();
        $this->assertSame("Test2", User::findById($user->id)->name);
        $user->name = "Test2 - updated";
        $user->save();
        $this->assertSame("Test2 - updated", User::findById($user->id)->name);
    }

    #[Test]
    public function delete()
    {
        $user = User::new("Test3", "test3@test.com");
        $user->save();
        $this->assertSame("Test3", User::findById($user->id)->name);
        $user->delete();
        $this->assertNull(User::findById($user->id));
    }
}