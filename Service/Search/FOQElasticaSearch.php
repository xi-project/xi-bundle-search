<?php

namespace Xi\Bundle\SearchBundle\Service\Search;

use Symfony\Component\DependencyInjection\Container,
    Xi\Bundle\SearchBundle\Service\Search\Result\DefaultSearchResultSet,        
    Xi\Bundle\SearchBundle\Service\Search\Result\DefaultSearchResult,
    \Elastica_ResultSet
    \Elastica_Result;

class FOQElasticaSearch implements Search
{
    
    /**
     * @var Container
     */
    private $container;
    
    /*
     * @param FormFactory $formFactory
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container  = $container;
    } 
   
    /**
     * Search returns array of search results
     * 
     * @param string $index  - name of the indexed resource
     * @param string $term   - search term
     * @param int    $limit
     * @return SearchResultSet
     */    
    public function search($index, $term, $limit = null)
    {
        $elasticaType = $this->container->get('foq_elastica.index.'.$index);        
        $elasticaResultSet = $elasticaType->search($term, $limit);
        return $this->convertToSearchResult($elasticaResultSet);
    }
    
    /**
     * @param \Elastica_ResultSet $elasticaResultSet
     * @return \Xi\Bundle\SearchBundle\Service\Search\Result\DefaultSearchResultSet 
     */
    protected function convertToSearchResult(\Elastica_ResultSet $elasticaResultSet)
    {
        $results = array();
        foreach($elasticaResultSet as $elasticaResult) {
            $results[] = new DefaultSearchResult(
                $elasticaResult->getIndex(),
                $elasticaResult->getType(),
                $elasticaResult->getId(),
                $elasticaResult->getScore(),
                $elasticaResult->getSource()
            );
        }
        return new DefaultSearchResultSet($results, $elasticaResultSet->getTotalHits(), $elasticaResultSet->getTotalTime());
    }
    
    /**
     * Find and returns array of searched entities
     * 
     * @param string $index  - name of the indexed resource
     * @param string $term   - search term
     * @param int    $limit
     * @return  array - array of entities
     */
    public function find($index, $term, $limit = null)
    {     
        $mapFinder = $this->container->get('foq_elastica.finder.'.$index);
        return $mapFinder->find($term, $limit);       
    }
    
    
}