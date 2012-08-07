<?php

namespace Xi\Bundle\SearchBundle\Tests\Service\Search;

use     PHPUnit_Framework_TestCase,
        Xi\Bundle\SearchBundle\Service\Search\FOQElasticaSearch,
        Xi\Bundle\SearchBundle\Service\Search\Search,
        \Elastica_ResultSet;

/**
 * @group search
 */
class FOQElasticaSearchTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var FOQElasticaSearch
     */
    protected $search;

    public function setUp()
    {
        parent::setUp();

        $container = $this->getMock('Symfony\Component\DependencyInjection\Container');
        $this->search = new FOQElasticaSearch(
            $container
        );

    }

    /**
     * @test
     * @group search
     */
    public function convertsToSearchresult()
    {
        $elasticaResultSet = $this->getMockBuilder('Elastica_ResultSet')->disableOriginalConstructor()->getMock();

        // $defaultResultSet = $this->search->convertToSearchResult($elasticaResultSet);

        $class = new \ReflectionClass('Xi\Bundle\SearchBundle\Service\Search\FOQElasticaSearch');
        $method = $class->getMethod('convertToSearchResult');
        $method->setAccessible(true);

        $defaultResultSet = $method->invokeArgs($this->search, array($elasticaResultSet));

        $this->assertInstanceOf('\Xi\Bundle\SearchBundle\Service\Search\Result\DefaultSearchResultSet', $defaultResultSet);
    }

}
