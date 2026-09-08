<?php
namespace PHPActiveRecord;

class QueryCondition
{
    public string $expression;
    public string $operator;

    public function __construct(string $expression, string $operator = "AND")
    {
        $this->expression = $expression;
        $this->operator = $operator;
    }

    public function build(bool $displayOperator = false)
    {
        $operator = $displayOperator ? $this->operator : "";
        return ltrim("$operator $this->expression");
    }
}