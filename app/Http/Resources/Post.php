<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Tag as TagResource;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\PostUser as PostUserResource;
use App\Http\Resources\Comment as CommentResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'meta_title' => $this->meta_title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'content' => $this->content,
            'published' => $this->published,
            'thumbnail' => $this->thumbnail,
            'author_id' => $this->author_id,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
            'author' => new PostUserResource($this->whenLoaded('user')),
            'post_comment' => CommentResource::collection($this->whenLoaded('post_comment')),
            'author' => new UserResource($this->whenLoaded('author')),
            'tag' =>  TagResource::collection($this->whenLoaded('tag')),
            'category' =>  CategoryResource::collection($this->whenLoaded('category')),
        ];
    }
}
