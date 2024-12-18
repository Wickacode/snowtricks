<?php

namespace App\Controller;

use App\Entity\Medias;
use App\Entity\Tricks;
use App\Entity\Comments;
use App\Form\TricksFormType;
use App\Form\CommentFormType;
use App\Repository\CommentsRepository;
use App\Repository\TricksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


class TricksController extends AbstractController
{
    #[Route('/{slug}', name: 'app_trick')]
public function showTrick(
    $slug,
    Request $request,
    TricksRepository $trickRepository,
    CommentsRepository $commentsRepository,
    EntityManagerInterface $manager
): Response {
    // Récupération du trick par son slug
    $trick = $trickRepository->findOneBySlug($slug);

    if (!$trick) {
        throw $this->createNotFoundException('Le trick demandé n\'existe pas.');
    }

    $idTrick = $trick->getId();

    // Pagination des commentaires
    $page = $request->query->getInt('page', 1); // Page actuelle
    $limit = 10; // Limite par page
    $paginator = $commentsRepository->getPaginateComments($idTrick, $page, $limit);

    $comments = $paginator->getIterator(); // Récupération des commentaires paginés
    $pagesNumber = ceil(count($paginator) / $limit); // Calcul du nombre total de pages

    // Nouveau commentaire
    $comment = new Comments();
    $form = $this->createForm(CommentFormType::class, $comment);
    $form->handleRequest($request);

    // Soumission du formulaire
    if ($form->isSubmitted() && $form->isValid()) {
        if (null === $this->getUser()) {
            $this->addFlash(
                'notice',
                'Vous devez être connecté ou avoir validé votre compte pour ajouter un commentaire.'
            );

            return $this->redirectToRoute('app_trick', ['slug' => $slug], Response::HTTP_SEE_OTHER);
        }

        $comment->setDateCreateCom(new \DateTime())
            ->setActiveCom(1)
            ->setTricks($trick)
            ->setUsers($this->getUser());

        $manager->persist($comment);
        $manager->flush();

        // Redirection après ajout du commentaire pour éviter une resoumission du formulaire
        return $this->redirectToRoute('app_trick', [
            'slug' => $slug,
            'page' => $page,
            'pagesNumber' => $pagesNumber,
        ]);
    }

    // Rendu de la vue
    return $this->render('tricks/trick.html.twig', [
        'controller_name' => 'TricksController',
        'trick' => $trick,
        'comments' => $comments,
        'formCreateComment' => $form->createView(),
        'page' => $page, // Page actuelle
        'pagesNumber' => $pagesNumber, // Nombre total de pages
    ]);
}


    #[Route('/trick/addTrick', name: 'app_newTrick')]
    public function addTrick(Request $request, SluggerInterface $slugger, EntityManagerInterface $manager): Response
    {
        $trick = new Tricks();
        $form = $this->createForm(TricksFormType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateCreateTrick = new \DateTime();
            $mainImage = $form->get('mainImg')->getData();

            $trick->setDateCreateTrick($dateCreateTrick)
                ->setDateUpdateTrick($dateCreateTrick)
                ->setActiveTrick(1)
                ->setUsers($this->getUser());

            if ($mainImage !== null) {
                $originalMainImage = pathinfo($mainImage->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeMainImage = $slugger->slug($originalMainImage);
                $mainImageFilename = 'img/upload/' . $safeMainImage . '-' . uniqid() . '.' . $mainImage->guessExtension();
                try {
                    $mainImage->move(
                        $this->getParameter('images_directory'),
                        $mainImageFilename
                    );
                } catch (FileException $e) {
                }

                $trick->setMainImg($mainImageFilename);
            } else {
                $trick->setMainImg('img/bg-banner.jpg');
            }

            $imagesGallery = $form->get('mediaImages')->getData();

            foreach ($imagesGallery as $image) {
                //generate a new file name
                $fichier = 'img/upload/' . md5(uniqid()) . '.' . $image->guessExtension();

                //copy the file in the file upload
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                //store the images in the database
                $img = new Medias();
                $img->setLink($fichier)
                    ->setType('image');
                $trick->addMedia($img);
            }
            $linkVideo = $form->get('mediaVideo')->getData();

            if ($linkVideo !== null) {
                $video = new Medias();
                $video->setLink($linkVideo)
                    ->setType('video');
                $trick->addMedia($video);
            }

            $manager->persist($trick);
            $manager->flush();
            $this->addFlash('success', 'Votre trick a été ajouté avec succés');
            return $this->redirectToRoute('app_newTrick');
        }

        return $this->render('tricks/addTrick.html.twig', [
            'controller_name' => 'TricksController',
            'addTrickForm' => $form,
        ]);
    }

    #[Route('/trick/updateTrick/{slug}', name: 'app_updateTrick')]
    public function updateTrick($slug): Response
    {
        return $this->render('tricks/modify-trick.html.twig', [
            'controller_name' => 'TricksController',
        ]);
    }

    #[Route('/deleteTrick/{slug}', name: 'app_deleteTrick')]
    public function deleteTrick($slug, Request $request, TricksRepository $tricksRepository): Response
    {
        $trick = $tricksRepository->findOneBy(['slug' => $slug]);

        if (!$trick) {
            throw $this->createNotFoundException('Trick not found');
        }

        $user = $this->getUser();
        $userTrick = $trick->getUsers();
        $idTrick = $userTrick->getId();


        $idUser = $user->getId();
        $userRoles = $user->getRoles();

        if ($idUser !== null && ($idUser == $idTrick || $user->isAdmin())) {
            $tricksRepository->remove($trick, true);
        }

        return $this->redirectToRoute('app_home');
    }

}
