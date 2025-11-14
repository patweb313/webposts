<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class AdminPostController extends AbstractController
{
    public function __construct(private readonly SluggerInterface $slugger)
    {

    }

    #[Route('/admin/posts', name: 'app_admin_posts')]
    public function viewposts(PostRepository $repository): Response
    {
        $posts = $repository->findBy(
            [],
            ['createdAt' => 'DESC']);
        return $this->render('admin/post/post.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/admin/newpost', name: 'app_admin_newpost')]
    public function newPost(Request $request, EntityManagerInterface $manager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post   -> setUser($this->getUser()) // Ajoute l'id du user qui poste l'article
                    -> setCreatedAt(new \DateTimeImmutable())
                    -> setEditedAt(new \DateTimeImmutable())
                    -> setSlug($this->slugger->slug($post->getTitle()));
            $manager->persist($post);
            $manager->flush();
            $this->addFlash(
                'success',
                'L\'Article a bien été ajouté',
            );
            return $this->redirectToRoute('app_admin_posts');
        }
        return $this->render('admin/post/newpost.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/delpost/{id}', name: 'app_admin_delpost')]
    public function delpost(Post $post, EntityManagerInterface $manager): Response
    {   // ParamConverter
        $manager->remove($post);
        $manager->flush();
        return $this->redirectToRoute('app_admin_posts');
    }

    #[Route('/admin/editpost/{id}', name: 'app_admin_editpost')]
    public function editPost(Request $request, EntityManagerInterface $manager, Post $post): Response
    {
       $form = $this->createForm(PostType::class, $post);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $post-> setEditedAt(new \DateTimeImmutable());
           $manager->flush();
           return $this->redirectToRoute('app_admin_posts');
       }
       return $this->render('admin/post/editpost.html.twig', [
           'form' => $form,
           'post' => $post,
       ]);
    }

    #[Route('/admin/viewpost/{id}', name: 'app_admin_viewpost')]
    public function viewPost(Post $post, EntityManagerInterface $manager): Response
    {
        $post   ->setIsPublished(!$post->isPublished())
                ->setEditedAt(new \DateTimeImmutable());
        $manager->flush();
        return $this->redirectToRoute('app_admin_posts');
    }

}
