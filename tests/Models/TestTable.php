<?php
namespace PHPActiveRecord\Tests\Models;

use PHPActiveRecord\ActiveRecord;
use PHPActiveRecord\Attributes as DB;

#[DB\Table("Test")]
class TestTable extends ActiveRecord { }