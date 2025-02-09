<?php 

namespace App\Repositories\Admin;

use App\Models\Blog;

class BlogsRepository 
{

    public function addBlog(array $data)
    {

        return Blog::create($data);

    }

    public function blogs()
    {

        return Blog::all();

    }

    public function blog($identifier)
    {

        return Blog::where('alias_title', $identifier)
                   ->OrWhere('id', $identifier)
                   ->first();

    }

    public function editBlog($blog, $updateData)
    {

        return $blog->update($updateData);

    }

    public function deleteBlog($blog)
    {

        return $blog->delete();

    }



}