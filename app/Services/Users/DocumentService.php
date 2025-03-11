<?php 

namespace App\Services\Users;

use App\Http\Requests\Users\AddDocumentRequest;
use App\Repositories\Users\DocumentRepository;
use App\Services\HelperService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Support\Facades\DB;

class Documentservice 
{

    protected $documentRepository;

    public function __construct(DocumentRepository $documentRepository)
    {

        $this->documentRepository = $documentRepository;
        
    }

    public function addDocument(AddDocumentRequest $request)
    {

        DB::beginTransaction();

        try {

            $user = request()->user();

            $document = HelperService::uploadFile($request->file('file'), 'documents');
    
            $addDocument = $this->documentRepository->addDocument([
                $request->type             => $document,
                $request->type_description => $request->description
            ], $user->id);

            if($addDocument) {

                DB::commit();

                return ResponseService::responseMessage('مدرک ثبت شد', true, 200);

            }
    
        } catch(Exception $e) {

            DB::rollBack();

            return ResponseService::ServerMessage('متاسفانه مشکلی درثبت مدرک مورد نظر شما پیش امده است لطفا مجددا تلاش کنید', 'Add Document : ', $e);

        }




    }

    public function documents()
    {

        try {
  
            $documents = $this->documentRepository->documents();

            if($documents->isEmpty()) {

                return ResponseService::responseMessage('مئارک اپلود شده ای یافت نشد', false, 404);

            }

            return ResponseService::responseMessage('', true, 200, [
                'documents' => $documents
            ]);

        } catch(Exception $e) {

            return ResponseService::ServerMessage('متاسفانه مشکلی در نمایش مدارک اپلود شده به وجود امده است لطفا مجددا تلاش کنید', 'Documents : ', $e);
        }

    }

    public function document($id)
    {

        try {

            $document = $this->documentRepository->document($id);

            if(!$document) {

                return ResponseService::responseMessage('متاسفانه مدارک مورد نظر شما یافت نشد', false, 404);

            }

            return ResponseService::responseMessage('', true, 200, [
                'document' => $document
            ]);

        } catch(Exception $e) {

            return ResponseService::ServerMessage('متاسفانه مشکلی در نمایش مدارک مورد نظر شما پیش امده است لطفا مجددا تلاش کنید', 'Document : ', $e);

        }

    }

}