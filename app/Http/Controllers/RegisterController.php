<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Models\User;
use App\Repositries\RegisterRepositry;
use App\Services\Messages;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    private $repo;
    public function __construct(RegisterRepositry $repo){
        $this->repo = $repo;
    }
    public function __invoke(UserFormRequest $request)
    {
       // return $request->validated();
       return $this->repo->create_user($request->validated());
    }
}
