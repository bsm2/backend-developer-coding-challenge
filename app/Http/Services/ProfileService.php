<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileService
{

    /**
     * Summary of update
     * @param mixed $request
     * @return void
     */
    public function update($request)
    {
        $validated = $request->safe()->only('name', 'email');
        $user = $request->user();
        $user->update($validated);
    }

    /**
     * Summary of get
     * @param mixed $request
     */
    public function get($request)
    {
        return $request->user('api');
    }

    public function changePassword($request)
    {
        $user = $request->user('api');
        if (!$user || !Hash::check($request->old_password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => __('Incorrect Old Password'),
            ]);
        }

        $user->update([
            'password' => $request->new_password
        ]);
    }

    /**
     * Summary of delete
     * @param mixed $request
     * @return void
     */
    public function delete($request)
    {
        $user = $request->user('api');
        $user->delete();
        $request->user()->currentAccessToken()->delete();
    }
}
