<?php

namespace App\Form;

use App\Entity\Feed;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Defines the form for inscriptions.
 */
class FeedType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', TextType::class, [
                'label' => 'Titulo',
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Descripción',
            ])
            ->add('image', TextareaType::class, [
                'label' => 'Imagen',
            ])
            ->add('source', TextType::class, [
                'label' => 'Fuente',
            ])
            ->add('publisher', TextType::class, [
                'label' => 'Periodico',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Feed::class,
        ]);
    }
}