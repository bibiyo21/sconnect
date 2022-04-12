<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCatalogueCreateRequest;
use App\Models\Product;
use App\Models\ProductCatalogue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductCatalogueController extends Controller
{
    const PRODUCT_CATALOGUE_INTERFACE = 'retailerpoapi/productctg';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('samsung.product-catalogue.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::orderBy('modelCode')->get()->all();
        return view('samsung.product-catalogue.form', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCatalogueCreateRequest $request)
    {
        $payload = $request->except('_token');
        $payload['siteCode'] = env('SITE_CODE');
        $payload['datelist'][0]['startDate'] = Carbon::parse($payload['datelist'][0]['startDate'])->format('YmdHis');
        $payload['datelist'][0]['endDate'] = Carbon::parse($payload['datelist'][0]['endDate'])->format('YmdHis');

        $response = Http::withToken(session('samsung_token'))
            ->acceptJson()
            ->post(env("SAMSUNG_SCONNECT_API") . self::PRODUCT_CATALOGUE_INTERFACE, ['catalogues' => [$payload]]);

        if ($response->failed()) {
            return redirect()->back()->withErrors([
                "api_error" => "Cannot Connect to Samsung API. There something wrong with your request."
            ]);
        }

        $payload['startDate'] = $payload['datelist'][0]['startDate'];
        $payload['endDate'] = $payload['datelist'][0]['endDate'];
        $payload['discount'] = $payload['datelist'][0]['discount'];
        $payload['status'] = $payload['datelist'][0]['status'];
        $payload['price'] = $payload['datelist'][0]['price'];
        unset($payload['datelist']);

        ProductCatalogue::create($payload);
        return redirect()->back()->with(
            'success',
            'Model Add/Update'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCatalogue  $productCatalogue
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCatalogue $productCatalogue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCatalogue  $productCatalogue
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCatalogue $productCatalogue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCatalogue  $productCatalogue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCatalogue $productCatalogue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCatalogue  $productCatalogue
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCatalogue $productCatalogue)
    {
        //
    }
}
