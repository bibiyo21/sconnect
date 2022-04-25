<x-app-layout>
  @include('samsung.navbar')

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <h2 class="p-3 h2">Send IMEI Return Item Form</h2>

        <form id="imei-returns-form" method="post" action="{{ route('imei-returns.store') }}">

          @if(session()->has('success'))
          <div class="alert alert-success alert-dismissible fade show m-4">
            {{ session()->get('success') }}
          </div>
          @endif

          @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show m-4">
            @if ($errors->has('api_error'))
            @foreach ($errors->get('api_error') as $value)
                <p>{{ $value[0] }}</p>
              @endforeach
            @else
              Please correct the following errors in the forms
            @endif
          </div>
          @endif

          @csrf
          <!-- @method('PUT') -->
          <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
              <div class="mb-3">
                <label for="poNumber" class="block font-medium text-sm text-gray-700">PO Number</label>
                <input value="{{ old('poNumber') }}" type="text" name="poNumber" id="poNumber" class="{{ $errors->has('poNumber') ? 'is-invalid' : '' }} form-control block rounded-md shadow-sm mt-1 block w-full mb-2">
                @if ($errors->has('poNumber'))
                  <div class="invalid-feedback">
                    {{ $errors->get('poNumber')[0] }}
                  </div>
                @endif
              </div>

              <div class="mb-3">
                <label for="siteCode" class="block font-medium text-sm text-gray-700">Site Code</label>
                <input value="{{ old('siteCode') }}" type="text" name="siteCode" id="siteCode" class="{{ $errors->has('siteCode') ? 'is-invalid' : '' }} form-control block rounded-md shadow-sm mt-1 block w-full mb-2">
                @if ($errors->has('poNumber'))
                  <div class="invalid-feedback">
                    {{ $errors->get('siteCode')[0] }}
                  </div>
                @endif
              </div>

              <div class="mb-3">
                <label for="imei" class="block font-medium text-sm text-gray-700">IMEI</label>
                <input value="{{ old('imeilist.0.imei') }}" type="text" name="imeilist[0][imei]" id="imei" class="{{ $errors->has('imeilist.0.imei') ? 'is-invalid' : '' }} form-control block rounded-md shadow-sm mt-1 block w-full mb-2">
                @if ($errors->has('imeilist.0.imei'))
                  <div class="invalid-feedback">
                    {{ $errors->get('imeilist.0.imei')[0] }}
                  </div>
                @endif
              </div>

              <div class="mb-3">
                <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                <select name="imeilist[0][status]" id="status" class="{{ $errors->has('imeilist.0.status') ? 'is-invalid' : '' }} form-select block rounded-md shadow-sm mt-1 block w-full mb-2">
                  <option value="" selected disabled>Please select status</option>
                  <option {{ old("imeilist.0.status") == "A" ? "selected" : ""  }} value="A">Active</option>
                  <option {{ old("imeilist.0.status") == "I" ? "selected" : ""  }} value="I">Inactive</option>
                </select>
                @if ($errors->has('imeilist.0.status'))
                  <div class="invalid-feedback">
                    {{ $errors->get('imeilist.0.status')[0] }}
                  </div>
                @endif
              </div>
            </div>
            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
              <button id="save-button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                Send IMEI return
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>

<script>  
  var form = document.getElementById('imei-returns-form');

  form.addEventListener("submit", function (event) {
    var button = document.getElementById('save-button');

    button.setAttribute('disabled', 'disabled');
    button.classList.add('disabled');
  })
</script>