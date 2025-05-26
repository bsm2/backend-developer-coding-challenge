<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PlatformRequest;
use App\Http\Services\PlatformService;
use App\Http\Traits\ApiResponser;
use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    use ApiResponser;
    public function __construct(protected PlatformService $platformService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $data = $this->platformService->platforms();
            return $this->success(data: ['total' => $data->total(), 'data' => $data->items()]);
        } catch (\Throwable $th) {
            return $this->error('Error', 500);
        }
    }

    public function toggle(PlatformRequest $request)
    {
        try {
            $this->platformService->toggle($request->platforms);
            return $this->success(message: 'toggled');
        } catch (\Throwable $th) {
            return $this->error('Error', 500);
        }
    }
}
