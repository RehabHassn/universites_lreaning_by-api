<?php

namespace App\Http\Controllers;

use App\Actions\DeleteFileFromPublicAction;
use App\Models\images;
use App\Services\Messages;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
       if(request('model_name')=='images'){
           $image = images::query()->find(request('id'));
           $image->delete();
           DeleteFileFromPublicAction::delete('images',$image->name);
       }else{
           $item=('App\Models\\'.request('model_name'))::query()->find(request('id'));
           $item->delete();
       }
       return Messages::success('',__('messages.deleted_successfully'));
    }
}
