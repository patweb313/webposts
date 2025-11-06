<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserFixtures extends Fixture
{
    private object $hasher;
    private array $genders = ['male', 'female'];
    public function __construct(UserPasswordHasherInterface $hasher, private readonly SluggerInterface $slugger)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for($i = 10; $i <= 60; $i++) {
            $gender = $faker->randomElement($this->genders);
            $user = new User;
            $user   ->setFirstName($faker->firstName($gender))
                    ->setLastName($faker->lastName)
                    ->setEmail($this->slugger->slug($user->getFirstName().'.'.$this->slugger->slug($user->getLastName())).'@'.$faker->domainName.'.'.$faker->domainName());
            $gender = $gender == 'male' ? 'm' : 'f';
            $user   ->setImageName('0'.$i. $gender.'.jpg')
                    ->setPassword($this->hasher->hashPassword($user, 'password'))
                    ->setIsDisabled($faker->boolean(10))
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setUpdatedAt(new \DateTimeImmutable())
                    ->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }
        $manager->flush();

        // Admin John Doe
        $user = new User();
        $user   ->setFirstName('John')
            ->setLastName('Doe')
            ->setEmail('john.doe@gmail.com')
            ->setImageName('062m.jpg')
            ->setPassword($this->hasher->hashPassword($user, 'password'))
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setIsDisabled(false)
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
        $manager->flush();

        // Admin Pat Mar
        $user = new User();
        $user   ->setFirstName('Pat')
            ->setLastName('Mar')
            ->setEmail('pat.mar@gmail.com')
            ->setImageName('063m.jpg')
            ->setPassword($this->hasher->hashPassword($user, 'password'))
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setIsDisabled(false)
            ->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($user);
        $manager->flush();

        // Admin Steve Chang
        $user = new User();
        $user   ->setFirstName('Steve')
                ->setLastName('Chang')
                ->setEmail('steve.chang@gmail.com')
                ->setImageName('064m.jpg')
                ->setPassword($this->hasher->hashPassword($user, 'password'))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setIsDisabled(false)
                ->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($user);
        $manager->flush();
    }
}
