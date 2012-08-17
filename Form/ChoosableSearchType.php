<?php

namespace Xi\Bundle\SearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChoosableSearchType extends SearchType
{

    private $choices = array();

    public function __construct($choices)
    {
        $this->choices = $choices;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('options', 'hidden')
            ->add('index',      'choice',       array('choices' => $this->choices, 'expanded' => true, 'label' => 'xi_search.choose-index'))
            ->add('searchType', 'hidden')
            ->add('term',       'text',         array('label' => 'search.form.term.label'));
    }

}
