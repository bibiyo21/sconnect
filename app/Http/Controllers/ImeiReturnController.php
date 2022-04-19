<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImeiReturnCreateRequest;
use App\Models\ImeiReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ImeiReturnController extends Controller
{
    const IMEI_RETURN_INTERFACE = 'retailerpoapi/returnitem';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $imeiReturns = ImeiReturn::orderBy('updated_at', 'desc')->paginate(20);
        return view('samsung.imei-return.index', compact('imeiReturns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('samsung.imei-return.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImeiReturnCreateRequest $request)
    {
        $payload = $request->except('_token');

        $payload['siteCode'] = env('SITE_CODE');
        $response = Http::withToken(session('samsung_token'))
            ->acceptJson()
            ->post(env("SAMSUNG_SCONNECT_API") . self::IMEI_RETURN_INTERFACE, ['polist' => [$payload]]);

        if ($response->failed()) {
            $apiErrorResponse = json_decode($response->body(), true);
            return redirect()->back()->withErrors([
                "api_error" => $apiErrorResponse['errors']
            ]);
        }

        $payload['status'] = $payload['imeilist'][0]['status'];

        $imei = $payload['imeilist'][0]['imei'];
        unset($payload['imeilist'][0]['imei']);
        unset($payload['imeilist']);

        ImeiReturn::updateOrCreate(
            ['imei' => $imei],
            $payload
        );

        return redirect()->back()->with(
            'success',
            'IMEI Received'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImeiReturn  $imeiReturn
     * @return \Illuminate\Http\Response
     */
    public function show(ImeiReturn $imeiReturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ImeiReturn  $imeiReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(ImeiReturn $imeiReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ImeiReturn  $imeiReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImeiReturn $imeiReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImeiReturn  $imeiReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImeiReturn $imeiReturn)
    {
        //
    }
}
