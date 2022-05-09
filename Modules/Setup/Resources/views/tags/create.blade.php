<div class="box_header common_table_header">
    <div class="main-title d-md-flex">
        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('setup.add_new_tag') }}</h3>
    </div>
</div>
<form action="#" method="POST" enctype="multipart/form-data" id="tagForm">
    <div class="white_box_50px box_shadow_white mb-20">
        <div class="row">
            <div class="col-lg-12">
                <div class="primary_input mb-15">
                    <label class="primary_input_label" for=""> {{__("common.name")}} *</label>
                    <input class="primary_input_field" name="name" id="name" placeholder="{{__("common.name")}}" type="text" value="{{old('name')}}" required="1">
                    <span class="text-danger">{{$errors->first('name')}}</span>
                </div>
            </div>
            <div class="col-lg-12 text-center">
                @if(permissionCheck('tags.create'))
                <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.save")}} </button>
                @else
                <span class=" alert alert-danger">{{__('common.not_permit')}}</span>
                @endif
            </div>
        </div>
    </div>
</form>
