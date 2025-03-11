<?php 

namespace App\Services;

use App\Http\Requests\Users\EditDashboardRequest;
use App\Http\Requests\users\LoginRequest;
use App\Http\Requests\Users\RegisterRequest;
use App\Http\Requests\Users\SendEmailRequest;
use App\Http\Requests\Users\SendOtpRequest;
use App\Http\Requests\Users\VerifyEmailRequest;
use App\Http\Requests\Users\VerifyMobileRequest;
use App\Mail\VerificationMail;
use App\Models\User;
use App\Models\VerifyMobile;
use App\Repositories\AuthRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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

        $create = $this->authRepository->sendOtp([
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

           return ResponseService::ServerMessage('متاسفانه مشکلی در ارسال کد پیش امده است', 'Send Otp : ', $e);
            
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

            $create = $this->authRepository->verifyMobile([
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

            return ResponseService::ServerMessage('متاسفانه مشکلی در احراز هویت شما پیش امده است','Verify Mobile : ', $e);

        }



    }

    public function sendEmail(SendEmailRequest $request)
    {

        DB::beginTransaction();

        try {

            $user = request()->user();

            $checkEmailTime = $this->authRepository->checkEmailtime($request);

            if($checkEmailTime && now()->lessThan($checkEmailTime->expired_at)) {

                return ResponseService::responseMessage('کد فرستاده به ایمیل شما هنوز منقضی نشده است', false, 409);

            }

            $fullName = $user->first_name . " " . $user->last_name;

            $emailCode= random_int(100000, 999999);

            $expired_at = Carbon::now()->addMinutes(20);

            $create = $this->authRepository->sendEmail([
                'email' => $request->email
            ],
            [
                'email_code' => $emailCode,
                'expired_at' => $expired_at
            ]);

            Mail::to($request->email)->send(new VerificationMail($emailCode, $fullName));

            if($create) {

                DB::commit();

                return ResponseService::responseMessage('', true, 200, [
                    'message'   => 'کد برای ایمیل شما ارسال شد', 
                    'emailCode' => $emailCode
                ]);

            }

        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در ارسال کد برای ایمیل شما به وجود امده است لطفا مجددا تلاش نمایید', 'Send Email : ', $e);

        }

    }

    public function verifyEmail(VerifyEmailRequest $request)
    {

        DB::beginTransaction();

        try {

            $user = request()->user();

            $checkEmail = $this->authRepository->checkEmail($request);

            if(now()->greaterThan($checkEmail->expired_at)) {

                return ResponseService::responseMessage('کد فرستاده شده برای ایمیل منقضی شده است', false, 409);

            }

            if(!$checkEmail) {

                return ResponseService::responseMessage('کد امنیتی صحیح نمی باشد', false, 422);

            }

            $create = $this->authRepository->verifyEmail($user, $checkEmail);

            if($create) {

                DB::commit();

                return ResponseService::responseMessage('ایمیل شما با موفقیت ثبت شد', true, 200);

            }

        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در ثبت ایمیل شما به وجود امده است لطفا مجددا تلاش نمایید', 'Verify Email : ', $e);
            
        }





    }

    public function register(RegisterRequest $request)
    {

        DB::beginTransaction();

        try {

            $user = request()->user();

            if($user->is_register == true) {

                return ResponseService::responseMessage('شما قبلا ثبت نام کرده اید', false, 409);

            }

            $create = $this->authRepository->register([
                'mobile_number' => $user->mobile_number
            ],
            [
                'first_name'  => $request->first_name,
                'last_name'   => $request->last_name,
                'password'    => Hash::make($request->password),
                'is_register' => true
            ]);
    
            if($create) {
                
                $user->tokens()->delete();

                $token = $user->createToken('register')->plainTextToken;

                DB::commit();

                return ResponseService::responseMessage('کاربر با موفقیت ثبت نام شد', true, 200, [
                    'token' => $token
                ]);
        
            }


            
        } catch (Exception $e) {

            DB::rollBack();
            
            return ResponseService::ServerMessage('متاسفانه مشکلی در ثبت نام پیش امده است','Register : ', $e);

        }

    }

    public function login(LoginRequest $request)
    {
        
        try {
            
            $checkIdentifier = User::where('is_register', true)
            ->where('mobile_number', $request->identifier)
            ->orwhere('email', $request->identifier)
            ->first();

            $password = $checkIdentifier->password;

            if($checkIdentifier && Hash::check($request->password, $password)) {

                    $checkIdentifier->tokens()->delete();

                    $token = $checkIdentifier->createToken('login')->plainTextToken;

                return ResponseService::responseMessage('ورود شما با موفقیت ثبت شد', true, 200, [
                    'token' => $token
                ]);

            }

            return ResponseService::responseMessage('اطلاعات وارد شده صحیح نمی باشد', false, 404);


        } catch (Exception $e) {

        return ResponseService::ServerMessage('متاسفانی مشکلی در لاگین پیش امده است', 'Login : ', $e);

        }

    }

    public function logOut()
    {

        try {
            
            $user = request()->user();

            $user->tokens()->delete();

            return ResponseService::responseMessage('کاربر لاگ اوت شد', true, 200);

        } catch (Exception $e) {

            return ResponseService::ServerMessage('مشکلی در لاگ اوت پیش امده است', 'LogOut : ', $e);

        }   



    }

    public function dashboard()
    {

        try {

        $user = request()->user();

        if(!$user) {

            return ResponseService::responseMessage('شما هنوز ثبت نام نکردید', false, 403);

        }

        return ResponseService::responseMessage('', true, 200, [
            'first_name'   => $user->first_name,
            'last_name'    => $user->last_name,
            'is_admin'     => $user->is_admin,
            'is_supporter' => $user->is_supporter,
            'image'        => $user->image
            ]);



        } catch(Exception $e) {

            return ResponseService::ServerMessage('متاسفانه مشکلی در نمایش داشبورد به وجود امده است لطفا مجددا تلاش کنید', 'Dashboard : ', $e);

        }

    }

    public function editDashboard(EditDashboardRequest $request)
    {

        DB::beginTransaction();

        try {

            $user = request()->user();

            if($request->hasFile('image')) {

                HelperService::deleteImage($user->image, 'users');

                $updateData['image'] = HelperService::uploadFile($request->file('image'), 'users');

            }

            // if($request->filled('password')) {

            //     $updateData['password'] = Hash::make($request->password);

            // }

            foreach(['first_name', 'last_name', 'password'] as $field) {

                if($request->filled($field)) {

                    $updateData[$field] = $request->$field;

                }

            }

            

            $update = $this->authRepository->editDashboard($user, $updateData);

            if($update) {

                DB::commit();

                return ResponseService::responseMessage('اطلاعات ویرایش شد', true, 200,);

            }

        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در ثبت اطلاعات ویرایش شده پیش امده است لطفا مجددا تلاش کنید ', 'Edit Dashboard : ', $e);

        }

    }


 





}