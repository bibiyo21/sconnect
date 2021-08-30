<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card mb-2">
                <div class="card-body">
                    <form class="form-inline" action="">
                        <label class="form-label px-3" for="date_start">Date Start: </label>
                        <input class="form-control" type="date" name="date_start" id="date_start">
                        <label class="form-label px-3" for="date_end">Date End: </label>
                        <input class="form-control" type="date" name="date_end" id="date_end">
                        <div class="btn-group pl-3">
                            <button class="btn btn-primary" name="filter">Filter</button>
                            <button class="btn btn-info" name="export">Export</button>
                        </div>
                        
                    </form>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- <tr>
                        <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td colspan="2">Larry the Bird</td>
                            <td>@twitter</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
