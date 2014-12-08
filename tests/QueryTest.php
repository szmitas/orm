<?php
$autoload = require('../autoloader.php');
class Repel_TestCase extends PHPUnit_Framework_TestCase
{
    public function testCanBeNegated()
    {
         
    }

}


class QueryTest extends Repel_TestCase
{

    public function testCanBeNegated()
    {
         $o = new \Repel\Framework\FActiveQuery();
         var_dump($o);
        // Arrange

        // Act

        // Assert
        $this->assertEquals(1, 2);
    }

}
