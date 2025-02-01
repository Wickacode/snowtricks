<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPasswordFormType;
use App\Form\ResetPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/forgot-password', name: 'app_forgot_password')]
    public function forgotPassword(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ForgotPasswordFormType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $email = $form->get('email')->getData();
                $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    
                if ($user) {
                    $resetToken = bin2hex(random_bytes(32));
                    $user->setResetToken($resetToken);
                    $expiration = (new \DateTime())->modify('+1 hour');
                    $user->setResetTokenExpiresAt($expiration);
    
                    $entityManager->flush();
    
                    $emailMessage = (new TemplatedEmail())
                        ->from('no-reply@votre-domaine.com')
                        ->to($email)
                        ->subject('Réinitialisation de votre mot de passe')
                        ->htmlTemplate('security/resetPasswordEmail.html.twig')  // Mise à jour du chemin ici
                        ->context([
                            'resetToken' => $resetToken,
                            'expiration' => $expiration
                        ]);
    
                    $mailer->send($emailMessage);
    
                    $this->addFlash('success', 'Un email vous a été envoyé avec les instructions pour réinitialiser votre mot de passe.');
                    return $this->redirectToRoute('app_login');
                } else {
                    $this->addFlash('danger', 'Aucun utilisateur trouvé avec cet email.');
                }
            } else {
                $this->addFlash('danger', 'Le formulaire contient des erreurs.');
            }
        }
    
        return $this->render('auth/forgotPassword.html.twig', [
            'forgotPasswordForm' => $form->createView(),
        ]);
    }
    

    #[Route('/reset-password/{token}', name: 'app_reset_password')]
public function resetPassword(
    string $token,
    Request $request,
    EntityManagerInterface $entityManager,
    UserPasswordHasherInterface $passwordHasher
    ): Response {
    // Trouver l'utilisateur avec le token
    $user = $entityManager->getRepository(User::class)->findOneBy(['resetToken' => $token]);

    // Si l'utilisateur n'existe pas ou le token est invalide
    if (!$user || !$user->isResetTokenValid()) {
        $this->addFlash('error', 'Le lien est invalide ou a expiré.');
        return $this->redirectToRoute('app_forgot_password');
    }

    // Création du formulaire de réinitialisation du mot de passe
    $form = $this->createForm(ResetPasswordFormType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Récupérer le mot de passe
        $newPassword = $form->get('password')->getData();
        $confirmPassword = $form->get('confirmPassword')->getData();

        // Vérifiez si les mots de passe correspondent
        if ($newPassword !== $confirmPassword) {
            $this->addFlash('danger', 'Les mots de passe ne correspondent pas.');
            return $this->redirectToRoute('app_reset_password', ['token' => $token]);
        }

        // Hacher le mot de passe et l'enregistrer
$hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
        $user->setPassword($hashedPassword);

        // Supprimer les informations de réinitialisation du mot de passe
        $user->setResetToken(null);
        $user->setResetTokenExpiresAt(null);

        // Sauvegarder les changements
        $entityManager->flush();

        // Message de succès
        $this->addFlash('success', 'Votre mot de passe a été mis à jour.');

        // Rediriger vers la page de connexion
        return $this->redirectToRoute('app_login');
    }

    // Retourner le formulaire
    return $this->render('security/resetPassword.html.twig', [
        'resetPasswordForm' => $form, // Assurez-vous de passer form ici
        'token' => $token,
    ]);
}

    
}
