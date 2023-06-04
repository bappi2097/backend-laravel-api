<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $response = [
            'user' => new UserResource(auth()->user())
        ];

        return response($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request)
    {
        $fields = $request->all();
        $user = User::find(auth()->user()->id);
        $updated = $user->update($fields);
        if ($updated) {
            return response([
                'user' => new UserResource($user),
                'message' => 'User updated successfully!'
            ], 200);
        } else {
            return response([
                'error' => "Something went wrong!"
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
