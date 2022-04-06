<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Purchase Orders') }}
        </h2>
    </x-slot>
    

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
                            <th scope="col">Action</th>
                            <th scope="col">Date sent</th>
                            <th scope="col">Sales Order</th>
                            <th scope="col">Billing Document</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">PO Number</th>
                            <th scope="col">Site Code</th>
                            <th scope="col">Delivery Mode</th>
                            <th scope="col">Payment Method</th>
                            <th scope="col">Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseOrders as $purchaseOrder) 
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#purchase-order-modal"
                                            data-purchase-order-id="{{ $purchaseOrder['id'] }}"
                                            data-purchase-order-number="{{ $purchaseOrder['poNumber'] }}"
                                        >
                                            <i class="fas fa-paper-plane"></i> 
                                        </button>
                                        <button class="btn btn-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#purchase-order-item-modal"
                                            data-purchase-order-id="{{ $purchaseOrder['id'] }}"
                                            data-purchase-order-number="{{ $purchaseOrder['poNumber'] }}"
                                        >
                                            <i class="fas fa-shopping-cart"></i> 
                                        </button>
                                    </div>
                                    
                                </td>
                                <td>{{ $purchaseOrder['date_sent'] }}</td>
                                <td>{{ $purchaseOrder['sales_order'] }}</td>
                                <td>{{ $purchaseOrder['billing_document'] }}</td>
                                <td>{{ $purchaseOrder['orderDate'] }}</td>
                                <td>{{ $purchaseOrder['poNumber'] }}</td>
                                <td>{{ $purchaseOrder['siteCode'] }}</td>
                                <td>{{ $purchaseOrder['deliveryMode'] }}</td>
                                <td>{{ $purchaseOrder['paymentMethod'] }}</td>
                                <td>{{ $purchaseOrder['comment'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</x-app-layout>

<!-- Modal -->
<div class="modal fade" id="purchase-order-modal" tabindex="-1" aria-labelledby="purchaseOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="purchase-order-modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="purchase-order-item-modal" tabindex="-1" aria-labelledby="purchaseOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="purchase-order-item-modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
    var purchaseOrderModal = document.getElementById('purchase-order-modal')
    var purchaseOrderTitle = document.getElementById('purchase-order-modal-title')

    purchaseOrderModal.addEventListener('show.bs.modal', function (event) {
        var buttonPo = event.relatedTarget
        var poNumber = buttonPo.getAttribute('data-purchase-order-number')

        purchaseOrderTitle.textContent = 'Update Purchase order:  ' + poNumber
    })

    var purchaseOrderItemModal = document.getElementById('purchase-order-item-modal')
    var purchaseOrderItemTitle = document.getElementById('purchase-order-item-modal-title')

    purchaseOrderItemModal.addEventListener('show.bs.modal', function (event) {
        var buttonPoItem = event.relatedTarget
        var poId = buttonPoItem.getAttribute('data-purchase-order-id')
        var poNumber = buttonPoItem.getAttribute('data-purchase-order-number')

        // fetch('http://example.com/movies.json')
        //     .then(response => response.json())
        //     .then(data => console.log(data));

        purchaseOrderItemTitle.textContent = 'Purchase order items:  ' + poNumber
    })
</script>
