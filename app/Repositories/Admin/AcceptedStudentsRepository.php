<?php

namespace App\Repositories\Admin;

use App\Models\AcceptedStudents;

class AcceptedStudentsRepository 
{

    public function addAcceptedStudent(array $data)
    {

        return AcceptedStudents::create($data);

    }

    public function acceptedStudents()
    {

        return AcceptedStudents::all();

    }

    public function acceptedStudent($id)
    {

        return AcceptedStudents::find($id);

    }

    public function editAcceptedStudent($acceptedStudent, $updateData)
    {

        return $acceptedStudent->update($updateData);

    }

    public function deleteAcceptedStudent($acceptedStudent)
    {

        return $acceptedStudent->delete();

    }

}