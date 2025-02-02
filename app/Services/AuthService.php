<?php 

namespace App\Services;

use App\Http\Requests\Users\SendOtpRequest;
use App\Http\Requests\Users\VerifyMobileRequest;
use App\Models\User;
use App\Models\VerifyMobile;
use App\Repositories\AuthRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class AuthService 
{

    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        
        $this->authRepository = $authRepository;

    }

    public function sendOtp(SendOtpRequest $request)
    {

        
        DB::beginTransaction();

        try {

        $checkOtp = VerifyMobile::where('mobile_number', $request->mobile_number)
        ->first();

        if($checkOtp && now()->lessThan($checkOtp->expired_at)) {

           return ResponseService::responseMessage('کد امنیتی شما هنوز منقضی نشده است', false, 409);

        }

        $otp = random_int(100000, 999999);

        $expired_at = Carbon::now()->addMinutes(2);

        $create = $this->authRepository->updateOrCreate([
            'mobile_number' => $request->mobile_number
        ],
        [
        'mobile_number' => $request->mobile_number,
        'otp'          => $otp,
        'expired_at'   => $expired_at
        ]);

        if($create) {

            DB::commit();

            return ResponseService::responseMessage('', true, 200, [
                'message' => 'کد امنیتی ارسال شد',
                'otp'=>$otp
            ]);

        }

        } catch (Exception $e) {
            
            DB::rollBack();

           return ResponseService::ServerMessage('Send Otp : ', $e);
            
        }

    }

    public function verifyMobile(VerifyMobileRequest $request)
    {

        DB::beginTransaction();

        try {

            $checkOtp = verifyMobile::where('mobile_number', $request->mobile_number)
            ->where('otp', $request->otp)
            ->first();
    
            if(now()->greaterThan($checkOtp->expired_at)) {

                return ResponseService::responseMessage('کد امنیتی شما منقضی شده است', false, 409);

            }

            if(!$checkOtp) {

               return ResponseService::responseMessage('کد امنیتی  صحیح نمی باشد', false, 422);

            }

            $checkUser = User::where('mobile_number', $request->mobile_number)
            ->first();

            if($checkUser) {

                $checkUser->tokens()->delete();

                $token = $checkUser->createToken('login')->plainTextToken;

                return ResponseService::responseMessage('ورود شما با موفقیت ثبت شد', true, 200, [
                    'token' => $token
                ]);

            }

            $create = $this->authRepository->create([
                'first_name'    => '',
                'last_name'    => '',
                'email'         => '',
                'mobile_number' => $request->mobile_number,
                'password'    => '',
            ]);

            if($create) {


                $token = $create->createToken('verify')->plainTextToken;

                DB::commit();

                return ResponseService::responseMessage('', true, 200, [
                    'message' => 'شماره تماس کاربر ثبت شد',
                    'token'   => $token
                ]);

            }

        } catch (Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('Verify Mobile : ', $e);

        }



    }




}