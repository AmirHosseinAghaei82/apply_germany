<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddBlogRequest;
use App\Http\Requests\Admin\EditBlogRequest;
use App\Services\Admin\BlogsService;

class BlogsController extends Controller
{
    
    protected $blogsService;

    public function __construct(BlogsService $blogsService)
    {

        $this->blogsService = $blogsService;
        
    }
    
    public function addBlog(AddBlogRequest $request)
    {

        return $this->blogsService->addBlog($request);

    }

    public function blogs()
    {

        return $this->blogsService->blogs();

    }

    public function blog($alias_title)
    {

        return $this->blogsService->blog($alias_title);

    }

    public function editBlog(EditBlogRequest $request, $id)
    {

        return $this->blogsService->editBlog($request, $id);

    }

    public function deleteBlog($id)
    {

        return $this->blogsService->deleteBlog($id);

    }



}
