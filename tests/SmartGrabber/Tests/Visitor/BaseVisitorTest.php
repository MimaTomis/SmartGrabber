<?php
namespace SmartGrabber\Tests\Visitor;

use SmartGrabber\Visitor\BaseElementVisitor;

class BaseVisitorTest extends \PHPUnit_Framework_TestCase
{
    protected $visitor;

    public function setUp()
    {
        $this->visitor = new BaseElementVisitor();
    }

    public function testVisitFile()
    {

    }
}