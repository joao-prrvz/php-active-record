<?php

namespace PHPActiveRecord;

interface IActiveRecord {

    /**
     * Inserts the current object if it doesn't exist or insert it into the database otherwise
     *
     * @return void
     */
    public function save(): void;
    /**
     * Requests for the object having the ID passed if not found returns null
     *
     * @param int $id Unique identifier of the object
     * @return static|null
     */
    public function findById(int $id): ?object;

    /**
     * Requests an array of all objects of the table
     *
     * @return static[]
     */
    public function findAll(): array;
}