<?php
namespace PHPActiveRecord\Tests;

use PHPActiveRecord\Tests\Models\Event;
use PHPActiveRecord\Tests\Models\Registration;
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
            "username" => "username",
            "password" => "password",
            "role" => "role",
        ], User::getColumns());
    }

    #[Test]
    public function insert()
    {
        $user = new User("Test", "Super");
        $user->save();
        $this->assertNotNull(User::findById($user->id));
    }

    #[Test]
    public function insert_with_foreign_object()
    {
        $user = User::findById(1);
        $event = new Event("Test event", "My test event", "2024-01-10 20:40:00", 1, $user);
        $event->save();
        $this->assertNotNull(Event::findById($event->id));
    }

    #[Test]
    public function update()
    {
        $user = new User("Test2", "Super");
        $user->save();
        $this->assertSame("Test2", User::findById($user->id)->username);
        $user->username = "Test2 - updated";
        $user->save();
        $this->assertSame("Test2 - updated", User::findById($user->id)->username);
    }

    #[Test]
    public function delete()
    {
        $user = new User("Test3", "Super");
        $user->save();
        $this->assertSame("Test3", User::findById($user->id)->username);
        $user->delete();
        $this->assertNull(User::findById($user->id));
    }

    #[Test]
    public function include_single()
    {
        $event = Event::findById(1);
        $event->include("owner");
        $this->assertInstanceOf(User::class, $event->owner);
    }

    #[Test]
    public function include_multiple()
    {
        $user = User::findById(1);
        $user->include("events");
        foreach ($user->events as $event)
            $this->assertInstanceOf(Event::class, $event);
    }

    #[Test]
    public function auto_include()
    {
        $reg = Registration::findById(1);
        $this->assertTrue(isset($reg->user));
        $this->assertTrue(isset($reg->event));
    }
}