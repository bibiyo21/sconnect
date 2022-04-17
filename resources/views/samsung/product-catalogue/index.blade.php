<x-app-layout>
    @include('samsung.navbar')
    
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <!-- <div class="card mb-2">
                <div class="card-body">
                    <form class="form-inline" action="">
                        <label class="form-label px-3" for="date_start">Date Start: </label>
                        <input class="form-control" type="date" name="date_start" id="date_start">
                        <label class="form-label px-3" for="date_end">Date End: </label>
                        <input class="form-control" type="date" name="date_end" id="date_end">
                        <div class="btn-group pl-3 mr-auto">
                            <button class="btn btn-primary" name="filter">Filter</button>
                            <button class="btn btn-info" name="export">Export</button>
                        </div>
                        
                    </form>
                </div>
            </div> -->
            <div class="bg-whiteshadow-xl sm:rounded-lg table-responsive">
                <table class="table table-hover table-condensed ">
                    <thead>
                        <tr>
                            <th scope="col">Model Code</th>
                            <th scope="col">Model Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Status</th>
                            <th scope="col">Price</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Date Start</th>
                            <th scope="col">Date End</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productCatalogues as $productCatalogue)
                            <tr>
                                <td>{{ $productCatalogue->modelCode }}</td>
                                <td>{{ $productCatalogue->modelDesc }}</td>
                                <td>{{ $productCatalogue->price }}</td>
                                <td>{{ $productCatalogue->status }}</td>
                                <td>{{ $productCatalogue->discount }}</td>
                                <td>{{ $productCatalogue->discount }}</td>
                                <td>{{ $productCatalogue->startDate }}</td>
                                <td>{{ $productCatalogue->endDate }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</x-app-layout>