<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function index(): UserResourceCollection
    {

        return UserResourceCollection::make(User::query()->with(['applications'])->get());
    }

    public function show(User $user): UserResource
    {
        return UserResource::make($user);
    }
}
