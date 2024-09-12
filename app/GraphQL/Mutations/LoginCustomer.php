<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginCustomer
{
    public function __invoke($_, array $args)
    {
        $validator = Validator::make($args['input'], [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $credentials = $args['input'];

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            throw new \Exception('Invalid credentials');
        }

        return [
            'token' => $token,
            'user' => Auth::guard('api')->user(),
        ];
    }
}
