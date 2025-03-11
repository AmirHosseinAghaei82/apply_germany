<?php 

namespace App\Repositories\Users;

use App\Models\Document;
use Illuminate\Support\Facades\DB;

class DocumentRepository 
{

    public function addDocument(array $data , $user_id)
    {

        return Document::updateOrCreate([
            'user_id' => $user_id
        ], $data);

    }

    public function documents()
    {

        return DB::table('documents')
        ->select(
            'documents.*',
            'users.first_name',
            'users.last_name',
            'users.mobile_number'
        )
        ->join('users', 'documents.user_id', "=", 'users.id')
        ->get();

    }

    public function document($id)
    {
    
        return DB::table('documents')
        ->select(
            'documents.*',
            'users.first_name',
            'users.last_name',
            'users.mobile_number'
        )
        ->where('documents.id', $id)
        ->join('users', 'documents.user_id', "=", 'users.id')
        ->first();
    
    }

}