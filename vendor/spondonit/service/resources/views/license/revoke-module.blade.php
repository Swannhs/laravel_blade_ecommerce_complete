@if(!env('APP_SYNC'))
    <button data-target="#revoke_module_license_modal_{{ $name }}" data-toggle="modal" class="  btn btn-sm btn-link ml-2">
        Revoke License
    </button>

    <div class="modal fade admin-query" id="revoke_module_license_modal_{{ $name }}" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Revoke License</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        <form method="post" action="{{ route('service.revoke.module') }}" accept-charset="UTF-8"
                              class="form-horizontal" onsubmit="myFunction()">
                            @csrf
                            <input type="hidden" name="name" value="{{ $name }}">
                            <input type="hidden" name="row" value="{{ $row }}">
                            <input type="hidden" name="file" value="{{ $file }}">
                            <div class="row">
                                <div class="col-lg-12 text-center text-danger font-weight-bold" id="message-body">
                                    If you revoke your license, your module data will be removed, Please take a backup of your
                                    data before revoking the module license.
                                </div>

                                <div class="col-lg-12 text-center">
                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">Cancel</button>
                                        <button class="primary-btn fix-gr-bg" type="submit">Revoke License</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function myFunction() {
            document.getElementById('message-body').innerHTML = 'Please wait. We are revoking your module license. Do not refresh this page or close the browser';
        }

    </script>

@else
    <button class="primary-btn small fix-gr-bg ml-2" >
        Revoke License
    </button>
@endif
