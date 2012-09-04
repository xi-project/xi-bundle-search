<?php

namespace Xi\Bundle\SearchBundle\Tests\Service\Search;

use     PHPUnit_Framework_TestCase,
        Xi\Bundle\SearchBundle\Service\Search\FOQElasticaSearch,
        Xi\Bundle\SearchBundle\Service\Search\Search,
        \Elastica_ResultSet,
        \Elastica_Searchable,
        Symfony\Component\DependencyInjection\Container;

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

        $finderMock = $this->getMockBuilder('FOQ\ElasticaBundle\Finder\TransformedFinder')
            ->disableOriginalConstructor()->getMock();
        $searchableMock = $this->getMockBuilder('Elastica_Searchable')
            ->disableOriginalConstructor()->getMock();
        $paginatorMock = $this->getMock('Knp\Component\Pager\Paginator', array('paginate'));
        $paginatorMock->expects($this->any())
             ->method('paginate')
             ->will($this->returnValue($this->getMock('Knp\Component\Pager\Pagination\PaginationInterface')));
        $transformerMock = $this->getMockBuilder('FOQ\ElasticaBundle\Doctrine\ORM\ElasticaToModelTransformer')
            ->disableOriginalConstructor()->getMock();

        $returnMap = array(
            array('foq_elastica.index.index', Container::EXCEPTION_ON_INVALID_REFERENCE, $searchableMock),
            array('foq_elastica.finder.index', Container::EXCEPTION_ON_INVALID_REFERENCE, $finderMock),
            array('foq_elastica.elastica_to_model_transformer.collection.index', Container::EXCEPTION_ON_INVALID_REFERENCE, $transformerMock),
            array('knp_paginator', Container::EXCEPTION_ON_INVALID_REFERENCE, $paginatorMock),
        );

        $container = $this->getMock('Symfony\Component\DependencyInjection\Container', array('get'));
        $container->expects($this->any())
             ->method('get')
             ->will($this->returnValueMap($returnMap));

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

        $class = new \ReflectionClass('Xi\Bundle\SearchBundle\Service\Search\FOQElasticaSearch');
        $method = $class->getMethod('convertToSearchResult');
        $method->setAccessible(true);

        $defaultResultSet = $method->invokeArgs($this->search, array($elasticaResultSet));

        $this->assertInstanceOf('\Xi\Bundle\SearchBundle\Service\Search\Result\DefaultSearchResultSet', $defaultResultSet);
    }

    /**
     * @test
     * @group search
     */
    public function createsNewPaginatorAdapter()
    {
        $adapter = $this->search->createPaginatorAdapter('searchterm', 'index');

        $this->assertInstanceOf('\FOQ\ElasticaBundle\Paginator\TransformedPaginatorAdapter', $adapter);
    }

    /**
     * @test
     * @group search
     */
    public function findPaginatedReturnsPaginator()
    {
        $pagination = $this->search->findPaginated('index', 'searchterm');

        $this->assertInstanceOf('Knp\Component\Pager\Pagination\PaginationInterface', $pagination);
    }

}
