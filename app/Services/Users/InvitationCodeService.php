<?php 

namespace App\Services\Users;

use App\Http\Requests\Users\AddCodeRequest;
use App\Repositories\Users\InvitationCodeRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Support\Facades\DB;

class InvitationCodeService 
{

    protected $repository;

    public function __construct(InvitationCodeRepository $invitationCodeRepository)
    {

        $this->repository = $invitationCodeRepository;
        
    }

    public function addCode(AddCodeRequest $request)
    {

        DB::beginTransaction();

        try {

            $senderUser = request()->user();

            $receiverUser = $this->repository->receiverUser($request);

            if($receiverUser->is_register == true) {

                return ResponseService::responseMessage('کاربر قبلا ثبت نام کرده است', false, 409);

            }

            $addCode = $this->repository->addCode(
                [
                    'receiver_id' => $receiverUser->id
                ],
                [
                'sender_id'       => $senderUser->id,
                'invitation_code' => "INVITE_" . substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 7)
                ]);
            
            if($addCode) {
  
                DB::commit();

                return ResponseService::responseMessage('کد دعوت ساخته شد', true, 200);

            }

        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در ساخت کد دعوت پیش امده است لطفا مجددا تلاش نمایید', 'Add Code : ', $e);

        }

        



    }



}