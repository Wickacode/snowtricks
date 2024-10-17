<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Tricks;
use App\Entity\Comments;
use App\Entity\Categories;
use App\Entity\Medias;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [];
        $categories = [];
        $categoriesName = ['Grab', 'Rotation', 'Flip', 'Rotation désaxée', 'Slide', 'One foot trick', 'Old school'];
        $tricksName = ['Mute', 'Indy', 'Melon grab', 'Rodeo', '360', '720', 'Clippler', 'Misty', 'Tail slide', 'Method air'];
        $tricksContent = [
            "Un tour complet (360 degrés) dans les airs",
            "Salto arrière dans les airs",
            "Saut en utilisant la flexion du snowboard pour prendre de l'altitude",
            "Rotation avant de 540 degrés (une rotation et demie)",
            "Attraper l’arrière du snowboard en plein saut",
            "Prendre le milieu du snowboard tout en l'inclinant verticalement",
            "Une rotation combinée avec une inversion du corps, souvent arrière",
            "Exécuter une figure en position inversée (avant/arrière)",
            "S’appuyer sur l’avant ou l’arrière du snowboard pour glisser en pivotant",
            "Deux rotations inversées combinées avec un spin"
        ];

        $commentsContent = [
            "Super contrôle dans la rotation, atterrissage bien maîtrisé !",
            "Impressionnant, rotation rapide et une superbe réception !",
            "Simple mais efficace, parfaite maîtrise du pop !",
            "Belle fluidité dans la rotation, l'atterrissage aurait pu être plus propre.",
            "Beau grab bien stylé, reste en contrôle durant tout le vol !",
            "Une classique parfaitement exécutée, style au top !",
            "Super technique et fluide, les rotations complexes sont bien gérées !",
            "Exécution en switch impressionnante, on voit que tu maîtrises les deux pieds !",
            "Technique fluide, belle transition entre les pivots avant et arrière.",
            "Wow, incroyable ! Super maîtrise des rotations et des inversions, tout en fluidité !"
        ];

        // $user = new User();
        // $user->setUsername('admin')
        //      ->setEmail($faker->safeEmail)
        //      ->setPassword($this->passwordHasher->hashPassword($user, 'azerty'))
        //      ->setDateCreate($faker->dateTimeBetween('-6 months'))
        //      ->setDateUpdate(new \Datetime);
        // if ($i == 0) {
        //     $user->setRoles(['ROLE_ADMIN']);
        // } else {
        //     $user->setRoles(['ROLE_USER']);
        // }
        // $user->setIsActive(true)
        //     ->setAvatar('img/upload/avatars/avatar' . $faker->numberBetween(1, 3) . '.png');
        // $manager->persist($user);
        // $users[] = $user;
    }
}