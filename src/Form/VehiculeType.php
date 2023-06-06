<?php

namespace App\Form;


use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque', TextType::class, [
                'required' => true,
                'constraints' => [new Assert\Length(['min' => 3]), new NotBlank()],
                'label' => "Marque",
                'attr' => ["placeholder" => "Marque..."] 
            ])
            ->add('modele', TextType::class, [
                'required' => true,
                'constraints' => [new Assert\Length(['min' => 3]), new NotBlank()],
                'label' => "Modèle",
                'attr' => ["placeholder" => "Modèle..."] 
            ])
            ->add('couleur', TextType::class, [
                'required' => true,
                'constraints' => [new Assert\Length(['min' => 3]), new NotBlank()],
                'label' => "Couleur",
                'attr' => ["placeholder" => "Couleur..."] 
            ])
            ->add('immatriculation', TextType::class, [
                'required' => true,
                'constraints' => [new Assert\Length(['min' => 3]), new NotBlank()],
                'label' => "Immatriculation",
                'attr' => ["placeholder" => "Immatriculation..."] 
            ])
            ->add('relationconducteur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
    
    public function validateForm(ValidatorInterface $validator)
    {
        $vehicule = new Vehicule();
        $errors = $validator->validate($vehicule);

        if (count($errors) > 0) {
            /*
            * Uses a __toString method on the $errors variable which is a
            * ConstraintViolationList object. This gives us a nice string
            * for debugging.
            */
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        return new Response("Le vehicule est valide !");
    }
}
