<?php

namespace Xi\Bundle\SearchBundle\Service\Search\Result;

class DefaultSearchResult implements SearchResult
{
    
    /**
     * @var string 
     */
    private $index;
    
    /**
     * @var string
     */
    private $type;
    
    /**
     * @var mixed
     */
    private $id;
    
    /**
     * @var float
     */
    private $score;  
    
    /**
     * @var array
     */
    private $source;
    
    
    public function __construct($index, $type, $id, $score, array $source)
    {
        $this->index    = $index;
        $this->type     = $type;
        $this->id       = $id;
        $this->score    = $score;
        $this->source   = $source;
    } 
 
    /**
     * return search index name 
     * @return string
     */
    public function getIndex()
    {
        return $this->index;
    }
    
    /**
     * return type of result
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * return row id
     * @return mixed 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return float 
     */
    public function getScore()
    {
        return $this->score;
    }
    
    /**
     * @return array 
     */
    public function getSource()
    {
        return $this->source;
    }
    
    
}