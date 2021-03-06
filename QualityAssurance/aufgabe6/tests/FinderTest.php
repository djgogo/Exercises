<?php

/**
 * @covers Finder
 */
class FinderTest extends \PHPUnit_Framework_TestCase
{
    public function testCanFindClassNameInGivenDirectory()
    {
        $finder = new Finder();
        $classNames = $finder->findDeclarationsInDirectory('/var/www/Exercises/QualityAssurance/aufgabe6/src');
        $this->assertEquals('Found: Finder', $finder->printClassNames($classNames));
    }
}
