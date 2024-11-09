<div class="tab-pane show active" id="step4Section">
    <form id="stepForm4" method="post"  class="step-form" data-step-form-no="4">
            @csrf
            <div class="row">
            
                <div class="mb-3 col-md-12">

                    <h3>Reviews</h3>
                    <p>This is the Reviews section.</p>

                </div>

            </div>

            <ul class="pager wizard mb-0 list-inline">
                <li class="previous list-inline-item">
                    <button type="button" class="btn btn-light back-tab" data-prev-step-route="{{ route('admin.post.stepForm',3) }}"><i class="ri-arrow-left-line me-1"></i> Back </button>
                </li>
                <li class="next list-inline-item float-end">
                    <button type="submit"  class="btn btn-success submitBtn">@lang('global.save')<i class="ri-arrow-right-line ms-1"></i></button>
                </li>
            </ul>
    </form>
</div>