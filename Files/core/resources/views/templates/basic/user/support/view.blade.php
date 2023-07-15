@extends($activeTemplate . 'layouts.' . $layout)
@section('content')
    <div class="@guest pt-50 pb-50 @endguest container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                @auth
                    <div class="mb-3 text-end">
                        <a class="btn btn-sm btn--base mb-2" href="{{ route('ticket.index') }}"><i class="la la-list"></i> @lang('All Tickets')</a>
                    </div>
                @endauth

                <div class="card custom--card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="card-title mb-0 p-2">
                            @php echo $myTicket->statusBadge; @endphp
                            [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
                        </h6>

                        @if ($myTicket->status != Status::TICKET_CLOSE && $myTicket->user)
                            <button class="btn btn-danger btn-sm confirmationBtn" data-question="@lang('Are you sure to close this ticket?')" data-action="{{ route('ticket.close', $myTicket->id) }}" type="button"><i class="la la-times-circle"></i>
                            </button>
                        @endif
                    </div>

                    <div class="card-body">

                        <form method="post" action="{{ route('ticket.reply', $myTicket->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row justify-content-between">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form--control" name="message" rows="4">{{ old('message') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <a class="btn btn--base btn-sm addFile" href="javascript:void(0)"><i class="la la-plus"></i> @lang('Add New')</a>
                            </div>
                            <div class="form-group">
                                <label class="form-label fw-bold">@lang('Attachments')</label> <small class="text-danger">@lang('Max 5 files can be uploaded'). @lang('Maximum upload size is') {{ ini_get('upload_max_filesize') }}</small>
                                <input class="form--control" name="attachments[]" type="file" />
                                <div id="fileUploadsContainer"></div>
                                <p class="ticket-attachments-message text-muted my-2">
                                    @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                </p>
                            </div>
                            <button class="btn btn-md btn--base w-100" type="submit"> <i class="la la-reply"></i> @lang('Reply')</button>
                        </form>

                    </div>
                </div>

                <div class="card custom--card mt-4">
                    <div class="card-body">
                        @foreach ($messages as $message)
                            @if ($message->admin_id == 0)
                                <div class="row border-primary border-radius-3 my-3 mx-2 border py-3">
                                    <div class="col-md-3 border-end text-end">
                                        <h5 class="my-3">{{ $message->ticket->name }}</h5>
                                    </div>
                                    <div class="col-md-9">
                                        <p class="text-muted fw-bold my-3">
                                            @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                        <p>{{ $message->message }}</p>
                                        @if ($message->attachments->count() > 0)
                                            <div class="mt-2">
                                                @foreach ($message->attachments as $k => $image)
                                                    <a class="me-3" href="{{ route('ticket.download', encrypt($image->id)) }}"><i class="fa fa-file"></i> @lang('Attachment') {{ ++$k }} </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="row border-warning admin-bg-reply border-radius-3 my-3 mx-2 border py-3">
                                    <div class="col-md-3 border-end text-end">
                                        <h5 class="my-3">{{ $message->admin->name }}</h5>
                                        <p class="lead text-muted">@lang('Staff')</p>
                                    </div>
                                    <div class="col-md-9">
                                        <p class="text-muted fw-bold my-3">
                                            @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                        <p>{{ $message->message }}</p>
                                        @if ($message->attachments->count() > 0)
                                            <div class="mt-2">
                                                @foreach ($message->attachments as $k => $image)
                                                    <a class="me-3" href="{{ route('ticket.download', encrypt($image->id)) }}"><i class="fa fa-file"></i> @lang('Attachment') {{ ++$k }} </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }

        .admin-bg-reply {
            background-color: #ffd96729;
        }
    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class=" form--control" required />
                        <button type="button" class="input-group-text bg--danger text-white border-0 remove-btn"><i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });

            $("#confirmationModal").find('.btn--primary').removeClass('btn--primary').addClass('btn--base');
            $("#confirmationModal").find('.modal-header button[data-bs-dismiss="modal"]').remove();
        })(jQuery);
    </script>
@endpush

@push('bottom-menu')
    <li><a href="{{ route('user.profile.setting') }}">@lang('Profile')</a></li>
    <li><a href="{{ route('user.twofactor') }}">@lang('2FA Security')</a></li>
    <li><a href="{{ route('user.change.password') }}">@lang('Change Password')</a></li>
    <li><a href="{{ route('user.transaction.history') }}">@lang('Transactions')</a></li>
    <li><a class="active" href="{{ route('ticket.index') }}">@lang('Support Tickets')</a></li>
@endpush

@push('modal')
    <x-confirmation-modal height="h-none" />
@endpush
