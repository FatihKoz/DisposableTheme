<div class="col">
  <div class="card mb-2">
    <div class="card-header p-1">
      <h5 class="m-1">
        {{ substr($group, $substr) }}
        <i class="fas fa-file-download float-end"></i>
      </h5>
    </div>
    <div class="card-body p-0 table-responsive">
      @include('downloads.table', ['files' => $files])
    </div>
  </div>
</div>