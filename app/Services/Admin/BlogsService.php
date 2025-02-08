<?php 

namespace App\Services\Admin;

use App\Http\Requests\Admin\AddBlogsRequest;
use App\Repositories\Admin\BlogsRepository;
use App\Services\HelperService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BlogsService 
{

    protected $blogsRepository;

    public function __construct(BlogsRepository $blogsRepository)
    {

        $this->blogsRepository = $blogsRepository;
        
    }

    public function addBlog(AddBlogsRequest $request)
    {

        DB::beginTransaction();

        try {

            $upload = null;

            if($request->hasFile('image')) {

                // $file = $request->file('image');

                $upload = HelperService::uploadImage($request->file('image'), 'blogs');

            }            

            $addBlog = $this->blogsRepository->addBlog([
                'title'       => $request->title,
                'alias_title' => str_replace(' ', '-', $request->title),
                'description' => $request->description,
                'content'     => $request->content,
                'image'       => $upload,
                'alt'         => $request->alt
            ]);

            if($addBlog) {

                DB::commit();

                return ResponseService::responseMessage('مقاله ثبت شد', true, 200);

            }


        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در ثبت مقاله پیش امده است لطفا مجددا تلاش کنید', 'Add Blog :', $e);

        }


    }



}