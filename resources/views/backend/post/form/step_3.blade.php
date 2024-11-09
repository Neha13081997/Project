<div class="tab-pane show active" id="step3Section">
    <form id="stepForm3" method="post" class="step-form" data-step-form-no="3">
        @csrf
        <div class="row">
            <div class="mb-3 col-md-6 col-lg-4">
                <label for="country" class="form-label">Country</label>
                <input type="text" name="country" class="form-control" placeholder="Enter country" value="{{ $post->country ?? '' }}">
            </div>

            <div class="mb-3 col-md-6 col-lg-4">
                <label for="city" class="form-label">City</label>
                <input type="text" name="city" class="form-control" placeholder="Enter city" value="{{ $post->city ?? '' }}">
            </div>

            <div class="mb-3 col-md-6 col-lg-4">
                <label for="street" class="form-label">Street</label>
                <input type="street" name="street" class="form-control" placeholder="Enter street" value="{{ $post->street ?? '' }}">
            </div>
        </div>

        <ul class="list-inline wizard mb-0">
            <li class="previous list-inline-item">
                <button type="button" class="btn btn-light back-tab" data-prev-step-route="{{ route('admin.post.stepForm',2) }}"><i class="ri-arrow-left-line me-1"></i> Back </button>
            </li>
            <li class="next list-inline-item float-end">
                <button type="submit" class="btn btn-success submitBtn">@lang('global.save')<i class="ri-arrow-right-line ms-1"></i></button>
            </li>
        </ul>
    </form>
</div>