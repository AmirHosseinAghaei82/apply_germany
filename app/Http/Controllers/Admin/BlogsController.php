<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddBlogsRequest;
use App\Services\Admin\BlogsService;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    
    protected $blogsService;

    public function __construct(BlogsService $blogsService)
    {

        $this->blogsService = $blogsService;
        
    }
    
    public function addBlog(AddBlogsRequest $request)
    {

        return $this->blogsService->addBlog($request);

    }

}
