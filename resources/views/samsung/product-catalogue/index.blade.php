<x-app-layout>
    @include('samsung.navbar')
    
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-4">
                @include('shared.search')
                </div>
                
                <div class="col-8 d-flex justify-content-end">
                    <a href="{{ route('product-catalogues.create') }}" class="btn btn-primary text-right"> <i class="fas fa-plus"></i> Create Product Catalogue</a>
                    @include('shared.pagination', ['paginator' => $productCatalogues])
                </div>
            </div>
            <div class="text-right">
            </div>
            <div class="bg-whiteshadow-xl sm:rounded-lg table-responsive">
                <table class="table table-hover table-condensed ">
                    <thead>
                        <tr>
                            <th scope="col">Model Code</th>
                            <th scope="col">Model Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Status</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Date Start</th>
                            <th scope="col">Date End</th>
                            <th scope="col">Updated By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productCatalogues as $productCatalogue)
                            <tr>
                                <td>{{ $productCatalogue->modelCode }}</td>
                                <td>{{ $productCatalogue->modelDesc }}</td>
                                <td>{{ $productCatalogue->price }}</td>
                                <td class="<?php 
                                    switch($productCatalogue->status) {
                                        case "I":
                                            echo "text-danger";
                                            break;
                                        case "A":
                                            echo "text-success";
                                            break; 
                                        } 
                                    ?>">
                                    @if (!empty($productCatalogue->status))
                                        <i class="fas fa-circle"></i>
                                    @endif
                                </td>
                                <td>{{ $productCatalogue->discount }}</td>
                                <td>{{ $productCatalogue->startDate }}</td>
                                <td>{{ $productCatalogue->endDate }}</td>
                                <td>{{ $productCatalogue->userName }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</x-app-layout>