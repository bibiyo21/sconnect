<x-slot name="header">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active navbar-brand" href="{{ route('samsung.dashboard') }}">
                <img style="width: 180px;" src="{{ asset('img/samsung.jpg') }}" alt="">
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('purchase-orders.index') }}">Purchase Order</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('product-catalogues.index') }}">Product Catalogue</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('imei-returns.index') }}">IMEI Return</a>
        </li>
    </ul>
</x-slot>
