<?php

namespace App\Domain\Social\Response;

use App\Domain\File\Response\FileResponse;
use App\Domain\Social\Model\Social;

class SocialResponse
{

    private Social $post;

    /**
     * @param Social $post
     */
    public function __construct(Social $post)
    {
        $this->post = $post;
    }

    public function toArray(){

        return [
            'id' => $this->post->id(),
            'title' => $this->post->title(),
            'file' => (new FileResponse($this->post->file()))->toArray()

        ];
    }


}