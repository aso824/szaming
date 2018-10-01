<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\Shop\ShopAjaxService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShopsController extends Controller
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \App\Services\Shop\ShopAjaxService
     */
    protected $ajaxService;

    /**
     * ShopsController constructor.
     *
     * @param \Illuminate\Http\Request           $request
     * @param \App\Services\Shop\ShopAjaxService $ajaxService
     */
    public function __construct(Request $request, ShopAjaxService $ajaxService)
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

        $shops = $this->ajaxService->getList($query);

        return response()->json($shops);
    }
}
