<?php

namespace Xi\Bundle\SearchBundle\Twig\Extensions;

interface SearchRenderer
{
    /**
     * @param type $data
     * @param type $options 
     */
    public function searchRenderer($data, $options);

}