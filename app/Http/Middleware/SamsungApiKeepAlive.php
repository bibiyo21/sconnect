<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Psr\Http\Message\ResponseInterface;

class SamsungApiKeepAlive
{
    const AUTH_URL= "api/account/auth";
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {
        try {
            // if (!session()->has('samsung_token')) {
        $client = new \GuzzleHttp\Client();
        $response = $client->request(
            'POST', 
            env('SAMSUNG_SCONNECT_API'). self::AUTH_URL, [
            'json' => [
                "userID" => env("SAMSUNG_SCONNECT_USER"),
                "password" => env("SAMSUNG_SCONNECT_PASS")
            ]
        ]);

        $samsungApiResponse = json_decode($response->getBody()->getContents(), true);
        dd($samsungApiResponse);
        if (is_null($samsungApiResponse['token'])) {
            abort(401, "Unauthorized Access!");
        }
        session()->put('samsung_token', $samsungApiResponse['token']);
        // }
        
        return $next($request);
        } catch (Exception $e) {
            abort(401, "Unauthorized Access!");
        }
    }
}
