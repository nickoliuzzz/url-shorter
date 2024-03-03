<?php

namespace App\Http\Controllers;

use App\Http\Requests\RouteRequest;
use App\Service\RouteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RouteController extends BaseController
{
    public function getShortLink(RouteRequest $request, RouteService $service): JsonResponse
    {
         $hash = $service->getHash($request->get('url'));

         return new JsonResponse($hash);
    }

    public function redirectToUrl(string $hash, RouteService $service): Response
    {
         $url = $service->getUrl($hash);
         if ($url === null) {
             throw new NotFoundHttpException();
         }

        return redirect()->away((is_null(parse_url($url, PHP_URL_HOST)) ? '//' : '').$url);
    }
}
