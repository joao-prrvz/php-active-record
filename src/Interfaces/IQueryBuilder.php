<?php
namespace PHPActiveRecord\Interfaces;

use PHPActiveRecord\QueryCondition;

interface IQueryBuilder
{
    /**
     * Generates an insert SQL query
     *
     * @param string $table
     * @param string[] $columns
     * @return string
     */
    public function insert(string $table, array $columns): string;

    /**
     * Generates a select SQL query
     *
     * @param string $table
     * @param string[] $columns
     * @param QueryCondition[] $conditions
     * @return string
     */
    public function select(string $table, array $columns, array $conditions = []): string;

    /**
     * Generates an update SQL query
     *
     * @param string $table
     * @param string[] $columns
     * @param QueryCondition[] $conditions
     * @return string
     */
    public function update(string $table, array $columns, array $conditions): string;

    /**
     * Generates a delete SQL query
     *
     * @param string $table
     * @param QueryCondition[] $conditions
     * @return string
     */
    public function delete(string $table, array $conditions): string;
}