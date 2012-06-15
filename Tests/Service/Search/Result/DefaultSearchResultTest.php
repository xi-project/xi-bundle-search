<?php

namespace Xi\Bundle\SearchBundle\Tests\Service;

use     PHPUnit_Framework_TestCase,
        Xi\Bundle\SearchBundle\Service\Search\Result\DefaultSearchResult;

/**
 * @group search-result
 * @group search
 */
class DefaultSearchResultTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    /**
     * @test
     */
    public function newDefaultSearchResult()
    {
        
        $result = new DefaultSearchResult('index', 'type', 'id', 12.22, array('foo', 'bar'));
        $this->assertEquals('index', $result->getIndex());
        $this->assertEquals('type', $result->getType());
        $this->assertEquals('id', $result->getId());
        $this->assertEquals(12.22, $result->getScore());
        $this->assertEquals(array('foo', 'bar'), $result->getSource());
    }    

}