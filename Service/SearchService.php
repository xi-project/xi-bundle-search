<?php

namespace Xi\Bundle\SearchBundle\Service;

use Symfony\Component\Form\FormFactory,
    Symfony\Component\Form\Form,
    Xi\Bundle\SearchBundle\Form\SearchType,
    Xi\Bundle\SearchBundle\Service\Search\Search,
    Xi\Bundle\SearchBundle\Service\Search\Result\SearchResultSet;


class SearchService 
{
    /**
     * @var FormFactory
     */
    protected $formFactory;
   
    /**
     * @var Search
     */
    protected $searchInterface;
    
    /**
     * @param FormFactory $formFactory
     * @param Search $searchInterface 
     */
    public function __construct(
            FormFactory $formFactory,
            Search $searchInterface)
    {
        $this->formFactory      = $formFactory;
        $this->searchInterface  = $searchInterface;
    } 
    
    /**
     * @return Form
     */
    public function getSearchForm()
    {
        return $this->formFactory->create(
            new SearchType()
        );
    }    
 
    /**
     * @param string $index
     * @param string $term
     * @param int    $limit
     * @return SearchResultSet
     */
    public function search($index, $term, $limit = null) 
    {      
        return $this->searchInterface->search($index, $term, $limit);
    }

    /**
     * Find and returns array of searched entities
     * 
     * @param string $index
     * @param string $term
     * @param int    $limit
     * @return  array - array of entities
     */
    public function find($index, $term, $limit = null)
    {
        return $this->searchInterface->find($index, $term, $limit);    
    }
    
}