<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\users\StoreRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(StoreRequest $request)
    {
        $userType = $request->input('user_type');
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'bio' => $request->bio,
        ]);
        if ($userType == 2) {
            $image = $request->file('certification_file');
            $imageName = time() . \Str::random(45) . '.' . $image->extension();
            $image->move(public_path('users/images'), $imageName);
            $user->certification()->create([
                'title' => $request->input('certification_title'),
                'file' => $imageName,
            ]);
            $user = User::with('certification')->find($user->id);
        } elseif ($userType == 3) {
            $user->userProfile()->create([
                'map_location' => $request->input('map_location'),
                'date_of_birth' => $request->input('date_of_birth'),
            ]);
            $user = User::with('userProfile')->find($user->id);
        }
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ]);
    }
}
