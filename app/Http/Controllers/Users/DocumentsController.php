<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AddDocumentRequest;
use App\Services\Users\Documentservice;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    
    protected $documentService;

    public function __construct(Documentservice $documentService)
    {
        
        $this->documentService = $documentService;

    }

    public function addDocument(AddDocumentRequest $request)
    {

        return $this->documentService->addDocument($request);

    }

    public function documents()
    {

        return $this->documentService->documents();

    }

    public function document($id)
    {

        return $this->documentService->document($id);

    }

}
