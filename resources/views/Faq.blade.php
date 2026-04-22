@extends('layouts.app')
@section('title', 'FAQ')

@push('styles')
<style>
    .faq-shell {
        padding: 1.5rem 0 2.5rem;
    }
    @media (max-width: 991.98px) {
        .faq-shell {
            padding-left: 0.95rem;
            padding-right: 0.95rem;
        }
    }
    @media (max-width: 575.98px) {
        .faq-shell {
            padding-left: 1rem;
            padding-right: 1rem;
            padding-top: 1.25rem;
        }
    }
    .support-side-title {
        color: var(--bg3-gold);
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .support-side-link {
        display: block;
        color: #d8ebff;
        text-decoration: none;
        margin-bottom: 0.75rem;
    }
    .support-side-link:hover {
        color: var(--bg3-gold);
    }
    .faq-title {
        color: var(--bg3-gold);
        font-weight: 700;
    }
    .faq-note {
        color: #d8ebff;
        opacity: 0.92;
    }
    .accordion-item {
        background-color: var(--bg3-card);
        border: 1px solid var(--bg3-border);
    }
    .accordion-button {
        background-color: #0f2a3e;
        color: #d8ebff;
        font-weight: 600;
        box-shadow: none;
    }
    .accordion-button:not(.collapsed) {
        background-color: #123047;
        color: var(--bg3-gold);
    }
    .accordion-button:focus {
        box-shadow: 0 0 0 0.2rem rgba(103, 232, 249, 0.2);
    }
    .accordion-button::after {
        filter: invert(1) brightness(1.8);
    }
    .accordion-body {
        color: #d8ebff;
        background-color: #0e2436;
        line-height: 1.75;
    }
</style>
@endpush

@section('content')
<div class="container faq-shell">
    <div class="row g-4">
        <aside class="col-lg-3">
            <div class="sidebar-card">
                <h2 class="h4 support-side-title">Contact Us</h2>
                <a class="support-side-link" href="{{ route('contact') }}"><i class="bi bi-envelope-fill me-2"></i>Email Support</a>
                <a class="support-side-link" href="{{ route('phone.support') }}"><i class="bi bi-telephone-fill me-2"></i>Phone Support</a>
                <a class="support-side-link mb-0" href="{{ route('faq') }}"><i class="bi bi-question-circle-fill me-2"></i>FAQ</a>
            </div>
        </aside>

        <div class="col-lg-9">
            <h1 class="faq-title mb-2"><i class="bi bi-question-circle-fill me-2"></i>Frequently Asked Questions</h1>
            <p class="faq-note mb-4">Answers to common questions about using BG3 Guide.</p>

            <div class="accordion" id="faqAccordion">
                <div class="accordion-item mb-2">
                    <h2 class="accordion-header" id="q1Header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#q1" aria-expanded="true" aria-controls="q1">
                            How do I find guides for a specific class or build?
                        </button>
                    </h2>
                    <div id="q1" class="accordion-collapse collapse show" aria-labelledby="q1Header" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Go to the Guides page and use categories and search to filter results by class, topic, or keyword.
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-2">
                    <h2 class="accordion-header" id="q2Header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q2" aria-expanded="false" aria-controls="q2">
                            Can I submit corrections or suggest guide updates?
                        </button>
                    </h2>
                    <div id="q2" class="accordion-collapse collapse" aria-labelledby="q2Header" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes. Use the Contact Us form and include the guide title, section, and the suggested correction.
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-2">
                    <h2 class="accordion-header" id="q3Header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q3" aria-expanded="false" aria-controls="q3">
                            Do I need an account to read guides?
                        </button>
                    </h2>
                    <div id="q3" class="accordion-collapse collapse" aria-labelledby="q3Header" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            No. Reading guides is public. An account is only needed for profile-related features and community actions.
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-2">
                    <h2 class="accordion-header" id="q4Header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q4" aria-expanded="false" aria-controls="q4">
                            Who maintains BG3 Guide?
                        </button>
                    </h2>
                    <div id="q4" class="accordion-collapse collapse" aria-labelledby="q4Header" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            BG3 Guide is maintained by Marius Stuopelis and Gvidonas Buikys.
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-2">
                    <h2 class="accordion-header" id="q5Header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q5" aria-expanded="false" aria-controls="q5">
                            How long does it take to get a reply from Contact Us?
                        </button>
                    </h2>
                    <div id="q5" class="accordion-collapse collapse" aria-labelledby="q5Header" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            We usually review and respond within a few business days, depending on message volume.
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-2">
                    <h2 class="accordion-header" id="q6Header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q6" aria-expanded="false" aria-controls="q6">
                            Can I request a guide for a specific quest or class?
                        </button>
                    </h2>
                    <div id="q6" class="accordion-collapse collapse" aria-labelledby="q6Header" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes. Send your request through Contact Us with as much detail as possible, and we will prioritize based on demand.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="q7Header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q7" aria-expanded="false" aria-controls="q7">
                            Is BG3 Guide an official Larian Studios website?
                        </button>
                    </h2>
                    <div id="q7" class="accordion-collapse collapse" aria-labelledby="q7Header" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            No. BG3 Guide is an unofficial fan-made project and is not affiliated with Larian Studios.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
