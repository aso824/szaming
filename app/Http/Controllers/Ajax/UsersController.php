<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\User\UserAjaxService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \App\Services\User\UserAjaxService
     */
    protected $ajaxService;

    /**
     * ShopsController constructor.
     *
     * @param \Illuminate\Http\Request           $request
     * @param \App\Services\User\UserAjaxService $ajaxService
     */
    public function __construct(Request $request, UserAjaxService $ajaxService)
    {
        $this->request = $request;
        $this->ajaxService = $ajaxService;
    }

    /**
     * Get all shops with filter for Select2.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $query = $this->request->get('q');

        $users = $this->ajaxService->getList($query);

        return response()->json($users);
    }
}
