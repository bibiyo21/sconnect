<x-app-layout>
  @include('samsung.navbar')

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <h2 class="p-3 h2">Edit Purchase Order : {{ $purchaseOrder['poNumber'] }}</h2>

        <form id="purchase-order-form" method="post" action="{{ route('purchase-orders.update', $purchaseOrder->id) }}">

          @if(session()->has('success'))
          <div class="alert alert-success alert-dismissible fade show m-4">
            {{ session()->get('success') }}
          </div>
          @endif

          @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show m-4">
            @if ($errors->has('api_error'))
              @foreach ($errors->get('api_error') as $value)
                <p> <?php echo $value[0] ?> </p>
              @endforeach
            @else
              Please correct the following errors in the forms
            @endif
          </div>
          @endif

          @csrf
          @method('PUT')
          <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
              <div class="mb-3">
                <label for="roles" class="block font-medium text-sm text-gray-700">Status</label>
                <select name="status" id="status" class="{{ $errors->has('status') ? 'is-invalid' : '' }} form-select block rounded-md shadow-sm mt-1 block w-full mb-2">
                  <option value="" selected disabled>Please Select Status</option>
                  <option value="I" {{ $purchaseOrder->status == "I" || old('status') == "I" ? "selected" : ""}}>Process</option>
                  <option value="A" {{ $purchaseOrder->status == "A" || old('status') == "A" ? "selected" : ""}}>Accepted</option>
                  <option value="R" {{ $purchaseOrder->status == "R" || old('status') == "R" ? "selected" : ""}}>Rejected</option>
                  <option value="D" {{ $purchaseOrder->status == "D" || old('status') == "D" ? "selected" : ""}}>Delivered</option>
                </select>
                @if ($errors->has('status'))
                  <div  class="invalid-feedback">
                    This is required.
                  </div>
                @endif
              </div>

              <div class="mb-3">
                <label for="billing_document" class="block font-medium text-sm text-gray-700">Billing Document</label>
                <input type="text" name="billing_document" id="billing_document" class="{{ $errors->has('billing_document') ? 'is-invalid' : '' }} form-control block rounded-md shadow-sm mt-1 block w-full" value="{{ old('billing_document', $purchaseOrder['billing_document']) }}" />
                @if ($errors->has('billing_document'))
                  <div  class="invalid-feedback">
                    This is required.
                  </div>
                @endif
              </div>

              <div class="mb-3">
                <label for="sales_order" class="block font-medium text-sm text-gray-700">Sales Order</label>
                <input type="text" name="sales_order" id="sales_order" class="{{ $errors->has('sales_order') ? 'is-invalid' : '' }} form-control block rounded-md shadow-sm mt-1 block w-full" value="{{ old('sales_order', $purchaseOrder['sales_order']) }}" />
                @if ($errors->has('sales_order'))
                  <div  class="invalid-feedback">
                    This is required.
                  </div>
                @endif
              </div>

              <div class="mb-3">
                <label for="remarks" class="block font-medium text-sm text-gray-700">Remarks</label>
                <textarea 
                  name="remarks" 
                  row="3" 
                  id="remarks" 
                  class="{{ $errors->has('remarks') ? 'is-invalid' : '' }} form-control block rounded-md shadow-sm mt-1 block w-full" >{{ old('remarks', $purchaseOrder['remarks']) }}</textarea>
                @if ($errors->has('remarks'))
                  <div  class="invalid-feedback">
                    This is required.
                  </div>
                @endif
              </div>

              <h3 class="h3 mb-2">Items</h3>

              <div class="table-responsive">
                <table class="table table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th>Model Code</th>
                      <th>Order Quantity</th>
                      <th>Invoice Quantity</th>
                      <th>Invoice Price</th>
                      <th>Delivery Date</th>
                      <th>Order Price</th>
                      <th>Discount</th>
                      <th>Taxcode</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($purchaseOrderItems as $purchaseOrderItem)
                    <tr>
                      <td>
                        <input disabled readonly type="text" name="item[{{$purchaseOrderItem->id}}][modelCode]" class="form-control-sm block rounded-md shadow-sm mt-1 block w-full" value="{{ $purchaseOrderItem->modelCode }}" />
                      </td>
                      <td>
                        <input type="number" name="item[{{$purchaseOrderItem->id}}][orderQuantity]" class="{{ $errors->has('item.'. $purchaseOrderItem->id .'.orderQuantity') ? 'is-invalid' : '' }} form-control-sm block rounded-md shadow-sm mt-1 block w-full" value="{{ old('item.'. $purchaseOrderItem->id .'.orderQuantity', $purchaseOrderItem->orderQuantity) }}" />
                        @if ($errors->has('item.'. $purchaseOrderItem->id .'.orderQuantity'))
                          <div  class="invalid-feedback">
                            This is required.
                          </div>
                        @endif
                      </td>
                      <td>
                        <input type="number" name="item[{{$purchaseOrderItem->id}}][invoiceQuantity]" class="{{ $errors->has('item.'. $purchaseOrderItem->id .'.invoiceQuantity') ? 'is-invalid' : '' }} form-control-sm block rounded-md shadow-sm mt-1 block w-full invoice-quantity" value="{{ old('item.'. $purchaseOrderItem->id .'.invoiceQuantity', $purchaseOrderItem->invoiceQuantity) }}" />
                        @if ($errors->has('item.'. $purchaseOrderItem->id .'.invoiceQuantity'))
                          <div  class="invalid-feedback">
                            This is required.
                          </div>
                        @endif
                      </td>
                      <td>
                        <input type="number" name="item[{{$purchaseOrderItem->id}}][invoicePrice]" class="{{ $errors->has('item.'. $purchaseOrderItem->id .'.invoicePrice') ? 'is-invalid' : '' }} form-control-sm block rounded-md shadow-sm mt-1 block w-full invoice-price" value="{{ old('item.'. $purchaseOrderItem->id .'.invoicePrice', $purchaseOrderItem->invoicePrice) }}" readonly  />
                        @if ($errors->has('item.'. $purchaseOrderItem->id .'.invoicePrice'))
                          <div  class="invalid-feedback">
                            This is required.
                          </div>
                        @endif
                      </td>
                      <td>
                        <input 
                          type="date" 
                          name="item[{{$purchaseOrderItem->id}}][deliveryDate]" 
                          class="{{ $errors->has('item.'. $purchaseOrderItem->id .'.deliveryDate') ? 'is-invalid' : '' }} form-control-sm block rounded-md shadow-sm mt-1 block w-full" 
                          value="{{ !empty($purchaseOrderItem->deliveryDate) || old('item.'. $purchaseOrderItem->id .'.deliveryDate') ? date('Y-m-d', strtotime(old('item.'. $purchaseOrderItem->id .'.deliveryDate', $purchaseOrderItem->deliveryDate))) : '' }}" />
                        @if ($errors->has('item.'. $purchaseOrderItem->id .'.deliveryDate'))
                          <div  class="invalid-feedback">
                            This is required.
                          </div>
                        @endif
                      </td>
                      <td>
                        <input type="number" name="item[{{$purchaseOrderItem->id}}][price]" class="{{ $errors->has('item.'. $purchaseOrderItem->id .'.price') ? 'is-invalid' : '' }} form-control-sm block rounded-md shadow-sm mt-1 block w-full order-price" value="{{ old('item.'. $purchaseOrderItem->id .'.price', $purchaseOrderItem->price) }}" />
                        @if ($errors->has('item.'. $purchaseOrderItem->id .'.price'))
                          <div  class="invalid-feedback">
                            This is required.
                          </div>
                        @endif
                      </td>
                      <td>
                        <input type="number" name="item[{{$purchaseOrderItem->id}}][discount]" class="{{ $errors->has('item.'. $purchaseOrderItem->id .'.discount') ? 'is-invalid' : '' }} form-control-sm block rounded-md shadow-sm mt-1 block w-full" value="{{ old('item.'. $purchaseOrderItem->id .'.discount', $purchaseOrderItem->discount) }}" />
                        @if ($errors->has('item.'. $purchaseOrderItem->id .'.discount'))
                          <div  class="invalid-feedback">
                            This is required.
                          </div>
                        @endif
                      </td>
                      <td>
                        <input type="text" name="item[{{$purchaseOrderItem->id}}][taxcode]" class="{{ $errors->has('item.'. $purchaseOrderItem->id .'.taxcode') ? 'is-invalid' : '' }} form-control-sm block rounded-md shadow-sm mt-1 block w-full" value="{{ old('item.'. $purchaseOrderItem->id .'.taxcode', $purchaseOrderItem->taxcode) }}" />
                        @if ($errors->has('item.'. $purchaseOrderItem->id .'.taxcode'))
                          <div  class="invalid-feedback">
                            This is required.
                          </div>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
              <button id="save-button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                Update Purchase Order
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>

<script>  
  var form = document.getElementById('purchase-order-form');

  form.addEventListener("submit", function (event) {
    var button = document.getElementById('save-button');

    button.setAttribute('disabled', 'disabled');
    button.classList.add('disabled');
  });

  var invoiceQuanity = document.querySelectorAll('.invoice-quantity');
  var orderPrice = document.querySelectorAll('.order-price');

  function computeInvoicePriceByInvoiceQuantity (event) {

    let invoicePriceEl = event.target.closest('tr').querySelector('.invoice-price')
    let orderPriceEl = event.target.closest('tr').querySelector('.order-price')

    let orderPrice = orderPriceEl.value.length ? orderPriceEl.value : 0;

    let invoicePrice = orderPrice * event.target.value; 

    invoicePriceEl.value = invoicePrice
  } 

  function computeInvoicePriceByOrderPrice (event) {
    let invoicePriceEl = event.target.closest('tr').querySelector('.invoice-price')
    let invoicequantityEl = event.target.closest('tr').querySelector('.invoice-quantity')

    let invoicequantity = invoicequantityEl.value.length ? invoicequantityEl.value : 0;

    let invoicePrice = invoicequantity * event.target.value; 

    invoicePriceEl.value = invoicePrice
    }

  for (let i = 0; i < invoiceQuanity.length; i++) {
    invoiceQuanity[i].addEventListener("change", computeInvoicePriceByInvoiceQuantity);
    invoiceQuanity[i].addEventListener("keyup", computeInvoicePriceByInvoiceQuantity);
  }

  for (let i = 0; i < orderPrice.length; i++) {
    orderPrice[i].addEventListener("change", computeInvoicePriceByOrderPrice);
    orderPrice[i].addEventListener("keyup", computeInvoicePriceByOrderPrice);
  }
</script>