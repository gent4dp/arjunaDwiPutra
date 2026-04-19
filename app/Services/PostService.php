// app/Services/PostService.php

namespace App\Services;

use App\Models\Post;
use Exception;

class PostService
{
    public function create(array $data): Post
    {
        return Post::create($data);
    }

    public function getAll()
    {
        return Post::all();
    }

    public function update(Post $post, array $data): Post
    {
        $post->update($data);
        return $post;
    }

    public function delete(Post $post): bool
    {
        return $post->delete();
    }
}