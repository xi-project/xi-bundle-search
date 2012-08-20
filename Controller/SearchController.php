<?php

namespace Xi\Bundle\SearchBundle\Controller;

use Xi\Bundle\AjaxBundle\Controller\JsonResponseController as Controller,
    Xi\Bundle\SearchBundle\Service\SearchService;


class SearchController extends Controller
{
    
    public function searchAction()
    {       
        $self       = $this;
        $service    = $this->getSearchService();
        $config     = $this->container->getParameter('xi_search');

        return $this->processForm($service->getSearchForm(), function($form) use($self, $service, $config) {
            $data = $form->getData();

            $limit = isset($config['default_limit']) ? $config['default_limit'] : null;

            if($data->getSearchType() == 'search'){
                $results = $service->search($data->getIndex(), $data->getTerm(), $limit);
            } elseif($data->getSearchType() == 'find') {
                $results = $service->find($data->getIndex(), $data->getTerm(), $limit);
            }

            $resultHtml = $self->renderView('XiSearchBundle:Search:search.html.twig', array(
                'results' => $results, 'index' => $data->getIndex(), 'options' => json_decode($data->getOptions())
            ));

            return $self->createJsonSuccessWithContent($resultHtml, 'xiSearchResultCallback');          
        });
    }
 
    /**
     * @return SearchService
     */
    public function getSearchService()
    {
        return $this->container->get('xi_search.service.search');
    }
}
