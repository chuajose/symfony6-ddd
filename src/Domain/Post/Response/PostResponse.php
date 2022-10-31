<?php

namespace App\Domain\Post\Response;

use App\Domain\File\Response\FileResponse;
use App\Domain\Post\Model\Post;

class PostResponse
{

    private Post $post;

    /**
     * @param Post $post
     */
    public function __construct(Post $post)
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