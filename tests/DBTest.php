<?php

use PHPUnit\Framework\TestCase;
use TeamBuilder\Model\DB;

final class DBTest extends TestCase
{

    public function testSelectMany(): void
    {


        $res = DB::selectMany("SELECT * FROM roles", []);

        $this->assertEquals(true, true);
    }

}