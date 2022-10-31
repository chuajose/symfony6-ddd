<?php

namespace App\UI\Http\Rest\Controllers\Post;

use App\Domain\Post\Response\PostResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Domain\Post\PostRepository;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListPostController extends AbstractController
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
     * @Route("post", name="listPost", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        [$posts, $total] = $this->postRepository->search();
        $items = [];
        if($total > 0){
            foreach ($posts as $post){
                $items[]= (new PostResponse($post))->toArray();
            }
        }
        return new JsonResponse([
            'items' => $items,
            'total' => $total
        ], Response::HTTP_OK);
    }
}