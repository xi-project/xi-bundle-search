<?php

namespace Xi\Bundle\SearchBundle\Service\Search\Result;


interface SearchResultSet extends \Iterator, \Countable
{

    /**
	 * @return array SearchResult
	 */
	public function getResults();

	/**
	 * @return int 
	 */
	public function getHits();

    /**
     * @return int (ms)
     */
    public function getTime();
}