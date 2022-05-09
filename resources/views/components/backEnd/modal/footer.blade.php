
@props(['action' => null])
<div class="col-lg-12 text-center">

    <div class="d-flex justify-content-center pt_20">
        @if($action == 'delete')
            <button type="submit" class="primary-btn fix-gr-bg submit"><i
                    class="ti-check"></i>{{ __('common.delete') }}
            </button>
            <button type="button" class="primary-btn fix-gr-bg submitting disabled"
                    style="display: none;"> {{ __('common.deleting') }}
            </button>
        @else
        <button type="submit" class="primary-btn fix-gr-bg submit"><i
                class="ti-check"></i>{{ __('common.submit') }}
        </button>
        <button type="button" class="primary-btn fix-gr-bg submitting disabled"
                style="display: none;"> {{ __('common.submitting') }}
        </button>
        @endif
    </div>
</div>
