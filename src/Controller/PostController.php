<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    #[Route('/posts', name: 'app_posts')]
    public function posts(PostRepository $repository, CategoryRepository $categoryRepository ): Response
    {
        //$posts = $repository->findAll();
        $posts = $repository->findBy(
            ['isPublished' => true],
            ['createdAt' => 'DESC']
        );
        $categories = $categoryRepository->findAll();
        //dd($posts);
        return $this->render('post/posts.html.twig', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    #[Route('/post/{slug}', name: 'app_post')]
    public function post(PostRepository $repository, string $slug): Response
    {
        $post = $repository->findOneBy(['slug' => $slug]);
        //dd($post);
        return $this->render('post/post.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/posts/{category}', name: 'app_posts_cat')]
    public function postsCat($category, PostRepository $repository): Response
    {
//        Double requête (pas bien)
//        $category = $categoryRepository->findOneBy(['slug' => $slug]);
//        $posts = $repository->findBy([
//            'category'          => $category->getId(),
//            'isPublished'   => true,],
//            ['createdAt' => 'DESC']);
        // utilisation de la requête findByCategory du PostRepository
        $posts = $repository->findByCategory($category);
        return $this->render('post/posts.html.twig', [
            'posts' => $posts,
        ]);
    }
}
