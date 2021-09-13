<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="card mb-2">
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
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th scope="col">Action</th>
                            <th scope="col">Date sent</th>
                            <th scope="col">Sales Order</th>
                            <th scope="col">Billing Document</th>
                            <th scope="col">Order Creation</th>
                            <th scope="col">Order ID</th>
                            <th scope="col">Receiver Name</th>
                            <th scope="col">District</th>
                            <th scope="col">Original Price</th>
                            <th scope="col">Product name</th>
                            <th scope="col">Variation Name</th>
                            <th scope="col">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <button class="btn btn-primary" 
                                    data-toggle="modal" 
                                    data-target="#orderModal" 
                                    data-order-name="Lorem ipsum"
                                >
                                    <i class="fas fa-paper-plane"></i> 
                                    Send
                                </button>
                            </td>
                            <td>Lorem</td>
                            <td>Ipsum</td>
                            <td>Simple</td>
                            <td>Dummy</td>
                            <td>text</td>
                            <td>to</td>
                            <td>fill</td>
                            <td>in</td>
                            <td>sample</td>
                            <td>data</td>
                            <td>here</td>
                        </tr>
                        <tr>
                            <td>
                                <button class="btn btn-primary" 
                                    data-toggle="modal" 
                                    data-target="#orderModal" 
                                    data-order-name="Lorem ipsum"
                                >
                                    <i class="fas fa-paper-plane"></i> 
                                    Send
                                </button>
                            </td>
                            <td>Lorem</td>
                            <td>Ipsum</td>
                            <td>Simple</td>
                            <td>Dummy</td>
                            <td>text</td>
                            <td>to</td>
                            <td>fill</td>
                            <td>in</td>
                            <td>sample</td>
                            <td>data</td>
                            <td>here</td>
                        </tr>
                        <tr>
                        <td>
                                <button class="btn btn-primary" 
                                    data-toggle="modal" 
                                    data-target="#orderModal" 
                                    data-order-name="Lorem ipsum"
                                >
                                    <i class="fas fa-paper-plane"></i> 
                                    Send
                                </button>
                            </td>
                            <td>Lorem</td>
                            <td>Ipsum</td>
                            <td>Simple</td>
                            <td>Dummy</td>
                            <td>text</td>
                            <td>to</td>
                            <td>fill</td>
                            <td>in</td>
                            <td>sample</td>
                            <td>data</td>
                            <td>here</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</x-app-layout>

<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-label">Order Details: <b>Lorem Ipsum</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Sales Order</label>
                    <input type="text" class="form-control" id="sales-order">
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Billing Document</label>
                    <input type="text" class="form-control" id="billing-document">

                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Send Details</button>
        </div>
        </div>
    </div>
</div>

<script>
    $('#orderModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        // var recipient = button.data('whatever') // Extract info from data-* attributes
        // var modal = $(this)
        // modal.find('.modal-title').text('New message to ' + recipient)
        // modal.find('.modal-body input').val(recipient)
    });
</script>
