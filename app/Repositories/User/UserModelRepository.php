<?php
namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\User\UserRepository;

class UserModelRepository implements UserRepository{
    public function store($request, $user_type){
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'bio' => $request->bio,
        ]);
        if ($user_type == 2) {
            $image = $request->file('certification_file');
            $imageName = time() . \Str::random(45) . '.' . $image->extension();
            $image->move(public_path('users/images'), $imageName);
            $user->certification()->create([
                'title' => $request->input('certification_title'),
                'file' => $imageName,
            ]);
            $user = User::with('certification')->find($user->id);
        } elseif ($user_type == 3) {
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

?>
