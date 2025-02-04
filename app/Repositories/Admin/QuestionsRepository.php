<?php 

namespace App\Repositories\Admin;

use App\Models\Question;

class QuestionsRepository 
{

    public function addQuestion(array $data)
    {

        return Question::create($data);

    }

    public function questions()
    {

        return Question::all();

    }

    public function question($id)
    {

        return Question::find($id);

    }

    public function findQuestion($id)
    {

        return Question::find($id);

    }

    public function deleteQuestion($question)
    {

        return $question->delete();

    }

}