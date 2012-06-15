<?php

namespace Xi\Bundle\SearchBundle\Tests\Twig\Extensions;

use     PHPUnit_Framework_TestCase,
        Xi\Bundle\SearchBundle\Twig\Extensions\SearchForm,
        Xi\Bundle\SearchBundle\Twig\Extensions\SearchRenderer,
        Xi\Bundle\SearchBundle\Service\SearchService,
        Xi\Bundle\SearchBundle\Service\Search\Result\SearchResult,
        Xi\Bundle\SearchBundle\Entity\SearchType,
        \Twig_Environment,
        \Twig_Error_Runtime;

/**
 * @group twig-extension
 * @group search
 */
class SearchFormTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SearchService
     */
    protected $service;

    /**
     * @var SearchForm
     */
    protected $searchForm;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->service = $this->getMockBuilder('Xi\Bundle\SearchBundle\Service\SearchService')->disableOriginalConstructor()->getMock();
        $this->environment = $this->getMock('\Twig_Environment');      
        $this->searchForm = new SearchForm($this->environment, $this->service, array('result_renderer_extensions' => array('yourType' => 'template')));
      
        $this->searchResult = $this->getMockBuilder('Xi\Bundle\SearchBundle\Service\Search\Result\SearchResult')->disableOriginalConstructor()->getMock();     
        }
    
        
    /**
     * @test
     */
    public function searchResultExtensionUnknownType()
    {
        $returnValue = $this->searchForm->searchResult(array(), array());
        $this->assertEquals("Unknown result type", $returnValue);
    }         
        
    /**
     * @test
     * expectedException  Twig_Error_Runtime
     */
    public function searchResultExtensionNotFound()
    {
        $this->searchResult->expects($this->once())->method('getType')->will($this->returnValue('yourType'));          
        $this->environment->expects($this->once())->method('getExtension')->will($this->throwException(new Twig_Error_Runtime('trol')));  
        $returnValue = $this->searchForm->searchResult($this->searchResult, array());
        $this->assertEquals("Extension template not found for type: yourType", $returnValue);
    } 
    
    /**
     * @test
     */
    public function searchResultExtensionNotInstanceOfSearchRenderer()
    {
        $this->searchResult->expects($this->once())->method('getType')->will($this->returnValue('yourType'));          
        $this->environment->expects($this->once())->method('getExtension')->will($this->returnValue('not what expected'));  
        $returnValue = $this->searchForm->searchResult($this->searchResult, array());
        $this->assertEquals("Extension template should implement interface: SearchRenderer", $returnValue);
    }     
 
    /**
     * @test
     */
    public function searchResultExtension()
    {
        $this->searchResult->expects($this->once())->method('getType')->will($this->returnValue('yourType'));          
        $searchRenderer = $this->getMockForAbstractClass('Xi\Bundle\SearchBundle\Twig\Extensions\SearchRenderer');
        $searchRenderer->expects($this->once())->method('searchRenderer')->with($this->searchResult, array())->will($this->returnValue('rendered template'));
        
        $this->environment->expects($this->once())->method('getExtension')->will($this->returnValue($searchRenderer));  
        $returnValue = $this->searchForm->searchResult($this->searchResult, array());
        
        $this->assertEquals("rendered template", $returnValue);
    } 
    
    /**
     * @test
     */
    public function findResultExtension()
    {
        $entity = $this->getMockForAbstractClass('Xi\Bundle\SearchBundle\Entity\SearchType');
        $entity->expects($this->once())->method('getSearchType')->will($this->returnValue('yourType'));   
        $returnValue = $this->searchForm->searchResult($entity, array());
        $this->assertEquals("Extension template should implement interface: SearchRenderer", $returnValue);
    }      

    
}