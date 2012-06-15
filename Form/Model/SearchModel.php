<?php

namespace Xi\Bundle\SearchBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class SearchModel
{
    /**
     * @var array
     */
    protected $options;
    
    /**
     * @var string
     * @Assert\NotBlank(message="search.validation.index.notblank") 
     */
    protected $index;
    
    /**
     * @var string
     * @Assert\NotBlank(message="search.validation.search_type.notblank") 
     */    
    protected $searchType;
    
    /**
     * @var string
     * @Assert\NotBlank(message="search.validation.term.notblank") 
     */      
    protected $term;
    
    /**
     * @param string $options
     * @return \Xi\Bundle\SearchBundle\Form\Model\SearchModel 
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }
    
    /**
     * @return array 
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    /*
     * @param string $index
     * @return \Xi\Bundle\SearchBundle\Form\Model\SearchModel 
     */
    public function setIndex($index)
    {
        $this->index = $index;
        return $this;
    }
    
    /**
     * @return string 
     */
    public function getIndex()
    {
        return $this->index;
    }
    
    /**
     * @param string $searchType
     * @return \Xi\Bundle\SearchBundle\Form\Model\SearchModel 
     */
    public function setSearchType($searchType)
    {
        $this->searchType = $searchType;
        return $this;
    }

    /**
     * @return string
     */
    public function getSearchType()
    {
        return $this->searchType;
    }
    
    /**
     * @param string $term
     * @return \Xi\Bundle\SearchBundle\Form\Model\SearchModel 
     */
    public function setTerm($term)
    {
        $this->term = $term;
        return $this;
    }
    
    /**
     * @return string 
     */
    public function getTerm()
    {
        return $this->term;
    }
}