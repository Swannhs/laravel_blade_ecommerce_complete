<div id="show_item_modal">
    <div class="modal fade" id="item_show">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ __('product.show_attribute') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-12">
                        <div class="QA_section3 QA_section_heading_custom th_padding_l0">
                            <div class="QA_table">
                                <!-- table-responsive -->
                                <div class="table-responsive">
                                    <table class="table pos_table pt-0 shadow_none pb-0 ">
                                        <tbody>
                                            <tr>
                                                <th scope="col">{{__('product.attribute_name')}}</th>
                                                <td>{{ $atribute->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">{{__('common.description')}}</th>
                                                <td>{{ $atribute->description }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">{{__('common.values')}}</th>
                                                <td>{{ implode(", ", $values) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
