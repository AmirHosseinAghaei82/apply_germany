<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\AddBlogRequest;
use App\Http\Requests\Admin\AddBlogsRequest;
use App\Http\Requests\Admin\EditBlogRequest;
use App\Models\Blog;
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

    public function addBlog(AddBlogRequest $request)
    {

        DB::beginTransaction();

        try {

            $upload = null;

            if ($request->hasFile('image')) {

                // $file = $request->file('image');

                $upload = HelperService::uploadFile($request->file('image'), 'blogs');
            }

            $addBlog = $this->blogsRepository->addBlog([
                'title'       => $request->title,
                'alias_title' => str_replace(' ', '-', $request->title),
                'description' => $request->description,
                'content'     => $request->content,
                'image'       => $upload,
                'alt'         => $request->alt
            ]);

            if ($addBlog) {

                DB::commit();

                return ResponseService::responseMessage('مقاله ثبت شد', true, 200);
            }
        } catch (Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در ثبت مقاله پیش امده است لطفا مجددا تلاش کنید', 'Add Blog :', $e);
        }
    }

    public function blogs()
    {

        try {

            $blogs = $this->blogsRepository->blogs();

            if ($blogs) {

                return ResponseService::responseMessage('', true, 200, [
                    'blogs' => $blogs
                ]);
            }

            return ResponseService::responseMessage('متاسفانه مقاله ای یافت نشد', false, 404);
        } catch (Exception $e) {

            return ResponseService::ServerMessage('متاسفانه مشکلی در روند نمایش مقاله به وجوئ امده است لطفا مجددا تلاش کنید', 'Blogs : ', $e);
        }
    }

    public function blog($alias_title)
    {

        try {

            $blog = $this->blogsRepository->blog($alias_title);

            if ($blog) {

                return ResponseService::responseMessage('', true, 200, [
                    'blog' => $blog
                ]);
            }

            return ResponseService::responseMessage('مقاله ای با این نام وجود ندارد', false, 404);
        } catch (Exception $e) {

            return ResponseService::ServerMessage('متاسفانه مشکلی در نمایش مقاله مورد نظر شما به وجود امده است لطفا مجددا تلاش کنید', 'Blog : ', $e);
        }
    }

    public function editBlog(EditBlogRequest $request, $id)
    {

        DB::beginTransaction();

        try {

            $updateData = [];

            $blog = $this->blogsRepository->blog($id);

            if (!$blog) {

                return ResponseService::responseMessage('مقاله ای جهت ویرایش یافت نشد', false, 404);

            }

            if ($request->hasFile('image')) {

                HelperService::deleteImage('blogs', $blog->image);

                $updateData['image'] = HelperService::uploadFile($request->file('image'), 'blogs');
                
            }

            if($request->filled('title')) {

                $updateData = [
                    'alias_title' => str_replace(' ', "-", $request->title),
                    'title'       => $request->title
                ];

            }

            foreach (['description', 'content', 'alt'] as $field) {

                if ($request->filled($field)) {

                    $updateData[$field] = $request->$field;

                }

            }

            $editBlog = $this->blogsRepository->editBlog($blog, $updateData);

            if ($editBlog) {

                DB::commit();

                return ResponseService::responseMessage('مقاله ویرایش شد ', true, 200);

            }

        } catch (Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در ویرایش مقاله به وجود امده است لطفا بعدا تلاش کنید', 'Edit Blog : ', $e);

        }

    }

    public function deleteBlog($id)
    {

        DB::beginTransaction();

        try {

            $blog = $this->blogsRepository->blog($id);

            if(!$blog) {
    
                return ResponseService::responseMessage('مقاله ای برای حذف یافت نشد', false, 404);
    
            }

            $deleteBlog = $this->blogsRepository->deleteBlog($blog);

            if($deleteBlog) {

                DB::commit();

                return ResponseService::responseMessage('مقاله حذف شد', true, 200);

            }
    
        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در حذف مقاله به وجود امده است لطفا بعدا تلاش کنید', 'Delete Blog : ', $e);

        }

  
        
    }

}
