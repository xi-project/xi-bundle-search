<?php

namespace Xi\Bundle\SearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchType extends AbstractType
{

    /**
     * @param  FormBuilderInterface $builder
     * @param  array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('options',    'hidden')
            ->add('index',      'hidden')
            ->add('searchType', 'hidden')
            ->add('page',       'hidden')
            ->add('term',       'text',         array('label' => 'search.form.term.label'));         
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'xi_searchbundle_searchtype';
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Xi\Bundle\SearchBundle\Form\Model\SearchModel',
        ));
    }

}
