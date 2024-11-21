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

        //Fake admin
        $user = new User();
        $user->setUsername('admin')
            ->setEmail('admin@gmail.com')
            ->setPassword($this->passwordHasher->hashPassword($user, 'snowtricks2024'))
            ->setDateCreateUser(new \Datetime)
            ->setDateUpdateUser(new \Datetime)
            ->setRoles(['ROLE_ADMIN'])
            ->setAvatar('img/upload/avatars/jimmy.png')
            ->setVerified(isVerified: true);
        $manager->persist($user);
        $users[] = $user;

        //Fake user
        $user = new User();
        $user->setUsername('user')
            ->setEmail('user@gmail.com')
            ->setPassword($this->passwordHasher->hashPassword($user, 'snowtricks2024'))
            ->setDateCreateUser(new \Datetime)
            ->setDateUpdateUser(new \Datetime)
            ->setRoles(['ROLE_USER'])
            ->setAvatar('img/upload/avatars/cute.jpg')
            ->setVerified(isVerified: true);
        $manager->persist($user);
        $users[] = $user;

        //Fake categories
        foreach ($categoriesName as $categoryName) {
            $category = new Categories();
            $category->setNameCat($categoryName);
            $manager->persist($category);
            $categories[] = $category;
        }

        // Fake tricks
        for ($i = 0; $i < 10; $i++) {
            $trick = new Tricks();
            $trick->setTitleTrick($tricksName[$i])
                ->setContentTrick($tricksContent[$i])
                ->setDateCreateTrick(new \Datetime)
                ->setDateUpdateTrick(new \Datetime)
                ->setActiveTrick(true)
                ->setUsers($users[0])
                ->setCategories($categories[1])
                ->setMainImg('img/upload/' . $trick->getTitleTrick() . '_1.jpg');
            $manager->persist($trick);
        //Fake medias
        for ($k = 2; $k < 5; $k++) {
            $image = new Medias();
            $image->setLink('img/upload/' . $trick->getTitleTrick() . '_' . $k . '.jpg')
                ->setType('image')
                ->setTricks($trick);
            $manager->persist($image);
        }

        $video = new Medias();
        $video->setLink('https://www.youtube.com/watch?v=PxhfDec8Ays')
            ->setType('video')
            ->setTricks($trick);
        $manager->persist($video);


        // Fake comments by trick
        for ($j = 0; $j <= 5; $j++) {
            $randomKey = array_rand($users);
            $randomUser = $users[$randomKey];

            $comment = new Comments();
            $comment->setContentCom($commentsContent[$j])
                ->setDateCreateCom(new \Datetime)
                ->setActiveCom(true)
                ->setUsers($randomUser)
                ->setTricks($trick);
            $manager->persist($comment);

        }
    }
        $manager->flush();

    }

}