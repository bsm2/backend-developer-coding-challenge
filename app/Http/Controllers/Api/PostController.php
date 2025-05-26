<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostRequest;
use App\Http\Resources\PostResource;
use App\Http\Services\MediaService;
use App\Http\Services\PostService;
use App\Http\Traits\ApiResponser;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PostController extends Controller
{
    use ApiResponser;
    public function __construct(protected PostService $postService) {}


    /**
     * Summary of index
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $data = $this->postService->posts($request);
            return $this->success(data: ['total' => $data->total(), 'data' => PostResource::collection($data->items())]);
        } catch (\Throwable $th) {
            return $this->error('Error', 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->postService->store($request);
            DB::commit();
            return $this->success(message: 'added');
        } catch (AccessDeniedHttpException $th) {
            return $this->error($th->getMessage(), 422);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->error('Error', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        try {
            $this->postService->update($request, $post);
            return $this->success(message: 'updated');
        } catch (ModelNotFoundException $th) {
            return $this->error(__('Post Not Found'));
        } catch (ValidationException $th) {
            return $this->error($th->getMessage(), 422, $th->errors());
        } catch (\Throwable $th) {
            return $this->error('Error', 500);
        }
    }

    public function destroy(Post $post)
    {
        try {
            DB::beginTransaction();
            $this->postService->delete($post);
            DB::commit();
            return $this->success(message: 'deleted');
        } catch (ModelNotFoundException $th) {
            return $this->error(__('Post Not Found'));
        } catch (ValidationException $th) {
            return $this->error($th->getMessage(), 422, $th->errors());
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->error('Error', 500);
        }
    }
}
