@extends('layouts.app')

@section('title', 'FAQs')

@section('content')
<div class="container">

    <h5 class="mb-3">
        <i class="bi bi-question-circle"></i> Frequently Asked Questions
    </h5>

    <div class="accordion" id="faqAccordion">

        @foreach($faqs as $faq)
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq{{ $faq->id }}">
                    {{ $faq->question }}
                </button>
            </h2>

            <div id="faq{{ $faq->id }}" class="accordion-collapse collapse">
                <div class="accordion-body">
                    {!! nl2br(e($faq->answer)) !!}
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
@endsection