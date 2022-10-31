<?php

namespace App\UI\Http\Web\Controllers;

use App\Domain\File\Model\File;
use App\Domain\Post\Model\Post;
use App\Domain\Post\Model\PostFiles;
use App\Domain\Post\PostRepository;
use App\Domain\Shared\Collection;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebController extends  AbstractController
{
    private  PostRepository $postRepository;

    /**
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }


    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {

        //https://www.instagram.com/p/BHisJLwAEeU/?utm_source=ig_embed
        //https://twitter.com/n03m1ms/status/1490966469169283075
        // $embed = $this->oembed->get('https://www.instagram.com/p/BHisJLwAEeU/?utm_source=ig_web_copy_link');


        // dd($embed);
        return $this->render('home/index.html.twig', []);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request): Response
    {
        $file = File::create(Uuid::uuid4(), 'imagen', 'imagen', 'png', '/', 'public');
        $post = Post::create('mi title', $file);
        $file1 = File::create(Uuid::uuid4(), 'imagen1', 'imagen', 'png', '/', 'public');
        $file2 = File::create(Uuid::uuid4(), 'imagen2', 'imagen', 'png', '/', 'public');

        $post->setFiles([new PostFiles($post, $file1), new PostFiles($post, $file2)]);
        $this->postRepository->save($post);
        return $this->render('home/index.html.twig', []);
    }
    /**
     * @Route("/addPostFile", name="addPostFile")
     */
    public function addPostFile(Request $request): Response
    {

        $post = $this->postRepository->find(Uuid::fromString('84fe5970-dc70-4087-956f-3cd331dc4e29'));
        if($post){
            throw new \Exception('post not found');
        }
        $file1 = File::create(Uuid::uuid4(), 'imagen3', 'imagen', 'png', '/', 'public');
        $file2 = File::create(Uuid::uuid4(), 'imagen4', 'imagen', 'png', '/', 'public');
        $post->setFiles([new PostFiles($post, $file1), new PostFiles($post, $file2)]);
        $this->postRepository->save($post);
        return $this->render('home/index.html.twig', []);
    }

    /**
     * @Route("/list", name="list")
     */
    public function list(Request $request): Response
    {

        //https://www.instagram.com/p/BHisJLwAEeU/?utm_source=ig_embed
        //https://twitter.com/n03m1ms/status/1490966469169283075
        // $embed = $this->oembed->get('https://www.instagram.com/p/BHisJLwAEeU/?utm_source=ig_web_copy_link');


        [$posts, $total] = $this->postRepository->search();

        return $this->render('home/list.html.twig', ['posts' => $posts, 'total' => $total]);
    }
}