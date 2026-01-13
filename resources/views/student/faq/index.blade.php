@extends('layouts.app')

@section('title', 'FAQs')

@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">

            <div class="nk-block nk-block-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="nk-block-title">FAQs</h4>
                            <div class="d-flex gap-2">
                                @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                <!-- <button class="btn btn-primary p-3" data-bs-toggle="modal" data-bs-target="#addFaq">
                                    Add FAQ
                                </button> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="true">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col">#</th>
                                    <th class="nk-tb-col">Question</th>
                                    <th class="nk-tb-col">Office</th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($faqs as $index => $faq)
                                <tr class="nk-tb-item">
                                    <td class="nk-tb-col">{{ $index + 1 }}</td>
                                    <td class="nk-tb-col">{{ Str::limit($faq->question, 60) }}</td>
                                    <td class="nk-tb-col">{{ $faq->office->name ?? 'All' }}</td>
                                    <td class="nk-tb-col">

                                        <!-- Show -->
                                        <button class="btn btn-sm btn-info text-white"
                                            data-bs-toggle="modal"
                                            data-bs-target="#showFaqModal{{ $faq->id }}">
                                            View
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($faqs as $faq)

<!-- SHOW FAQ MODAL -->
<div class="modal fade" id="showFaqModal{{ $faq->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">FAQ Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Question:</strong></p>
                <p>{{ $faq->question }}</p>

                <p class="mt-3"><strong>Answer:</strong></p>
                <p>{{ $faq->answer }}</p>

                <p class="mt-3">
                    <strong>office:</strong>
                    {{ $faq->office->name ?? 'All offices' }}
                </p>
            </div>
        </div>
    </div>
</div>

@endforeach

@endsection