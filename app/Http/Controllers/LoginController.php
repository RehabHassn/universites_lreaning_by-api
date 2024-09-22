<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Http\Resources\UserResource;
use App\Services\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UserFormRequest $request)
    {
        $creditials = $request->validated();
        if (Auth::attempt($creditials)) {
            $data = auth()->user();
            $data['token'] = $data->createToken($data['phone'])->plainTextToken;
            return Messages::success(UserResource::make($data), 'login avec succes');


        } else {
            return Messages::error('Login failed');
        }

    }
}
