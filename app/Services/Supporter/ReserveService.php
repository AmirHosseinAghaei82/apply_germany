<?php

namespace App\Services\Supporter;

use App\Http\Requests\Supporter\AddTimeRequest;
use App\Repositories\Supporter\ReserveRepository;
use App\Services\ResponseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

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

    

}