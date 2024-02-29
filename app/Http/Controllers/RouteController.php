<?php

namespace App\Http\Controllers;

use App\Http\Requests\RouteRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class RouteController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getShortLink(RouteRequest $request): JsonResponse
    {
        dd(123);
//        $this->($request, [
//            'route' => 'required|max:15'
//        ]);
//        $asd =$request->validate([
//            'route' => 'required|max:15'
//        ]);
        dd(123);
    }
}
