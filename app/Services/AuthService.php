<?php 

namespace App\Services;

use App\Http\Requests\Users\SendOtpRequest;
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
                'message' => 'کد امنیتی کاربر به همراه شماره تماس ان ثبت شد',
                'phone' =>$request->mobile_number,
                'otp'=>$otp
            ]);

        }

        } catch (Exception $e) {
            
            DB::rollBack();

           return ResponseService::ServerMessage('Send Otp : ', $e);
            
        }

    }


}