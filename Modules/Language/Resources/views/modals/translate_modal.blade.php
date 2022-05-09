<div class="white_box_30px" id="translate_modal">
    <form class="" action="{{ route('languages.key_value_store') }}" method="post">
        @csrf
        <div class="">
            <input type="hidden" name="id" value="{{ $language->id }}">
            <input type="hidden" name="translatable_file_name" value="{{ $translatable_file_name }}">
            <div class="col-lg-12 mb-2">
                <div class="d-flex">
                    <button class="primary_btn_2" type="submit">{{ __('common.save') }}</button>
                </div>

            </div>
        </div>
        <div class="common_QA_section QA_section_heading_custom th_padding_l0">
            <div class="QA_table ">
                <!-- table-responsive -->
                <div class="table-responsive">
                    <table class="table Crm_table_active2 pt-0 shadow_none pt-0 pb-0">
                        <thead>
                            <tr>
                                <th scope="col" width="10%">{{ __('common.id') }}</th>
                                <th scope="col" width="50%">{{ __('language.key') }}</th>
                                <th scope="col" width="40%">{{ __('language.value') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($languages as $key => $value)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $key }}</td>
                                    <td>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control tran_input" name="key[{{ $key }}]" @isset($value)
                                                value="{{ $value }}"
                                            @endisset>
                                        </div>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
