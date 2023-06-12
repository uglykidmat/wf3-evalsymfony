<?php

namespace App\Form;

use App\Entity\Vehicule;
use App\Entity\Conducteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ConducteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => true,
                'constraints' => [new Assert\Length(['min' => 2]), new NotBlank()],
                'label' => "Nom",
                'attr' => ["placeholder" => "Nom..."] 
            ])
            ->add('prenom', TextType::class, [
                'required' => true,
                'constraints' => [new Assert\Length(['min' => 3]), new NotBlank()],
                'label' => "Prénom",
                'attr' => ["placeholder" => "Prénom..."] 
            ])
            // todo finir truc
            ->add('relationvehicule', EntityType::class, [
                // looks for choices from this entity
                'class' => Vehicule::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'immatriculation',
            
                // used to render a select box, check boxes or radios
                  'multiple' => true,
                // 'expanded' => true,
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conducteur::class,
        ]);
    }

    public function validateForm(ValidatorInterface $validator)
    {
        $conducteur = new Conducteur();
        $errors = $validator->validate($conducteur);

        if (count($errors) > 0) {
            /*
            * Uses a __toString method on the $errors variable which is a
            * ConstraintViolationList object. This gives us a nice string
            * for debugging.
            */
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        return new Response("Le conducteur est valide !");
    }
}
