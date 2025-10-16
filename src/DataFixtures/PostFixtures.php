<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostFixtures extends Fixture
{
    public function __construct(private readonly SluggerInterface $slugger)
        {

        }
    public function load(ObjectManager $manager): void
    {
        // Instanciation de Faker
        $faker = Factory::create();
        // Récupérer les objets Category
        $categories = $manager->getRepository(Category::class)->findAll();
        for($i = 1; $i <= 30; $i++) {
           $post = new Post();
           $post->setTitle($faker->sentence(3))
                ->setContent($faker->paragraphs(3, true))
                ->setCreatedAt((\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-60 days', 'now'))))
                ->setEditedAt((\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-20 days', 'now'))))
                ->setImage($i.'.jpg')
                ->setIsPublished($faker->boolean(90))
                ->setCategory($categories[array_rand($categories)])
                ->setSlug($this->slugger->slug($post->getTitle()));
            $manager->persist($post);
        }
        $manager->flush();
    }
}
