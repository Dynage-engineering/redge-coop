@if (@$data)
    @foreach ($data as $item)
        <div class="mb-3">
            @if ($item->type == 'checkbox')
                <h6 class="text--info"> {{ implode(',', $item->value) }}</h6>
            @elseif($item->type == 'file')
                @if ($item->value)
                    @if (auth()->guard('admin')->user())
                        <a class="me-3" href="{{ route('admin.download.attachment', encrypt(getFilePath('verify') . '/' . $item->value)) }}"><i class="fa fa-file"></i> @lang('Attachment') </a>
                    @else
                        <a class="me-3" href="{{ route('user.download.attachment', encrypt(getFilePath('verify') . '/' . $item->value)) }}"><i class="fa fa-file"></i> @lang('Attachment') </a>
                    @endif
                @else
                    @lang('No file or file path not found....')
                @endif
            @else
                <h6 class="text--dark">{{ __($item->value) }}</h6>
            @endif
            <small class="text-muted">{{ __(keyToTitle(@$item->name)) }}</small>
        </div>
    @endforeach
@endif
