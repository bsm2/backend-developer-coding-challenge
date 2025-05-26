<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Services\AuthService;
use App\Http\Traits\ApiResponser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    use ApiResponser;

    public function __construct(protected AuthService $auth) {}
    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->auth->register($request);
            DB::commit();
            return $this->success($data, __('auth.registered'));
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->error(__('Error'));
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->auth->login($request);
            DB::commit();
            return $this->success($data, message: __('auth.message_sent'));
        } catch (ModelNotFoundException $th) {
            return $this->error(__('User Not Found'));
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->error(__('Error'));
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->auth->logout($request);
            return $this->success([], __('auth.logout'));
        } catch (\Throwable $th) {
            return $this->error(__('Error'));
        }
    }
}
