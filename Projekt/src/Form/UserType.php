<?php


namespace App\Form;


use App\Entity\Role;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("firstname",TextType::class)
            ->add('middlename', TextType::class, [
                'required' => false
            ])
            ->add('lastname', TextType::class)
            ->add('password', TextType::class);
    }
}