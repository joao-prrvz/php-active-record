<?php
namespace PHPActiveRecord;

use Exception;
use Override;
use PDO;
use PDOStatement;
use PHPActiveRecord\Attributes\ForeignKey;
use PHPActiveRecord\Attributes\Table;
use PHPActiveRecord\Interfaces\IActiveRecord;
use PHPActiveRecord\Interfaces\IQueryBuilder;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionNamedType;
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
        $refProps = array_filter($refProps, function(ReflectionProperty $p) {
            return $p->getDeclaringClass()->name == static::class &&
            count($p->getAttributes(ForeignKey::class)) < 1;
        });
        $columns = [];
        foreach ($refProps as $refProp)
            $columns[$refProp->name] = $refProp->name;
        return $columns;
    }

    /**
     * Property used as primary key in the model
     *
     * @return ReflectionProperty
     */
    public static function getPrimaryKey(): ReflectionProperty
    {
        return new ReflectionClass(static::class)->getProperty("id");
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
     * Prepares and executes an SQL statement
     *
     * @param string $sql
     * @param array<string, mixed> $params
     * @return PDOStatement
     */
    public static function run(string $sql, array $params = []): PDOStatement
    {
        $sttmt = self::getPDO()->prepare($sql);
        $sttmt->execute($params);
        return $sttmt;
    }

    /**
     * Directly runs an SQL query
     *
     * @param string $sql
     * @return void
     */
    public static function exec(string $sql): void
    {
        self::getPDO()->exec($sql);
    }



    #[Override]
    public function save(): void
    {
        $ref = new ReflectionClass($this);
        $refPK = static::getPrimaryKey();
        if (!$refPK->isInitialized($this))
            $refPK->setValue($this, $this->insert());
        else
            $this->update();
        $obj = static::findById($refPK->getValue($this));
        foreach (static::getColumns() as $propName => $column) {
            $refProp =  $ref->getProperty($propName);
            $refProp->setValue($this, $refProp->getValue($obj));
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
        foreach ($columns as $prop => $column) 
            $params[] = $this->$prop;
        $params[] = static::getPrimaryKey()->getValue($this);
        $this->run($sql, $params);
    }

    private function insert(): int
    {
        $columns = static::getColumns();
        unset($columns["id"]);
        $sql = static::$builder->insert(static::getTable(), $columns);
        $params = [];
        foreach ($columns as $prop => $column)
            $params[] = $this->$prop;
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
        foreach ($data as $value)
            $result[] = static::instanciate($value);
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
        static::run($sql, [static::getPrimaryKey()->getValue($this)]);
    }

    /**
     * Requests for an object with the attribute {@see ForeignKey}
     *
     * @param string $propertyName
     * @return void
     */
    public function include(string $propertyName): void
    {
        $ref = new ReflectionClass($this);
        $refProp = $ref->getProperty($propertyName);
        $refAttr = $refProp->getAttributes(ForeignKey::class)[0] ?? null;
        if ($refAttr == null)
            throw new Exception("The property '$propertyName' doesn't have the attribute ForeignKey");
        $refType = $refProp->getType();
        if (!($refType instanceof ReflectionNamedType))
            throw new Exception("A foreign object must be an array or anotner model's class");
        $typeName = $refType->getName(); 
        if ($typeName === "array") {
            $this->includeMultiple($refProp, $refAttr->newInstance());
            return;
        }
        if (!class_exists($typeName))
            throw new Exception("A foreign object must be an array or anotner model's class");
        $this->includeSingle($refProp, $refAttr->newInstance());
    }

    private function includeSingle(ReflectionProperty $refProp, ForeignKey $attr): void
    {
        $refType = $refProp->getType();
        $table = static::getTable();
        $sql = static::$builder->select(static::getTable(), [$attr->name], [
            new QueryCondition("`$table`.`id` = ?")
        ]);
        $sttmt = static::run($sql, [static::getPrimaryKey()->getValue($this)]);
        $fk = (int)$sttmt->fetch()[$attr->name];
        if ($refType instanceof ReflectionNamedType) {
            $refMet = new ReflectionClass($refType->getName())->getMethod("findById");
            $obj = $refMet->invoke(null, $fk);
            $refProp->setValue($this, $obj);
        }
    }

    private function includeMultiple(ReflectionProperty $refProp, ForeignKey $attr): void
    {
        $table = $attr->type::getTable();
        $sql = static::$builder->select($table, $attr->type::getColumns(), [
            new QueryCondition("`$table`.`$attr->name` = ?")
        ]);

        $sttmt = static::run($sql, [static::getPrimaryKey()->getValue($this)]);
        $data = $sttmt->fetchAll();
        $values = [];
        foreach ($data as $row)
            $values[] = $attr->type::instanciate($row);
        $refProp->setValue($this, $values);
    }

    /**
     * Creates an instance of the current class wit the data if a dictionary
     *
     * @param array $data
     * @return static
     */
    public static function instanciate(array $data): object
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