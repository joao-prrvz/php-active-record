<?php
namespace PHPActiveRecord\Tests;

use PHPActiveRecord\Tests\Models\TestTable;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AttributesTest extends TestCase
{
    #[Test]
    public function table()
    {
        $this->assertSame("Test", TestTable::getTable());
    } 
}