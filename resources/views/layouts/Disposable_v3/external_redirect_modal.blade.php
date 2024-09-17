<div class="modal fade" id="externalRedirectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header p-1">
        <h5 class="modal-title">@lang('common.external_redirection')</h5>
      </div>
      <div class="modal-body p-1">
        @lang('common.abouttoleave') <span class="text-primary fw-bold" id="externalRedirectHost"></span><br>
        @lang('common.wanttocontinue')
        <div class="input-group form-group-no-border mt-2">
          <input id="redirectAlwaysTrustThisDomain" type="checkbox" value="1">
          <label for="redirectAlwaysTrustThisDomain" class="control-label mb-0 mx-1">@lang('common.alwaystrustdomain')</label>
        </div>
      </div>
      <div class="modal-footer p-1">
        <button type="button" class="btn btn-sm btn-warning m-0 mx-1 p-0 px-1" data-bs-dismiss="modal" aria-label="Close">Close</button>
        <a href="#" target="_blank" class="btn btn-sm btn-success m-0 mx-1 p-0 px-1" id="externalRedirectUrl">@lang('common.continue')</a>
      </div>
    </div>
  </div>
</div>