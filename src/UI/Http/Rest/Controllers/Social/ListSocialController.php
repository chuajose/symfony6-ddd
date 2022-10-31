<?php

namespace App\UI\Http\Rest\Controllers\Social;

use App\Domain\Social\Response\SocialResponse;
use App\Domain\Social\SocialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListSocialController extends AbstractController
{
    private  SocialRepository $postRepository;

    /**
     * @param SocialRepository $postRepository
     */
    public function __construct(SocialRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    /**
     * @Route("social", name="listSocial", methods={"GET"})
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
                $items[]= (new SocialResponse($post))->toArray();
            }
        }
        return new JsonResponse([
            'items' => $items,
            'total' => $total
        ], Response::HTTP_OK);
    }
}