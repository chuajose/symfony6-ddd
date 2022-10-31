<?php

namespace App\UI\Http\Rest\Controllers\Post;

use App\Domain\File\Model\File;
use App\Domain\Post\Model\Post;
use App\Domain\Post\PostRepository;
use Exception;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddPostController extends AbstractController
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
     * @Route("post", name="addPost", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        $data =  $request->request->all();

        $file = File::create(Uuid::uuid4(), 'imagen', 'imagen', 'png', '/', 'public');
        $post = Post::create($data['title']??'Sin titulo', $file);
        $this->postRepository->save($post);
        return new JsonResponse([], Response::HTTP_OK);

    }

}