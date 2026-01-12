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
                                <button class="btn btn-primary p-3" data-bs-toggle="modal" data-bs-target="#addFaq">
                                    Add FAQ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col">#</th>
                                    <th class="nk-tb-col">Question</th>
                                    <th class="nk-tb-col">Office</th>
                                    <th class="nk-tb-col">Status</th>
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
                                        <span class="badge {{ $faq->is_active ? 'bg-success':'bg-secondary' }}">
                                            {{ $faq->is_active ? 'Active':'Hidden' }}
                                        </span>
                                    </td>
                                    <td class="nk-tb-col">
                                        <!-- Toggle -->
                                        <form method="POST" action="{{ route('admin.faqs.toggle',$faq) }}" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-warning">
                                                {{ $faq->is_active ? 'Hide':'Show' }}
                                            </button>
                                        </form>

                                        <!-- Show -->
                                        <button class="btn btn-sm btn-info text-white"
                                            data-bs-toggle="modal"
                                            data-bs-target="#showFaqModal{{ $faq->id }}">
                                            View
                                        </button>

                                        <!-- Edit -->
                                        <button class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editFaqModal{{ $faq->id }}">
                                            Edit
                                        </button>

                                        <!-- Delete -->
                                        <form method="POST" action="{{ route('admin.faqs.destroy',$faq) }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this FAQ?')">
                                                Delete
                                            </button>
                                        </form>
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

<!-- EDIT FAQ MODAL -->
<div class="modal fade" id="editFaqModal{{ $faq->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.faqs.update', $faq) }}">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" class="form-control"
                            name="question"
                            value="{{ $faq->question }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Answer</label>
                        <textarea class="form-control"
                            name="answer"
                            rows="4"
                            required>{{ $faq->answer }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">office (optional)</label>
                        <select class="form-select" name="office_id">
                            <option value="">All offices</option>
                            @foreach($offices as $office)
                            <option value="{{ $office->id }}"
                                {{ $faq->office_id == $office->id ? 'selected':'' }}>
                                {{ $office->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Update FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<!-- ADD FAQ MODAL -->
<div class="modal fade" id="addFaq" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.faqs.store') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add New FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" class="form-control" name="question" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Answer</label>
                        <textarea class="form-control" name="answer" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">office (optional)</label>
                        <select class="form-select" name="office_id">
                            <option value="">All offices</option>
                            @foreach($offices as $office)
                            <option value="{{ $office->id }}">{{ $office->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Save FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection