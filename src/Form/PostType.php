<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use App\Repository\CategoryRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class PostType extends AbstractType
{
    // Constructeur pour instancier le CategoryRepository
    public function __construct(private readonly CategoryRepository $categoryRepository)
    {

    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // On récupère les categories triées pour la liste déroulante
        $categories = $this->categoryRepository->getCategories();
        //dd($categories);
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'article',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu de l\'article',
            ])
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'asset_helper' => true,
                'label' => 'Image',
            ])
            ->add('isPublished', CheckboxType::class, [
                'label' => 'Publier l\'article',
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => Category::class,
//                'query_builder' => function (CategoryRepository $er): QueryBuilder {
//                    return $er->createQueryBuilder('c')
//                        ->orderBy('c.name', 'ASC');
//                },
                'choices' => $categories, // ici on passe la liste déjà triée
                'choice_label' => function(Category $categories) {
                    return $categories->getName();
                },
                'placeholder' => 'Choisissez une categorie',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
