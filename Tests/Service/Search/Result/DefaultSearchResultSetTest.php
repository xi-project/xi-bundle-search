<?php

namespace Xi\Bundle\SearchBundle\Tests\Service;

use     PHPUnit_Framework_TestCase,
        Xi\Bundle\SearchBundle\Service\Search\Result\DefaultSearchResultSet;

/**
 * @group search-resultset
 * @group search
 */
class DefaultSearchResultSetTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    /**
     * @test
     */
    public function newDefaultSearchResultSet()
    {     
        $resultSet = new DefaultSearchResultSet(array('foo', 'bar', 'xoo'), 3, 123);
        $this->assertEquals(3, $resultSet->getHits());
        $this->assertEquals(123, $resultSet->getTime());
        $this->assertEquals(array('foo', 'bar', 'xoo'), $resultSet->getResults());        
    }    
    
    /**
     * @test
     */
    public function testDefaultSearchResultSetIterator()
    {     
        $resultSet = new DefaultSearchResultSet(array('foo', 'bar', 'xoo'), 3, 123);
        $this->assertEquals(0, $resultSet->key());
        $this->assertEquals('foo', $resultSet->current());
        $this->assertEquals('bar', $resultSet->next());
        $this->assertEquals('xoo', $resultSet->next());
        $this->assertEquals(2, $resultSet->key());
        $this->assertTrue($resultSet->valid());
        $resultSet->next();
        $this->assertFalse($resultSet->valid());
        $this->assertEquals(3, $resultSet->key());
        $this->assertEquals(0 , $resultSet->rewind()->key());    
    }
    
    /**
     * @test
     */
    public function testDefaultSearchResultSetCount()
    { 
        $resultSet = new DefaultSearchResultSet(array('foo', 'bar', 'xoo'), 3, 123);
        $this->assertCount(3, $resultSet);
    }   
}