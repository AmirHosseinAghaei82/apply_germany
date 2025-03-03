<?php

namespace App\Services\Supporter;

use App\Http\Requests\Supporter\AddTimeRequest;
use App\Http\Requests\Supporter\EditTimeRequest;
use App\Repositories\Supporter\ReserveRepository;
use App\Services\ResponseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class ReserveService 
{

    protected $reserveRepository;

    public function __construct(ReserveRepository $reserveRepository)
    {

        $this->reserveRepository = $reserveRepository;
        
    }

    public function addTime(AddTimeRequest $request)
    {

        DB::beginTransaction();

        try {

            $user = request()->user();

            $create = $this->reserveRepository->addTime([
                'supporter_id' => $user->id,
                'start_time'   => Carbon::createFromFormat('Y-m-d H:i', $request->start_time)->timestamp,
                'end_time'     => Carbon::createFromFormat('Y-m-d H:i', $request->end_time)->timestamp
            ]);

            if($create) {

                DB::commit();

                return ResponseService::responseMessage('تایم مشاوره ثبت شد', true, 200);

            }

        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در ثبت تاریخ مشاوره پیش امدخ است لطفا مجددا تلاش کنید', 'Add Time : ', $e);

        }

    }

    public function times()
    {

        try {

            $user = request()->user();

            $times = $this->reserveRepository->times($user);

            if($times->isEmpty()) {

                return ResponseService::responseMessage('تایم ثبت شده ای یافت نشد', false, 404);

            }

            return ResponseService::responseMessage('', true, 200, [
                'time' => $times
            ]);

        } catch(Exception $e) {

            return ResponseService::ServerMessage('متاسفانه مشکلی درنمایش تایم های ثبت شده به وجود امده است لطفا مجددا تلاش نمایید', 'Times : ', $e);

        }

    }

    public function editTime(EditTimeRequest $request, $id)
    {

        DB::beginTransaction();

        try {

            $user = request()->user();

            $time = $this->reserveRepository->time($user, $id);

            if(!$time) {

                return ResponseService::responseMessage('تایم مورد نظر شما یافت نشد', false, 404);

            }

            $updateTime = [];

            foreach(['start_time', 'end_time'] as $item) {

                if($request->filled($item)) {

                   $updateTime[$item] = Carbon::createFromFormat('Y-m-d H:i', $request->$item)->timestamp;

                }

            }

            $update = $this->reserveRepository->updateTime($updateTime, $time);

            if($update) {

                DB::commit();

                return ResponseService::responseMessage('تایم شما ویرایش شد', true, 200);

            }

        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در نمایش تایم مورد نظر شما به وجود امده است لطفا مجددا تلاش نمایید', 'Edit Time : ', $e);

        }

    }

    public function deleteTime($id)
    {

        DB::beginTransaction();

        try {

            $user = request()->user();

            $time = $this->reserveRepository->time($user, $id);

            if(!$time) {

                return ResponseService::responseMessage('تایم مورد نظر شما یافت نشد', false, 404);

            }

            $deleteTime = $this->reserveRepository->deleteTime($time);

            if($deleteTime) {

                Db::commit();

                return ResponseService::responseMessage('تایم مورد نظر شما حذف شد', true, 200);

            }

        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در حذف تایم بهوجود اماده است لطفا مجدداتلاش نمایید', 'Delete Time : ', $e);

        }

    }


}