<?php 

namespace App\Services\Supporter;

use App\Http\Requests\Supporter\AddSupporterRequest;
use App\Http\Requests\Supporter\EditResumeRequest;
use App\Http\Requests\Supporter\SendResumeRequest;
use App\Http\Requests\Supporter\SendResumeSupporter;
use App\Http\Requests\Supporter\SupporterStatusRequest;
use App\Repositories\Supporter\SupporterRepository;
use App\Services\HelperService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class SupporterService
{

    protected $supporterRepository;

    public function __construct(SupporterRepository $supporterRepository)
    {

        $this->supporterRepository = $supporterRepository;
        
    }

    public function sendResume(SendResumeRequest $request)
    {

        DB::beginTransaction();

        try {

            $user = request()->user();

            if($user->is_register == false) {

                return ResponseService::responseMessage('برای ارسال رزومه ابتدا باید ثبت نام کنید ', false, 403);

            }

            $checkResumeExist = $this->supporterRepository->checkResumeExist($user->id);

            if($checkResumeExist) {

                return ResponseService::responseMessage('رزومه قبلا ثبت شده است', false, 403);

            }

            $addSupporter = $this->supporterRepository->sendResume([
                'user_id'        => $user->id,
                'resume'         => HelperService::uploadFile($request->resume, 'resumes'),
                'description'    => $request->description,
                'message'        => 'منتظر تایید یا عدم تایید توسط ادمین'
            ]);

            if($addSupporter) {

                DB::commit();

                return ResponseService::responseMessage('فرم درخواست پشتیبانی شما ثبت شد', true, 200);

            }

        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در فرایند ثبت فرم درخواست پشتیبانی پیش امده است لطفا مجددا تلاش کنید', 'Send Resume : ', $e);

        }

    }

    public function resumes()
    {

        try {

            $resumes = $this->supporterRepository->resumes();

            if($resumes->isEmpty()) {

                return ResponseService::responseMessage('درخواستی یافت نشد', false, 404);

            }

            return ResponseService::responseMessage('', true, 200, [
                'supporters' => $resumes
            ]);

        } catch(Exception $e) {

            return ResponseService::ServerMessage('متاسفانه مشکلی در نمایش درخواست های پشتیبانی به وجود امده است لطفا مجددا تلاش کنید', 'Resumes : ', $e);

        }

    }

    public function resume($id)
    {

        try {

            $resume = $this->supporterRepository->resume($id);

            if($resume) {

                return ResponseService::responseMessage('', true, 200, [
                    'supporter' => $resume
                ]);

            }

            return ResponseService::responseMessage('پشتیبان مورد نظر یافت نشد', false, 404);

        } catch(Exception $e) {

            return ResponseService::ServerMessage('متاسفانه مشکلی درنمایش پشتیبان مورد نظر به وجود امده است', 'Resume : ', $e);

        }

    }

    public function editResume(EditResumeRequest $request, $id)
    {

        DB::beginTransaction();

        try {

            $resume = $this->supporterRepository->resume($id);

            if(!$resume) {

                return ResponseService::responseMessage('رزومه ای یافت نشد', false, 404);

            }

            $user = $this->supporterRepository->user($resume->user_id);

            if($user->is_supporter == true) {

                $this->supporterRepository->resumeStatus($user, false);

            } else {

                $this->supporterRepository->resumeStatus($user, true);

            }

            $this->supporterRepository->resumeMessage($request->message, $id);

            DB::commit();

            return ResponseService::responseMessage('ثبت شد', true, 200);

        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در بررسی پشتیبان پیش امده است لطفا مجددا تلاش کنید ', ' Edit Resume : ', $e);

        }

    }

    public function adminSupporters()
    {

      try {

        $adminSupporters = $this->supporterRepository->adminSupporters();

        if($adminSupporters->isEmpty()) {

            return ResponseService::responseMessage('پشتیبانی یافت نشد', false, 404);

        }

        return ResponseService::responseMessage('', true, 200, [
            'adminSupporters' => $adminSupporters
        ]);

      } catch(Exception $e) {

        return ResponseService::ServerMessage('متاسفانه مشکلی در نمایش پشتیبان ها به وجود امده است لطفا مجددا تلاش کنید', 'Admin Supporters : ', $e);
        
      }

    }

    public function adminSupporter($id)
    {

        try {

            $adminSupporter = $this->supporterRepository->adminSupporter($id);

            if(!$adminSupporter) {

                return ResponseService::responseMessage('پشتیبان مورد نظر شما یافت نشد', false, 404);

            }

            return ResponseService::responseMessage('', true, 200, [
                'adminSupporter' => $adminSupporter
            ]);


        } catch(Exception $e) {

            return ResponseService::ServerMessage('متاسفانه مشکلی در نمایش پشتیبان مورد نظر شما پیش اامده است لطفا مجددا تلاش کنید', 'Admin Supporter : ', $e);

        }

    }

    public function supporters()
    {

        try {

            $supporters = $this->supporterRepository->supporters();

            if($supporters->isEmpty()) {

                return ResponseService::responseMessage('پشتیبانی یافت نشد', false, 404);

            }

            return ResponseService::responseMessage('', true, 200, [
                'supporters' => $supporters
            ]);


        } catch(Exception $e) {

            return ResponseService::ServerMessage('متاسفانه مشکلی در نمایش پشتیبان ها به وجود امده است لطفا مجددا تلاش نمایید', 'Supporter : ', $e);

        }

    }


}