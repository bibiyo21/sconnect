<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight d-inline-block">
        {{ __('Samsung Dashboard') }}
    </h2>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('purchase-orders.index') }}">Purchase Order</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('product-catalogues.create') }}">Product Catalogue</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('product-catalogues.create') }}">IMEI Return</a>
        </li>
    </ul>
</x-slot>
