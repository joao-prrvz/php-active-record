<?php
namespace PHPActiveRecord\Tests;

use PHPActiveRecord\QueryBuilder;
use PHPActiveRecord\QueryCondition;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BuildersTest extends TestCase
{
    #[Test]
    public function insert_query()
    {
        $builder = new QueryBuilder();
        $sql = $builder->insert("User", ["id", "name", "email"]);
        $this->assertSame("INSERT INTO `User` (`id`, `name`, `email`) VALUES (?, ?, ?)", $sql);
    }

    #[Test]
    public function select_query()
    {
        $builder = new QueryBuilder();
        $sql = $builder->select("User", ["id", "name", "email"]);
        $this->assertSame("SELECT `id`, `name`, `email` FROM `User`", $sql);
    }

    #[Test]
    public function upate_query()
    {
        $builder = new QueryBuilder();
        $sql = $builder->update("User", ["id", "name", "email"], [ 
            new QueryCondition("`User`.`id` = ?")
        ]);
        $this->assertSame("UPDATE `User` SET `id` = ?, `name` = ?, `email` = ? WHERE `User`.`id` = ?", $sql);
    }

    #[Test]
    public function delete_query()
    {
        $builder = new QueryBuilder();
        $sql = $builder->delete("User", [
            new QueryCondition("`id` = ?")
        ]);
        $this->assertSame("DELETE FROM `User` WHERE `id` = ?", $sql);
    }
}