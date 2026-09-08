<?php
namespace PHPActiveRecord;

use Override;

abstract class ActiveRecord implements IActiveRecord {

    private static ?string $_table = null;
    protected string $table 
    { 
        get 
        {
            if (static::$_table === null) {
                $path = explode("\\", static::class);
                static::$_table = end($path);
            }
            return static::$_table;
        }
    }

    #[Override]
    public function save(): void
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function findAll(): array
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function findById(int $id): ?object
    {
        throw new \Exception('Not implemented');
    }
}