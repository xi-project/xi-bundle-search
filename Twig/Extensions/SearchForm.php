<?php

namespace Xi\Bundle\SearchBundle\Twig\Extensions;

use \Twig_Environment,
    \Twig_Error_Runtime,
    Xi\Bundle\SearchBundle\Service\SearchService,
    Xi\Bundle\SearchBundle\Service\Search\Result\SearchResult,
    Xi\Bundle\SearchBundle\Twig\Extensions\SearchRenderer,
    Xi\Bundle\SearchBundle\Entity\SearchType;

class SearchForm extends \Twig_Extension
{

    /**
     * @var Twig_Environment
     */
    protected $twig;
    
    /**
     * @var SearchService
     */
    protected $searcheService;
    
    /**
     * @var array
     */
    protected $config;
  
    /**
     * @param Twig_Environment $twig
     * @param SearchService $searchService
     */
    public function __construct(Twig_Environment $twig, SearchService $searchService, $config)
    {
        $this->twig          = $twig;
        $this->searchService = $searchService;
        $this->config        = $config;
    }
    
    /**
     *  @return array
     */
    public function getFunctions()
    {
        return array(
            'xi_search_form' => new \Twig_Function_Method(
            $this, 'searchForm', array('is_safe' => array('html'))
            ),
            'xi_find_form' => new \Twig_Function_Method(
            $this, 'findForm', array('is_safe' => array('html'))
            ),            
            'xi_search_result' => new \Twig_Function_Method(
            $this, 'searchResult', array('is_safe' => array('html'))
            )
        );
    }
    
    /**
     * For default search
     * @param string $index
     * @param array e $options 
     */
    public function searchForm($index, $options = array())
    {   
        return $this->renderForm($index, $options, 'search');
    }
 
    /**
     * if you like to have search results converted to entities
     * @param string $index
     * @param array e $options
     * @return string
     */    
    public function findForm($index, $options = array())
    {   
        return $this->renderForm($index, $options, 'find');
    }
    
    private function renderForm($index, $options, $searchType)
    {
        $form = $this->searchService->getSearchForm();
        $form->get('options')->setData(json_encode($options));
        $form->get('index')->setData($index);
        $form->get('searchType')->setData($searchType);
        return $this->twig->render('XiSearchBundle:SearchForm:searchform.html.twig',
            array('form' => $form->createView()));       
    }

    /**
     * @param mixed $result
     * @param array $options
     * @return string
     */
    public function searchResult($result, $options)
    {   
        if($result instanceof SearchResult){
            $type = $result->getType();    
        } elseif($result instanceof SearchType){
            $type = $result->getSearchType();
        } else {
            return "Unknown result type";
        }
        
        $extensionName = $this->config['result_renderer_extensions'][$type];       
        try {         
           $extension = $this->twig->getExtension($extensionName);   
        } catch(Twig_Error_Runtime $e) {
            return "Extension ".$extensionName." not found for type: ".$type;
        }
        if(!($extension instanceof SearchRenderer)){
            return "Extension ".$extensionName." should implement interface: SearchRenderer";
        }
        
        return $extension->searchRenderer($result, $options);
    }
    
    /**
     * @return string 
     */
    public function getName()
    {
        return 'search_form_extension';
    }
}