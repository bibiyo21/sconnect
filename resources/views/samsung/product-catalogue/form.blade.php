<x-app-layout>
  @include('samsung.navbar')

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <h2 class="p-3 h2">Create Product Catalogues</h2>

        <form method="post" action="{{ route('product-catalogues.store') }}">

          @if(session()->has('success'))
          <div class="alert alert-success alert-dismissible fade show m-4">
            {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif

          @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show m-4">
            @if ($errors->has('api_error'))
              {{ $errors['api_error'] }}
            @else
              Please correct the following errors in the forms
            @endif
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif

          @csrf
          <!-- @method('PUT') -->
          <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
              <div class="mb-3">
                <label for="modelCode" class="block font-medium text-sm text-gray-700">Product</label>
                <select name="modelCode" id="modelCode" class="{{ $errors->has('modelCode') ? 'is-invalid' : '' }} form-select block rounded-md shadow-sm mt-1 block w-full mb-2">
                  <option value="" selected disabled>Please select product</option>
                  @foreach ($products as $product)
                    <option {{ old('modelCode') == $product->modelCode ? 'selected' : ''  }} value="{{ $product->modelCode }}">{{ $product->modelCode }}</option>
                  @endforeach
                </select>
                @if ($errors->has('modelCode'))
                  <div class="invalid-feedback">
                    {{ $errors->get('modelCode')[0] }}
                  </div>
                @endif
              </div>

              <div class="mb-3">
                <label for="modelDesc" class="block font-medium text-sm text-gray-700">Product description</label>
                <input value="{{ old('modelDesc') }}" type="text" name="modelDesc" id="modelDesc" class="{{ $errors->has('modelDesc') ? 'is-invalid' : '' }} form-control block rounded-md shadow-sm mt-1 block w-full mb-2">
                @if ($errors->has('modelDesc'))
                  <div class="invalid-feedback">
                    {{ $errors->get('modelDesc')[0] }}
                  </div>
                @endif
              </div>

              <div class="mb-3">
                <label for="paymentMethod" class="block font-medium text-sm text-gray-700">Payment method</label>
                <select name="paymentMethod" id="paymentMethod" class="form-select block rounded-md shadow-sm mt-1 block w-full mb-2">
                  <option value="" selected disabled>Please Select Payment Method</option>
                  <option {{ old("paymentMethod") == "Cash" ? "selected" : ""  }} value="Cash">Cash</option>
                  <option {{ old("paymentMethod") == "Credit" ? "selected" : ""  }} value="Credit">Credit</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                <select name="datelist[0][status]" id="status" class="{{ $errors->has('datelist.0.status') ? 'is-invalid' : '' }} form-select block rounded-md shadow-sm mt-1 block w-full mb-2">
                  <option value="" selected disabled>Please select status</option>
                  <option {{ old("datelist.0.status") == "A" ? "selected" : ""  }} value="A">Active</option>
                  <option {{ old("datelist.0.status") == "I" ? "selected" : ""  }} value="I">Inactive</option>
                </select>
                @if ($errors->has('datelist.0.status'))
                  <div class="invalid-feedback">
                    {{ $errors->get('datelist.0.status')[0] }}
                  </div>
                @endif
              </div>

              <div class="mb-3">
                <label for="price" class="block font-medium text-sm text-gray-700">Price</label>
                <input value="{{ old('datelist.0.price') }}" type="text" name="datelist[0][price]" id="price" class="{{ $errors->has('datelist.0.price') ? 'is-invalid' : '' }} form-control block rounded-md shadow-sm mt-1 block w-full mb-2">
                @if ($errors->has('datelist.0.price'))
                  <div class="invalid-feedback">
                    {{ $errors->get('datelist.0.price')[0] }}
                  </div>
                @endif
              </div>

              <div class="mb-3">
                <label for="discount" class="block font-medium text-sm text-gray-700">Discount</label>
                <input value="{{ old('datelist.0.discount') }}" type="text" name="datelist[0][discount]" id="discount" class="form-control block rounded-md shadow-sm mt-1 block w-full mb-2">
              </div>

              <div class="mb-3">
                <label for="startDate" class="block font-medium text-sm text-gray-700">Start Date</label>
                <input value="{{ old('datelist.0.startDate') }}" type="date" name="datelist[0][startDate]" id="startDate" class="{{ $errors->has('datelist.0.startDate') ? 'is-invalid' : '' }} form-control block rounded-md shadow-sm mt-1 block w-full mb-2">
                @if ($errors->has('datelist.0.startDate'))
                  <div class="invalid-feedback">
                  {{ $errors->get('datelist.0.startDate')[0] }}
                  </div>
                @endif
              </div>

              <div class="mb-3">
                <label for="endDate" class="block font-medium text-sm text-gray-700">End Date</label>
                <input value="{{ old('datelist.0.endDate') }}" type="date" name="datelist[0][endDate]" id="endDate" class="{{ $errors->has('datelist.0.endDate') ? 'is-invalid' : '' }} form-control block rounded-md shadow-sm mt-1 block w-full mb-2">
                @if ($errors->has('datelist.0.endDate'))
                  <div class="invalid-feedback">
                    {{ $errors->get('datelist.0.endDate')[0] }}
                  </div>
                @endif
              </div>
            </div>
            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
              <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                Save Product Catalogues
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>