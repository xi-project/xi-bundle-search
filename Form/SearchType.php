<?php

namespace Xi\Bundle\SearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SearchType extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {     
        $builder
            ->add('options',    'hidden')
            ->add('index',      'hidden')
            ->add('searchType', 'hidden')
            ->add('term',       'text',         array('label' => 'search.form.term.label'));         
    }

    public function getName()
    {
        return 'xi_searchbundle_searchtype';
    }
   
    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'Xi\SearchBundle\Form\Model\SearchModel');
    }
  
}
