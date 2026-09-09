<?php
namespace PHPActiveRecord;

use Override;
use PDO;
use PDOStatement;
use PHPActiveRecord\Attributes\Table;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;

abstract class ActiveRecord implements IActiveRecord
{
    private static PDO $_pdo;

    protected static IQueryBuilder $builder;
    
    /**
     * Table name in the database of the model 
     *
     * @return string
     */
    public static function getTable(): string 
    {
        $ref = new ReflectionClass(static::class);
        /** @var ?ReflectionAttribute<Table> $refTable */
        $refTable = $ref->getAttributes(Table::class)[0] ?? null;
        if ($refTable !== null)
            return $refTable->newInstance()->name;
        $path = explode("\\", static::class);
        return end($path);
    }

    /**
     * Database connection
     *
     * @return PDO
     */
    public static function getPDO(): PDO
    {
        return self::$_pdo;
    }

    /**
     * Dictionary with property names as keys and column names as values
     *
     * @return array<string, string>
     */
    public static function getColumns(): array
    {
        $refProps = new ReflectionClass(static::class)->getProperties();
        $refProps = array_filter($refProps, fn(ReflectionProperty $p) => $p->getDeclaringClass()->name == static::class);
        $columns = [];
        foreach ($refProps as $refProp) {
            $columns[$refProp->name] = $refProp->name;
        }
        return $columns;
    }

    /**
     * Instanciates the $pdo object for all children classes
     *
     * @param string $dsn
     * @param string|null $username
     * @param string|null $password
     * @return void
     */
    public static function init(string $dsn, ?IQueryBuilder $builder = null, ?string $username = null, ?string $password = null): void
    {
        self::$builder = $builder ?? new QueryBuilder;
        self::$_pdo = new PDO($dsn, $username, $password);
    }

    /**
     * Prepares and executes an SQL query
     *
     * @param string $sql
     * @param array<string, mixed> $params
     * @return PDOStatement
     */
    public static function run(string $sql, array $params = []): PDOStatement
    {
        $sttmt = self::$_pdo->prepare($sql);
        $sttmt->execute($params);
        return $sttmt;
    }

    #[Override]
    public function save(): void
    {
        $propName = "id";
        $ref = new ReflectionClass($this);
        $refProp = $ref->getProperty($propName);
        if (!$refProp->isInitialized($this))
            $this->$propName = $this->insert();
        else
            $this->update();
        $obj = static::findById($this->$propName);
        foreach (static::getColumns() as $prop => $column) {
            $this->$prop = $obj->$prop;
        }
    }

    private function update(): void
    {
        $table = static::getTable();
        $columns = static::getColumns();
        $sql = static::$builder->update($table, $columns, [
            new QueryCondition("`$table`.`id` = ?")
        ]);
        $params = [];
        foreach ($columns as $prop => $column) {
            $params[] = $this->$prop;
        }
        $propName = "id";
        $params[] = $this->$propName;
        $this->run($sql, $params);
    }

    private function insert(): int
    {
        $columns = static::getColumns();
        unset($columns["id"]);
        $sql = static::$builder->insert(static::getTable(), $columns);
        $params = [];
        foreach ($columns as $prop => $column) {
            $params[] = $this->$prop;
        }
        static::run($sql, $params);
        return (int)static::getPDO()->lastInsertId();
    }

    #[Override]
    public static function findAll(): array
    {
        $sql = self::$builder->select(static::getTable(), static::getColumns());
        $sttmt = static::run($sql);
        $data = $sttmt->fetchAll();
        $result = [];
        foreach ($data as $value) {
            $result[] = static::instanciate($value);
        }
        return $result;
    }

    #[Override]
    public static function findById(int $id): ?object
    {
        $table = static::getTable();
        $sql = self::$builder->select($table, static::getColumns(), [
            new QueryCondition("`$table`.`id` = ?")
        ]);
        $sttmt = static::run($sql, [$id]);
        $data = $sttmt->fetch();
        if ($data === false)
            return null;
        return static::instanciate($data);
    }

    #[Override]
    public function delete(): void
    {
        $table = static::getTable();
        $sql = self::$builder->delete($table, [
            new QueryCondition("`$table`.`id` = ?")
        ]);
        $propName = "id";
        static::run($sql, [$this->$propName]);
    }

    /**
     * Creates an instance of the current class wit the data if a dictionary
     *
     * @param array $data
     * @return static
     */
    protected static function instanciate(array $data): object
    {
        $refClass = new ReflectionClass(static::class);
        $obj = $refClass->newInstance();
        foreach (static::getColumns() as $prop => $column) 
        {
            $refProp = $refClass->getProperty($prop);
            $refProp->setValue($obj, $data[$column]);
        }
        return $obj;
    }
}