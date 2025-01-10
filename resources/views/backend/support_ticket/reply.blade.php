@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35">
        <div class="page-title d-flex justify-content-between align-items-center">
            <h4>{{ $page_title ?? '' }}</h4>
            <a href="{{ route('support.list') }}" class="eg-btn btn--primary back-btn"> <img
                    src="{{ asset('backend/images/icons/back.svg') }}" alt="{{ translate('Go Back') }}">
                {{ translate('Go Back') }}</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="eg-card product-card">
                <h4 class="ticketid">{{ translate('Ticket') }} #{{ $supports->id }}</h4>
                <h4 class="ticket-subject">{{ translate('Subject') }}: {{ old('subject', $supports->subject) }}</h4>
                <div class="ticket-message">
                    {{$supports->description}}
                    @if ($supports->support_attachments)
                        @foreach ($supports->support_attachments as $attachments)
                            <a class="attach-file" href="{{ asset('uploads/supports/' . $attachments->attachment) }}"
                                download>{{ translate('Attachment File') }}</a>
                        @endforeach
                    @endif
                </div>
            </div>

            @if ($supports?->ticketReplies?->count() > 0)
                <div class="eg-card product-card">
                    <div class="reply-message">
                        @foreach ($supports->ticketReplies as $key => $reply)
                            <div class="reply-message-list">
                                <h5>
                                    {{ translate('Reply from') }} {{ '@' . $reply->authorInfo->username }}
                                    <span>- {{ dateFormat( $reply->created_at)  }}</span>
                                </h5>

                                {!! clean($reply->answer) !!}
                                <div class="attachment-files">
                                    @if (!empty($reply->documents))
                                        @foreach ($reply->documents as $document)
                                            <a class="attach-file"
                                                href="{{ asset('uploads/supports/' . $document->document) }}"
                                                download>{{ translate('Attachment File') }}</a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif


            <div class="eg-card product-card">
                <form action="{{ route('support.update', $supports->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-inner mb-35">
                                <label>{{ translate('New Reply') }}</label>
                                <textarea class="summernote" name="answer"></textarea>
                                @error('answer')
                                    <div class="error text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">

                            <!-- add input with click start-->
                            <div class="form-inner">
                                <div id="inputTypeFile">
                                    <div class=" mb-3 row g-3">
                                        <div class="col-12">
                                            <input type="file" name="attachment[]" placeholder="No File Choosen">
                                        </div>
                                        <div class="input-group-append"></div>
                                    </div>
                                </div>
                                <div id="newInputFile"></div>
                                <div class="add-btn-area pt-1 text-end">
                                    <button id="addRow2" type="button" class="eg-btn btn--green sm-medium-btn "><i
                                            class="bi bi-plus-lg"></i> {{ translate('Add More') }}</button>
                                </div>
                            </div>
                            <!-- add input with click end -->
                        </div>
                        <div class="button-group mt-15 text-center  ">
                            <input type="submit" class="eg-btn btn--green sm-medium-btn me-3"
                                value="{{ translate('Message Relpy') }}">
                        </div>
                    </div>

                </form>

            </div>
        </div>
        <div class="col-md-4">
            <div class="eg-card product-card">
                <div class="ticket-details">
                    <h4 class="ticket-details-title">{{ translate('Ticket Details') }}</h4>
                    <a class="close-ticket eg-btn red-light--btn" href="{{route('support.close.ticket', $supports->id)}}">{{translate('Close Ticket')}}</a>
                    <table>
                        <tr>
                            <td><strong>{{ translate('Ticket') }}</strong></td>
                            <td>#{{ $supports->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ translate('Merchant Name') }}</strong></td>
                            <td><a href="{{ route('merchant.view', $supports->users->id) }}">{{ $supports->users->fname }}
                                    {{ $supports->users->lname }} <br>{{ '@' . $supports->users->username }}</a></td>
                        </tr>
                        <tr>
                            <td><strong>{{ translate('Email') }}</strong></td>
                            <td>{{ $supports->users->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ translate('Priority') }}</strong></td>
                            <td>
                                @if (old('priority', $supports->priority) == 1)
                                    <span class="eg-btn red-light--btn">{{ translate('High') }}</span>
                                @elseif(old('priority', $supports->priority) == 2)
                                    <span class="eg-btn orange-light--btn"> {{ translate('Medium') }}</span>
                                @elseif(old('priority', $supports->priority) == 3)
                                    <span class="eg-btn primary-light--btn">{{ translate('Low') }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>{{ translate('Department') }}</strong></td>
                            <td>
                                @if (old('department', $supports->department) == 1)
                                    {{ translate('Technical Support') }}
                                @elseif(old('department', $supports->department) == 2)
                                   {{translate('General Support')}}
                                @elseif(old('department', $supports->department) == 3)
                                   {{translate('Payment Issue')}}
                                @elseif(old('department', $supports->department) == 4)
                                  {{translate('Other Issue')}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>{{ translate('Created Date') }}</strong></td>
                            <td>   {{ dateFormat( $supports->created_at)  }} </td>
                        </tr>
                    </table>

                </div>

            </div>
        </div>
    </div>
@endsection
