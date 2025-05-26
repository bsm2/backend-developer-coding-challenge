<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\ProfileService;
use App\Http\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    use ApiResponser;

    public function __construct(protected ProfileService $profileService) {}
    public function show(Request $request)
    {
        $user = $this->profileService->get($request);
        return $this->success(new UserResource($user));
    }

    public function update(UpdateProfileRequest $request)
    {
        try {
            $this->profileService->update($request);
            return $this->success([], __('main.profile_update'));
        } catch (Exception $e) {
            return $this->error('Error', 500);
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $this->profileService->changePassword($request);
            return $this->success([], __('main.password_changed'));
        } catch (ValidationException $th) {
            return $this->error($th->getMessage(), 422, $th->errors());
        } catch (\Throwable $th) {
            return $this->error('Error', 500);
        }
    }



    public function destroy(Request $request)
    {
        try {
            $this->profileService->delete($request);
            return $this->success(message: __('main.deleted'));
        } catch (\Throwable $th) {
            return $this->error('Error', 500);
        }
    }
}
