<?php

namespace Xi\Bundle\SearchBundle\Tests\Service;

use     PHPUnit_Framework_TestCase,
        Xi\Bundle\SearchBundle\Service\SearchService,
        Xi\Bundle\SearchBundle\Service\Search\Search,
        Symfony\Component\Form\FormFactory;

/**
 * @group service
 * @group search
 */
class SearchServiceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SearchService
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();
        
        $this->search = $this->getMock('Xi\Bundle\SearchBundle\Service\Search\Search');
        $this->formfactory = $this->getMockBuilder('Symfony\Component\Form\FormFactory')->disableOriginalConstructor()->getMock();
        $this->service = new SearchService(
            $this->formfactory, 
            $this->search
        );
     
    }
    
    protected function setUpFixtures()
    {        
        parent::setUpFixtures();
    }

  
    /**
     * @test
     */
    public function getSearchForm()
    {
        $this->formfactory->expects($this->once())->method('create')->will($this->returnValue('form'));      
        $form = $this->service->getSearchForm();
        $this->assertEquals('form', $form); 
    }    
 
    /**
     * @test
     */
    public function search() 
    {  
        $this->search->expects($this->once())->method('search')->with('index','term')->will($this->returnValue(array('foo' => 'bar')));
        $result = $this->service->search('index', 'term');
        $this->assertEquals('bar', $result['foo']);
    }
    
    /**
     * @test 
     */
    public function find()
    {
        $this->search->expects($this->once())->method('find')->with('index','term')->will($this->returnValue(array('foo' => 'bar')));
        $result = $this->service->find('index', 'term');
        $this->assertEquals('bar', $result['foo']);  
    }
}