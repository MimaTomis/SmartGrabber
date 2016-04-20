<?php
namespace SmartGrabber\Tests\Grabber;

use DOMNavigator\Finder\XPathFinder;
use DOMNavigator\Loader\FileLoader;
use DOMNavigator\Navigator;
use SmartGrabber\Criteria\ConditionInterface;
use SmartGrabber\Criteria\Criteria;
use SmartGrabber\Factory\BaseElementFactory;
use SmartGrabber\Finder\NavigatorFinder;
use SmartGrabber\Grabber;

class GrabberWithoutVisitorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Grabber
     */
    protected $parser;

    public function setUp()
    {
        $navigator = new Navigator(new FileLoader(), new XPathFinder());

        $finder = new NavigatorFinder($navigator);
        $factory = new BaseElementFactory();

        $this->parser = new Grabber($finder, $factory);
    }

    /**
     * @dataProvider criteriaProvider
     *
     * @param Criteria $criteria
     */
    public function testParse(Criteria $criteria, $expectedData)
    {
        $data = $this->parser->grab($criteria);

        $this->assertEquals($expectedData, $data);
    }

    public function criteriaProvider()
    {
        $criteria1 = new Criteria(FIXTURES_DIR.'/simple.html', [
            'listOfItems' => '//div[@id=\'content\']/ul/li',
            'price' => '//*[@class=\'price\']',
            'currency' => '//*[@class=\'price\']/@data-cur'
        ]);

        $criteria2 = new Criteria(FIXTURES_DIR.'/form.html', [
            'cat' => ['//img/@src', ConditionInterface::TYPE_FILE],
            'action' => ['//form/@action', ConditionInterface::TYPE_FILE]
        ]);

        return [
            [
                $criteria1,
                [
                    'listOfItems' => ['Item #1', 'Item #2', 'Item #3'],
                    'price' => '3.50',
                    'currency' => 'usd'
                ]
            ],
            [
                $criteria2,
                [
                    'cat' => FIXTURES_DIR.'/cat.jpeg',
                    'action' => FIXTURES_DIR.'/simple.html'
                ]
            ]
        ];
    }
}