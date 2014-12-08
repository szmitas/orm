<?php

require_once '../autoloader.php';

class QueryTest extends PHPUnit_Framework_TestCase
{
    // ...

    public function testCanBeNegated()
    {
         $o = new \Repel\FActiveQuery();
         var_dump($o);
        // Arrange

        // Act

        // Assert
        $this->assertEquals(1, 2);
    }

}
