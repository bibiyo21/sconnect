<x-app-layout>
  @include('samsung.navbar')

  <div class="py-12">
    <div class="mx-auto sm:px-6 lg:px-8">
      <div class="row">
        <div class="col-4">
          @include('shared.search')
        </div>
        
        <div class="col-8 d-flex justify-content-end">
          @include('shared.pagination', ['paginator' => $purchaseOrders])
        </div>
      </div>
      
      <div class="bg-whiteshadow-xl sm:rounded-lg table-responsive">
        <table class="table table-hover table-condensed ">
          <thead>
            <tr>
              <th scope="col">Status</th>
              <th scope="col">Sales Order</th>
              <th scope="col">Billing Document</th>
              <th scope="col">Order Date</th>
              <th scope="col">PO Number</th>
              <th scope="col">Model Code</th>
              <th scope="col">Order Qty</th>
              <th scope="col">Invoice Qty</th>
              <th scope="col">Invoice Price</th>
              <th scope="col">Total Price</th>
              <th scope="col">Site Name</th>
              <th scope="col">Delivery Mode</th>
              <th scope="col">Payment Method</th>
              <th scope="col">Comment</th>
              <th scope="col">Updated By</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($purchaseOrders as $purchaseOrder)
            <tr>
              <td class="<?php 
                  switch($purchaseOrder->status) {
                      case "I":
                        echo "text-warning";
                        break;
                      case "A":
                          echo "text-success";
                          break;
                      case "R":
                        echo "text-danger";
                        break; 
                      case "D":
                        echo "text-info";
                        break;   
                    } 
                ?>">
                @if (!empty($purchaseOrder->status))
                  <i class="fas fa-circle"></i>
                @endif
              </td>
              <td>{{ $purchaseOrder->sales_order }}</td>
              <td>{{ $purchaseOrder->billing_document }}</td>
              <td>{{ $purchaseOrder->orderDate }}</td>
              <td><a class="text-primary" href="{{route('purchase-orders.edit', $purchaseOrder->id)}}">{{ $purchaseOrder->poNumber }}</a></td>
              <td>{{ $purchaseOrder->modelCode }}</td>
              <td>{{ $purchaseOrder->orderQuantity }}</td>
              <td>{{ $purchaseOrder->invoiceQuantity }}</td>
              <td>{{ $purchaseOrder->invoicePrice }}</td>
              <td>{{ $purchaseOrder->totalPrice }}</td>
              <td>{{ $purchaseOrder->siteCode }}</td>
              <td>{{ $purchaseOrder->deliveryMode }}</td>
              <td>{{ $purchaseOrder->paymentMethod }}</td>
              <td>{{ $purchaseOrder->comment }}</td>
              <td>{{ $purchaseOrder->userName }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
    </div>
  </div>

</x-app-layout>
