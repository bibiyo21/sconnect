<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCatalogueCreateRequest;
use App\Models\Product;
use App\Models\ProductCatalogue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProductCatalogueController extends Controller
{
    const PRODUCT_CATALOGUE_INTERFACE = 'retailerpoapi/productctg';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productCatalogues = DB::table('product_catalogues')
            ->select(
                DB::raw(
                    "product_catalogues.*, users.name as userName"
                )
            )
            ->orderBy('updated_at', 'desc')
            ->join('users', 'users.id', '=', 'product_catalogues.update_by', 'left');
        
        if ($request->has('keyword')) {
            $keyword = $request->get('keyword');
            $productCatalogues = $productCatalogues
                ->where(function ($query) use ($keyword) {
                    $query->where('modelCode', 'like', '%'.$keyword.'%')
                        ->orWhere('modelDesc', 'like', '%'.$keyword.'%')
                    ;
                });
        }
        $productCatalogues = $productCatalogues->paginate($request->get('limit', 100));
        return view('samsung.product-catalogue.index', compact('productCatalogues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $products = Product::orderBy('modelCode')->get()->all();
        return view(
            'samsung.product-catalogue.form', 
            // compact('products')
        );
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
        
        // $payload['siteCode'] = env('SITE_CODE');
        $payload['datelist'][0]['startDate'] = Carbon::parse($payload['datelist'][0]['startDate'])->format('YmdHis');
        $payload['datelist'][0]['endDate'] = Carbon::parse($payload['datelist'][0]['endDate'])->format('YmdHis');
        $payload['datelist'][0]['price'] = (float) str_replace(',','',$payload['datelist'][0]['price']);

        $response = Http::withToken(session('samsung_token'))
            ->acceptJson()
            ->post(env("SAMSUNG_SCONNECT_API") . self::PRODUCT_CATALOGUE_INTERFACE, ['catalogues' => [$payload]]);

        if ($response->failed()) {
            $apiErrorResponse = json_decode($response->body(), true);
            return redirect()->back()->withErrors([
                "api_error" => $apiErrorResponse['errors']
            ]);
        }

        $payload['startDate'] = $payload['datelist'][0]['startDate'];
        $payload['endDate'] = $payload['datelist'][0]['endDate'];
        $payload['discount'] = $payload['datelist'][0]['discount'];
        $payload['status'] = $payload['datelist'][0]['status'];
        $payload['price'] = $payload['datelist'][0]['price'];
        $payload['update_by'] = auth()->user()->id;

        $modelCode = $payload['modelCode'];
        unset($payload['modelCode']);
        unset($payload['datelist']);

        ProductCatalogue::updateOrCreate(
            ['modelCode' => $modelCode],
            $payload
        );

        return redirect()->back()->with(
            'success',
            'Model Add/Update'
        );
    }
}
