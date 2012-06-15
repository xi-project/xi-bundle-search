<?php

namespace Xi\Bundle\SearchBundle\Service\Search\Result;

interface SearchResult
{

    /**
     * return search index name 
     * @return string
     */
    public function getIndex();
    
    /**
     * return type of result
     * @return string 
     */
    public function getType();
    
    /**
     * return row id
     * @return mixed 
     */
    public function getId();
    
    /**
     * @return float 
     */
    public function getScore();
    
    /**
     * 
     * @return array 
     */
    public function getSource();
}