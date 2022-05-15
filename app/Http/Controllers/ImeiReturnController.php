<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImeiReturnCreateRequest;
use App\Models\ImeiReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ImeiReturnController extends Controller
{
    const IMEI_RETURN_INTERFACE = 'retailerpoapi/returnitem';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $imeiReturns = DB::table('imei_returns')
            ->select(
                DB::raw(
                    "imei_returns.*, users.name as userName"
                )
            )
            ->join('users', 'users.id', '=', 'imei_returns.update_by', 'left')
            ->orderBy('updated_at', 'desc');

        if ($request->has('keyword')) {
            $keyword = $request->get('keyword');
            $imeiReturns = $imeiReturns
                ->where(function ($query) use ($keyword) {
                    $query->where('poNumber', 'like', '%'.$keyword.'%')
                        ->orWhere('siteCode', 'like', '%'.$keyword.'%')
                        ->orWhere('imei', 'like', '%'.$keyword.'%')
                    ;
                });
        }

        $imeiReturns = $imeiReturns->paginate($request->get('limit', 100));

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
        $payload['update_by'] = auth()->user()->id;


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
}
