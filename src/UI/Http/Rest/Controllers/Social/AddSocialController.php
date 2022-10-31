<?php

namespace App\UI\Http\Rest\Controllers\Social;

use App\Domain\File\Model\File;
use App\Domain\Social\Model\Social;
use App\Domain\Social\SocialRepository;
use Exception;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddSocialController extends AbstractController
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
     * @Route("social", name="addSocial", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        $data =  $request->request->all();

        $file = File::create(Uuid::uuid4(), 'imagen', 'imagen', 'png', '/', 'public');
        $post = Social::create($data['title']??'Sin titulo', $file);
        $this->postRepository->save($post);
        return new JsonResponse([], Response::HTTP_OK);

    }

}