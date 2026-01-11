@extends('layouts.app')

@section('title', 'FAQs')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h5><i class="bi bi-question-circle"></i> FAQs</h5>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaq">
            Add FAQ
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th width="30%">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($faqs as $index => $faq)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ Str::limit($faq->question, 60) }}</td>
                        <td>{{ $faq->department->name ?? 'All' }}</td>
                        <td>
                            <span class="badge {{ $faq->is_active ? 'bg-success':'bg-secondary' }}">
                                {{ $faq->is_active ? 'Active':'Hidden' }}
                            </span>
                        </td>
                        <td>
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
                                Show
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
                                        <strong>Department:</strong>
                                        {{ $faq->department->name ?? 'All Departments' }}
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
                                            <label class="form-label">Department (optional)</label>
                                            <select class="form-select" name="department_id">
                                                <option value="">All Departments</option>
                                                @foreach($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ $faq->department_id == $department->id ? 'selected':'' }}>
                                                    {{ $department->name }}
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
                </tbody>
            </table>

            {{ $faqs->links() }}
        </div>
    </div>
</div>

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
                        <label class="form-label">Department (optional)</label>
                        <select class="form-select" name="department_id">
                            <option value="">All Departments</option>
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
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