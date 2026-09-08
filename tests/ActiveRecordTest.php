<?php
namespace PHPActiveRecord\Tests;

use PHPActiveRecord\ActiveRecord;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionObject;

class User extends ActiveRecord {}

class ActiveRecordTest extends TestCase {
    
    #[Test]
    public function table_name_same_class_name()
    {
        $user = new User();
        $ref = new ReflectionObject($user);
        $table = $ref->getProperty("table")->getValue($user);
        $this->assertSame("User", $table);
    }
}