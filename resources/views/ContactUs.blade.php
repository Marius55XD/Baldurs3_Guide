@extends('layouts.app')
@section('title', 'Contact Us')

@push('styles')
<style>
	.contact-shell {
		padding: 1.5rem 0 2.5rem;
	}
	.contact-side-title {
		color: var(--bg3-gold);
		font-weight: 700;
		margin-bottom: 1rem;
	}
	.contact-side-link {
		display: block;
		color: #d8ebff;
		text-decoration: none;
		margin-bottom: 0.75rem;
	}
	.contact-side-link:hover {
		color: var(--bg3-gold);
	}
	.contact-section {
		background-color: transparent;
	}
	.contact-form-title {
		color: var(--bg3-gold);
		font-weight: 700;
		margin-bottom: 1rem;
	}
	.contact-label {
		color: #d8ebff;
		font-weight: 600;
		margin-bottom: 0.35rem;
	}
	@media (max-width: 991.98px) {
		.contact-shell {
			padding-left: 0.85rem;
			padding-right: 0.85rem;
		}
	}
	@media (max-width: 575.98px) {
		.contact-shell {
			padding-left: 1rem;
			padding-right: 1rem;
			padding-top: 1.25rem;
		}
	}
</style>
@endpush

@section('content')
<div class="container contact-shell">
	<div class="row g-4">
		<aside class="col-lg-3">
			<div class="sidebar-card">
				<h2 class="h4 contact-side-title">Contact Us</h2>
				<a class="contact-side-link" href="#"><i class="bi bi-envelope-fill me-2"></i>Email Support</a>
				<a class="contact-side-link" href="{{ route('phone.support') }}"><i class="bi bi-telephone-fill me-2"></i>Phone Support</a>
				<a class="contact-side-link mb-0" href="{{ route('faq') }}"><i class="bi bi-question-circle-fill me-2"></i>FAQ</a>
			</div>
		</aside>

		<section class="col-lg-9 contact-section">
			<h1 class="h1 contact-form-title">Send us a message</h1>
			@if (session('error'))
				<div class="alert alert-danger" role="alert">
					{{ session('error') }}
				</div>
			@endif
			<form method="POST" action="{{ route('contact.send') }}">
				@csrf
				<div class="mb-3">
					<label for="contact_name" class="form-label contact-label">Your Name</label>
					<input id="contact_name" name="name" type="text" class="form-control" placeholder="Enter your name" value="{{ old('name') }}">
					@error('name')
						<div class="text-danger small mt-1">{{ $message }}</div>
					@enderror
				</div>
				<div class="mb-3">
					<label for="contact_email" class="form-label contact-label">Your Email</label>
					<input id="contact_email" name="email" type="email" class="form-control" placeholder="Enter your email address" value="{{ old('email') }}">
					@error('email')
						<div class="text-danger small mt-1">{{ $message }}</div>
					@enderror
				</div>
				<div class="mb-3">
					<label for="contact_subject" class="form-label contact-label">Subject</label>
					<input id="contact_subject" name="subject" type="text" class="form-control" placeholder="Subject of your message" value="{{ old('subject') }}">
					@error('subject')
						<div class="text-danger small mt-1">{{ $message }}</div>
					@enderror
				</div>
				<div class="mb-3">
					<label for="contact_message" class="form-label contact-label">Message</label>
					<textarea id="contact_message" name="message" class="form-control" rows="5" placeholder="Type your message here...">{{ old('message') }}</textarea>
					@error('message')
						<div class="text-danger small mt-1">{{ $message }}</div>
					@enderror
				</div>
				<button type="submit" class="btn btn-outline-secondary px-4">Send Message</button>
			</form>
		</section>
	</div>
</div>
@endsection
