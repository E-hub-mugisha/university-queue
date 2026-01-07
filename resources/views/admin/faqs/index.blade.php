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
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($faqs as $index => $faq)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ Str::limit($faq->question, 60) }}</td>
                        <td>{{ $faq->department->name ?? 'All' }}</td>
                        <td>
                            <span class="badge {{ $faq->is_active ? 'bg-success':'bg-secondary' }}">
                                {{ $faq->is_active ? 'Active':'Hidden' }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.faqs.toggle',$faq) }}" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-warning">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.faqs.destroy',$faq) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $faqs->links() }}

        </div>
    </div>
</div>

<!-- edit FAQ Modal -->
<div class="modal fade" id="editFaqModal" tabindex="-1" aria-labelledby="editFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.faqs.update', 0) }}" id="editFaqForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editFaqModalLabel">Edit FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_question" class="form-label">Question</label>
                        <input type="text" class="form-control" id="edit_question" name="question" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_answer" class="form-label">Answer</label>
                        <textarea class="form-control" id="edit_answer" name="answer" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_department_id" class="form-label">Department (optional)</label>
                        <select class="form-select" id="edit_department_id" name="department_id">
                            <option value="">All Departments</option>
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add FAQ Modal -->
<div class="modal fade" id="addFaq" tabindex="-1" aria-labelledby="addFaqLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.faqs.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addFaqLabel">Add New FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <input type="text" class="form-control" id="question" name="question" required>
                    </div>
                    <div class="mb-3">
                        <label for="answer" class="form-label">Answer</label>
                        <textarea class="form-control" id="answer" name="answer" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Department (optional)</label>
                        <select class="form-select" id="department_id" name="department_id">
                            <option value="">All Departments</option>
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection