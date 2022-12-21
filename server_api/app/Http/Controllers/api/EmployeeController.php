<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class EmployeeController extends Controller
{
    public function index()
    {
        $usersList = User::where('type', '<>', 'C')->paginate(15);
        return UserResource::collection($usersList);
    }

    public function create(CreateEmployeeRequest $request)
    {
        $photo = null;
        if($request->hasFile('photo')){
            $photo = $this->uploadPhoto($request);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'blocked' => false,
            'photo_url' => $photo
        ]);

        return new UserResource($user);
    }

    public function show(User $user)
    {
        //return EmployeeResource::collection($employee->users);
        return new EmployeeResource($user);

    }


    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        User::where("employee_id", $user->id)->delete();
        $user->delete();
        return new UserResource($user);
    }

    public function getEmployees(){
        return UserResource::collection(User::where('type', '!=', 'C')->get());
    }

    public function getCurrentOrder(User $user){
        if($user->type == 'EC'){
            return OrderResource::collection(Order::where([['status', '=', 'P'], ['prepared_by', '=', $user->id]])->get());
        }else if($user->type == 'ED'){
            return OrderResource::collection(Order::where([['status', '=', 'T'], ['delivered_by', '=', $user->id]])->get());
        }
        return response()->json(['message' => 'Type not found'], 404);
    }


    private function uploadPhoto(Request $request){
        $request->validate(['photo' => 'nullable|image|mimes:jpeg,png,jpg']);
        Storage::putFile('public/fotos', $request->file('photo'));
        return  $request->file('photo')->hashName();
    }
}
