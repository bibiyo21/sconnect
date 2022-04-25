<x-app-layout>
    @include('samsung.navbar')
    
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="text-right">
                <a href="{{ route('imei-returns.create') }}" class="btn btn-primary text-right"> <i class="fas fa-paper-plane"></i> Send IMEI Return</a>
            </div>
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
                            <th scope="col">PO Number</th>
                            <th scope="col">Site Code</th>
                            <th scope="col">IMEI</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($imeiReturns as $imeiReturn)
                            <tr>
                                <td>{{ $imeiReturn->poNumber }}</td>
                                <td>{{ $imeiReturn->siteCode }}</td>
                                <td>{{ $imeiReturn->imei }}</td>
                                <td>{{ $imeiReturn->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $imeiReturns->links() }}
        </div>
    </div>
    
</x-app-layout>