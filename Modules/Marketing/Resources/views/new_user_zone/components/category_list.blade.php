
@php
    $category = \Modules\Product\Entities\Category::where('id', $category_id)->first();
@endphp
<div class="col-lg-12 single_item">
    <div class="mb-10">
        <div class="card" >
            <div class="card-header card_header_element">
                <p class="d-inline">
                    {{$category->name}}
                    <input type="hidden" id="catego_{{$category->id}}">
                </p>
                <input type="hidden" name="category[]" value="{{$category->id}}">

                <div class="pull-right category_delete_div">
                    <a class=" d-inline primary-btn cat_btn"><i class="ti-close"></i></a>
                </div>

            </div>


        </div>
    </div>
</div>
