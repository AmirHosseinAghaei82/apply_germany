<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\AddAcceptedStudentRequest;
use App\Http\Requests\Admin\EditAcceptedStudentRequest;
use App\Repositories\Admin\AcceptedStudentsRepository;
use App\Services\HelperService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Support\Facades\DB;

class AcceptedStudentsService
{

    protected $acceptedStudentsRepository;

    public function __construct(AcceptedStudentsRepository $acceptedStudentsRepository)
    {

        $this->acceptedStudentsRepository = $acceptedStudentsRepository;
        
    }

    public function addAcceptedStudent(AddAcceptedStudentRequest $request)
    {

        DB::beginTransaction();

        try {

            $upload = null;

            if($request->hasFile('image')) {

                $upload = HelperService::uploadImage($request->file('image'), 'acceptedstudents');

            }

            $addAcceptedStudent = $this->acceptedStudentsRepository->addAcceptedStudent([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'field'      => $request->field,
                'university' => $request->university,
                'image'      => $upload
            ]);

            if($addAcceptedStudent) {

                DB::commit();

                return ResponseService::responseMessage('دانشجوی پذیرفته شده ثبت شد', true, 200);

            }


        } catch (Exception $e) {

            DB::rollBack();

           return ResponseService::ServerMessage('متاسفانه مشکلی در ثبت پذیرفته شدگان به وجود امد لطفا مجددا تلاش کنید', 'Add Accepted Students : ', $e);

        }

    }

    public function acceptedStudents()
    {

        try {

            $acceptedStudents = $this->acceptedStudentsRepository->acceptedStudents();
    
            if($acceptedStudents) {
    
                return ResponseService::responseMessage('', true, 200, [
                    'acceptedStudents' => $acceptedStudents
                ]);
    
            }
    
            return ResponseService::responseMessage('لیست پذیرفته شدگان خالی می باشد', false, 404);


        } catch(Exception $e) {

            return ResponseService::ServerMessage('متاسفانه مشکلی در نمایش پذیرفته شدگان پیش امده است لطفا مجددا تلاش کنید', 'Accepted Students : ', $e);

        }


    }

    public function acceptedStudent($id)
    {

        try {

            $acceptedStudent = $this->acceptedStudentsRepository->acceptedStudent($id);

            if(!$acceptedStudent) {
    
                return ResponseService::responseMessage('دانشجو یافت نشد', false, 404);
    
            }
    
            return ResponseService::responseMessage('', true, 200, [
                'acceptedStudent' => $acceptedStudent
            ]);
    

        } catch(Exception $e) {

            return ResponseService::ServerMessage('متاسفانه مشکلی در نمایش  دانشجوی پذیرفته مورد نظر شما پیش امده لست لطفل مجددا تلاش کنید', 'Accepted Student : ', $e);

        }


    }

    public function editAcceptedStudent(EditAcceptedStudentRequest $request, $id)
    {

        DB::beginTransaction();

        try {

            $acceptedStudent = $this->acceptedStudentsRepository->acceptedStudent($id);

            if(!$acceptedStudent) {
    
                return ResponseService::responseMessage('پذیرفته شده ای جهت ویرایش یافت نشد', false, 404);
    
            }

            $updateData = [];
    
            if($request->hasFile('image')) {
    
                HelperService::deleteImage($acceptedStudent->image, 'acceptedstudents');
                
                $updateData['image'] = HelperService::uploadImage($request->file('image'), 'acceptedstudents');
    
            }

            foreach(['first_name', 'last_name', 'field', 'university'] as $field) {

                if($request->filled($field)) {

                    $updateData[$field] = $request->$field;

                }

            }

            $editAcceptedStudent = $this->acceptedStudentsRepository->editAcceptedStudent($acceptedStudent, $updateData);

            if($editAcceptedStudent) {

                DB::commit();

                return ResponseService::responseMessage('دانشجوی پذیرفته شده ویرایش شد', true, 200);

            }
    

        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در ویرایش پذیرفته شدگان به وجود امده است', 'Edit Accepted Student : ', $e);

        }

     


    }

    public function deleteAcceptedStudent($id)
    {

        DB::beginTransaction();

        try {

            $acceptedStudent = $this->acceptedStudentsRepository->acceptedStudent($id);

            if(!$acceptedStudent) {

                return ResponseService::responseMessage('دانشجوی پذیرفته شده ای جهت حذف یافت نشد', false, 404);

            }

            $deleteAcceptedStudent = $this->acceptedStudentsRepository->deleteAcceptedStudent($acceptedStudent);

            if($deleteAcceptedStudent) {

                DB::commit();

                return ResponseService::responseMessage('دانشجوی پذیرفته شده حذف شد', true, 200);

            }


        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در فرایند حذف دانشجو پذیرفته شده پیش امد لطفا مجددا تلاش کنید', 'Delete Accepted Student : ', $e);

        }

        

    }

}