<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType as SymfonySearchType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('query', SymfonySearchType::class, [
                'label' => 'Recherche',
                'attr' => [
                    'placeholder' => 'Recherchez un produit...',
                    'name'=> 'search'
                ],
            ]);
    }
}
