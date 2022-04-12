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
                            <!-- <th scope="col">Action</th> -->
                            <!-- <th scope="col">Date sent</th>
                            <th scope="col">Sales Order</th>
                            <th scope="col">Billing Document</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">PO Number</th>
                            <th scope="col">Site Code</th>
                            <th scope="col">Delivery Mode</th>
                            <th scope="col">Payment Method</th>
                            <th scope="col">Comment</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</x-app-layout>