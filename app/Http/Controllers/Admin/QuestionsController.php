<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditQuestionRequest;
use App\Http\Requests\Admin\QuestionsRequest;
use App\Services\Admin\QuestionsService;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{

    protected $questionService;

    public function __construct(QuestionsService $questionService)
    {

        $this->questionService = $questionService;
        
    }

    public function addQuestion(QuestionsRequest $request)
    {

        return $this->questionService->addQuestion($request);

    }
    
    public function questions($id)
    {

        return $this->questionService->questions($id);

    }

    public function question($id)
    {

        return $this->questionService->question($id);

    }

    public function deleteQuestion($id)
    {

        return $this->questionService->deleteQuestion($id);



    }

    public function editQuestion(EditQuestionRequest $request, $id)
    {

        return $this->questionService->editQuestion($request, $id);

    }
}
