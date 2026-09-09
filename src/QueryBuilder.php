<?php
namespace PHPActiveRecord;

use Override;
use PHPActiveRecord\Interfaces\IQueryBuilder;
use PHPActiveRecord\QueryCondition;

class QueryBuilder implements IQueryBuilder
{
    /**
     * Undocumented function
     *
     * @param QueryCondition[] $conditions
     * @return string
     */
    private function conditions(array $conditions): string
    {
        if (count($conditions) < 1)
            return "";
        $result = "WHERE";
        foreach ($conditions as $i => $condition)
            $result .= " ". $condition->build($i != 0);
        return "$result";
    }

    #[Override]
    public function insert(string $table, array $columns): string
    {
        $params = str_repeat("?, ", count($columns) - 1). "?";
        $columns = implode("`, `", $columns);
        return "INSERT INTO `$table` (`$columns`) VALUES ($params)";
    }

    #[Override]
    public function select(string $table, array $columns, array $conditions = []): string
    {
        $columns = implode("`, `", $columns);
        $conditions = $this->conditions($conditions);
        return rtrim("SELECT `$columns` FROM `$table` $conditions");
    }

    #[Override]
    public function update(string $table, array $columns, array $conditions): string
    {
        $columns = implode("` = ?, `", $columns);
        $conditions = $this->conditions($conditions);
        return rtrim("UPDATE `$table` SET `$columns` = ? $conditions");
    }

    #[Override]
    public function delete(string $table, array $conditions): string
    {
        $conditions = $this->conditions($conditions);
        return rtrim("DELETE FROM `$table` $conditions");
    }
}