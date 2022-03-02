<table class="table table-sm table-borderless table-striped text-start text-nowrap align-middle mb-0">
  @foreach($files as $file)
    <tr>
      <td>
        <a href="{{ route('frontend.downloads.download', [$file->id]) }}" target="_blank">{{ $file->name }}</a>
      </td>
      <td class="text-end">
        @if(Theme::getSetting('download_counts') && $file->download_count > 0)
          {{ $file->download_count.' '.trans_choice('common.download', $file->download_count) }}
        @endif
      </td>
    </tr>
    @if($file->description)
      <tr>
        <td colspan="2">&bull; {{ $file->description }}</td>
      </tr>
    @endif
  @endforeach
</table>