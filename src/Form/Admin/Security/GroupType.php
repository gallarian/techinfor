<?php

/**
 * @Author: Gallarian <gallarian@gmail.com>
 */

namespace App\Form\Admin\Security;

use App\Entity\Security\Group;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options["edit"]) {
            $builder->setMethod("PATCH");
        }

        $builder
            ->add("name", TextType::class, [
                "attr" => [
                    "autofocus" => true
                ]
            ])
            ->add("description", TextType::class)
            ->add("isActivate", CheckboxType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                "data_class" => Group::class,
                "edit" => false,
                "attr" => [
                    "novalidate" => true
                ]
            ])
            ->setAllowedTypes("edit", "bool");
    }
}
