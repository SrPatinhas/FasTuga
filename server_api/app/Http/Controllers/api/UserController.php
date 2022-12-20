<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function userInfo(Request $request)
    {
        return new UserResource($request->user());
    }

    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return new UserResource($user);
    }

    public function update_password(UpdateUserPasswordRequest $request, User $user)
    {
        $user->password = Hash::make($request->validated()['password']);
        $user->save();
        return new UserResource($user);
    }

    public function updatePhoto(Request $request){
        $request->validate(['photo' => 'image|mimes:jpeg,png,jpg']);
        $user = Auth::user();
        // Delete previous photo
        Storage::disk('public')->delete('fotos/'.$user->photo_url);
        // Save new file
        Storage::putFile('public/fotos', $request->file('photo'));
        // Update path on DB
        User::where('id', $user->id)->update(['photo_url', $request->file('photo')->hashName()]);
        // return new image path
        return response()->json([
            'location' => '/storage/fotos/'.$request->file('photo')->hashName(),
            'filename' => $request->file('photo')->hashName()
        ], 201);
    }

    /**
     * Manager actions
     */
    public function block(User $user)
    {
        $user->blocked = 1;
        $user->save();
        return response()->json(['message' => 'User blocked successfully.', 'user' => $user], 200);
    }

    public function unblock(User $user){
        $user->blocked = 0;
        $user->save();
        return response()->json(['message' => 'User unblocked successfully.', 'user' => $user], 200);
    }
}
