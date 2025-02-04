<?php 

namespace App\Services\Admin;

use App\Http\Requests\Admin\QuestionsRequest;
use App\Repositories\Admin\QuestionsRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class QuestionsService 
{

    protected $questionsRepository;

    public function __construct(QuestionsRepository $questionsRepository)
    {

        $this->questionsRepository = $questionsRepository;
        
    }

    public function addQuestion(QuestionsRequest $request)
    {

        DB::beginTransaction();

        try {

            $createQuestion = $this->questionsRepository->addQuestion([
                'question' => $request->question,
                'answer'   => $request->answer
            ]);

            if($createQuestion) {

                DB::commit();

                return ResponseService::responseMessage('سوال شما به همراه پاسخ ان ثبت شد', true, 200);

            }


        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی در ثبت سوالات پیش امده است لطفا دوباره تلاش کنید', 'Add Question : ', $e);

        }

    }

    public function questions()
    {

        try {

            $questions = $this->questionsRepository->questions();

            if($questions) {

                return ResponseService::responseMessage('',true, 200, [
                    'questions' => $questions
                ]);

            }

            return ResponseService::responseMessage('سوالی وجود ندارد', false, 404);


        } catch(Exception $e) {


            return ResponseService::ServerMessage('متاسفانه مشکلی در نمایش سوالات به وجود امده است لطفا مجددا تلاش کنید', 'Questions : ', $e);

        }
 

    }

    public function deleteQuestion($id)
    {

        DB::beginTransaction();

        try {

            $question = $this->questionsRepository->findQuestion($id);

            if(!$question) {
    
                return ResponseService::responseMessage('سوالی یافت نشد', false, 404);
    
            }
    
            $deleteQuestion = $this->questionsRepository->deleteQuestion($question);
    
            if($deleteQuestion) {

                DB::commit();
    
                return ResponseService::responseMessage('سوال حذف شد', true, 200);
    
            }
    

        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('مشکلی در حذف سوال به وجود امده است لطفا دوباره تلاش کنید', 'Delete Question : ', $e);



        }

 

    }


}