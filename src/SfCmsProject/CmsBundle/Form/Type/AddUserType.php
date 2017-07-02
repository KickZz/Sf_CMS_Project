<?php

namespace SfCmsProject\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AddUserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('plainTextPassword')
            ->add('signature')
            ->add('roles', ChoiceType::class, array(
                'expanded' => false,
                'multiple' => true,
                'choices' => array(
                    'Editeur' => 'ROLE_EDITEUR',
                    'Administrateur' => 'ROLE_ADMIN',
                    'Aucun' => 'Aucun'
                )));
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SfCmsProject\CmsBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sfcmsproject_cmsbundle_adduser';
    }

}
