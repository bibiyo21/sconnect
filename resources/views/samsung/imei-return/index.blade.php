<x-app-layout>
    @include('samsung.navbar')
    
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-4">
                @include('shared.search')
                </div>
                
                <div class="col-8 d-flex justify-content-end">
                    <a href="{{ route('imei-returns.create') }}" class="btn btn-primary text-right"> <i class="fas fa-paper-plane"></i> Send IMEI Return</a>
                    @include('shared.pagination', ['paginator' => $imeiReturns])
                </div>
            </div>
            <div class="bg-whiteshadow-xl sm:rounded-lg table-responsive">
                <table class="table table-hover table-condensed ">
                    <thead>
                        <tr>
                            <th scope="col">PO Number</th>
                            <th scope="col">Site Code</th>
                            <th scope="col">IMEI</th>
                            <th scope="col">Status</th>
                            <th scope="col">Updated By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($imeiReturns as $imeiReturn)
                            <tr>
                                <td>{{ $imeiReturn->poNumber }}</td>
                                <td>{{ $imeiReturn->siteCode }}</td>
                                <td>{{ $imeiReturn->imei }}</td>
                                <td class="<?php 
                                    switch($imeiReturn->status) {
                                        case "I":
                                            echo "text-danger";
                                            break;
                                        case "A":
                                            echo "text-success";
                                            break; 
                                        } 
                                    ?>">
                                    @if (!empty($imeiReturn->status))
                                        <i class="fas fa-circle"></i>
                                    @endif
                                </td>
                                <td>{{ $imeiReturn->userName }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $imeiReturns->links() }}
        </div>
    </div>
    
</x-app-layout>