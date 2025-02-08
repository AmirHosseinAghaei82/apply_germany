<?php 

namespace App\Repositories\Admin;

use App\Models\Blog;

class BlogsRepository 
{

    public function addBlog(array $data)
    {

        return Blog::create($data);

    }



}