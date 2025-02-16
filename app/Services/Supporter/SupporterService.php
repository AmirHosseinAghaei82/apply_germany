<?php 

namespace App\Services\Supporter;

use App\Http\Requests\Supporter\AddSupporterRequest;
use App\Http\Requests\Supporter\SupporterStatusRequest;
use App\Repositories\Supporter\SupporterRepository;
use App\Services\HelperService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Support\Facades\DB;

class SupporterService
{

    protected $supporterRepository;

    public function __construct(SupporterRepository $supporterRepository)
    {

        $this->supporterRepository = $supporterRepository;
        
    }

    public function addSupporter(AddSupporterRequest $request)
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

            $addSupporter = $this->supporterRepository->addSupporter([
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

            return ResponseService::ServerMessage('متاسفانه مشکلی در فرایند ثبت فرم درخواست پشتیبانی پیش امده است لطفا مجددا تلاش کنید', 'Add Supporter : ', $e);

        }

    }

    public function supporters()
    {

        try {

            $supporters = $this->supporterRepository->supporters();

            if(!$supporters) {

                return ResponseService::responseMessage('درخواستی یافت نشد', false, 404);

            }

            return ResponseService::responseMessage('', true, 200, [
                'supporters' => $supporters
            ]);

        } catch(Exception $e) {

            return ResponseService::ServerMessage('متاسفانه مشکلی در نمایش درخواست های پشتیبانی به وجود امده است لطفا مجددا تلاش کنید', 'Supporters : ', $e);

        }

    }

    public function supporter($id)
    {

        try {

            $supporter = $this->supporterRepository->supporter($id);

            if($supporter) {

                return ResponseService::responseMessage('', true, 200, [
                    'supporter' => $supporter
                ]);

            }

            return ResponseService::responseMessage('پشتیبان مورد نظر یافت نشد', false, 404);

        } catch(Exception $e) {

            return ResponseService::ServerMessage('متاسفانه مشکلی درنمایش پشتیبان مورد نظر به وجود امده است', 'Supporter : ', $e);

        }

    }

    public function editSupporter(SupporterStatusRequest $request, $id)
    {

        DB::beginTransaction();

        try {

            $supporter = $this->supporterRepository->supporter($id);

            $user = $this->supporterRepository->user($supporter->user_id);

            if($user->is_supporter == true) {

                $this->supporterRepository->supporterStatus($user, false);

            } else {

                $this->supporterRepository->supporterStatus($user, true);

            }

            $this->supporterRepository->supporterMessage($request->message, $supporter);

            DB::commit();

            return ResponseService::responseMessage('ثبت شد', true, 200);

        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در بررسی پشتیبان پیش امده است لطفا مجددا تلاش کنید ', 'Supporter Status : ', $e);

        }

    }


}