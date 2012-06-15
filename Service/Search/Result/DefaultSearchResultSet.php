<?php

namespace Xi\Bundle\SearchBundle\Service\Search\Result;

use Xi\Bundle\SearchBundle\Service\Search\Result\SearchResult;

class DefaultSearchResultSet implements SearchResultSet
{

	/**
	 * @var array results
	 */
	protected $results = array();

	/**
	 * @var int position
	 */
	protected $position = 0;

    /**
     * @var int hits
     */
    protected $hits = 0;
 
    /**
     * @var int time
     */    
    protected $time = 0;
    

    public function __construct(array $results, $hits, $time) 
    {
        $this->results  = $results;
        $this->hits     = $hits;
        $this->time     = $time;
		$this->rewind();
	}	  

	/**
	 * @return array SearchResult
	 */
	public function getResults() 
    {
		return $this->results;
	}

	/**
	 * @return int 
	 */
	public function getHits() 
    {
		return $this->hits;
	}

    /**
     * @return int (ms)
     */
    public function getTime()
    {
        return $this->time;
    }
    
    /**
     * @return DefaultSearchResultSet 
     */
	public function rewind() 
    {
		$this->position = 0;
        return $this;
	}
    
    /**
     * Returns array pointers current element 
     * 
     * @return SearchResult
     */
    public function current()
    {
        if ($this->valid()) {
            return $this->results[$this->position];
        } else {
            return false;
        }
    }
    
    /**
     * @return int 
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * moves array pointer and returns its new element
     * 
     * @return SearchResult
     */
    public function next()
    {
        ++$this->position;
        return $this->current();
    }
    
    /**
     * Check if current position is valid
     * 
     * @return bool
     */
    public function valid()
    {
        return isset($this->results[$this->position]);
    }
    
	/**
	 * @return int
	 */
	public function count() 
    {
		return sizeof($this->results);
	}    
    
}