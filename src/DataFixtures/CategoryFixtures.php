<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    private array $categories = ['PHP 8', 'IA', 'Symfony', 'Laravel', 'Security', 'Angular', 'JavaScript',];

    public function __construct(private readonly SluggerInterface $slugger)
    {

    }
    public function load(ObjectManager $manager): void
    {
        foreach($this->categories as $category) {
            $cat = new Category();
            $cat->setName($category)
                ->setSlug($this->slugger->slug($cat->getName()))
                ->setTest('Hello');
            $manager->persist($cat);
        }
        $manager->flush();
    }
}
