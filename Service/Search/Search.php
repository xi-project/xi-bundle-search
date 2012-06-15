<?php

namespace Xi\Bundle\SearchBundle\Service\Search;
use Xi\Bundle\SearchBundle\Service\Search\Result\SearchResultSet;

/**
 * Inteface for differend search engines 
 */
interface Search
{

    /**
     * Search returns array of search results
     * 
     * @param string $index  - name of the indexed resource
     * @param string $term   - search term
     * @param int    $limit
     * @return SearchResultSet
     */    
    public function search($index, $term, $limit = null);
    
    
    /**
     * Find and returns array of searched entities
     * 
     * @param string $index  - name of the indexed resource
     * @param string $term   - search term
     * @param int    $limit
     * @return  array - array of entities
     */
    public function find($index, $term, $limit = null);
    
    
}