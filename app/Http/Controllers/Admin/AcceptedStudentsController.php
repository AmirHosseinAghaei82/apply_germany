<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\AddAcceptedStudentRequest;
use App\Http\Requests\Admin\EditAcceptedStudentRequest;
use App\Services\Admin\AcceptedStudentsService as AdminAcceptedStudentsService;

class AcceptedStudentsController extends Controller
{

    protected $acceptedStudensService;

    public function __construct(AdminAcceptedStudentsService $acceptedStudensService)
    {
        
        $this->acceptedStudensService = $acceptedStudensService;

    }
    
    public function addAcceptedStudent(AddAcceptedStudentRequest $request)
    {

        return $this->acceptedStudensService->addAcceptedStudent($request);

    }

    public function acceptedStudents()
    {

        return $this->acceptedStudensService->acceptedStudents();

    }

    public function acceptedStudent($id)
    {

        return $this->acceptedStudensService->acceptedStudent($id);

    }

    public function editAcceptedStudent(EditAcceptedStudentRequest $request, $id)
    {

        return $this->acceptedStudensService->editAcceptedStudent($request, $id);

    }

    public function deleteAcceptedStudent($id)
    {

        return $this->acceptedStudensService->deleteAcceptedStudent($id);

    }


}
