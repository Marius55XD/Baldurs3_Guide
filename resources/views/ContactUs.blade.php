@extends('layouts.app')
@section('title', 'Contact Us')

@push('styles')
<style>
	.contact-shell {
		padding: 1.5rem 0 2.5rem;
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
</style>
@endpush

@section('content')
<div class="container contact-shell">
	<div class="row justify-content-center">
		<section class="col-lg-9 contact-section">
			<h1 class="h1 contact-form-title">Send us a message</h1>
			<form method="POST" action="#">
				@csrf
				<div class="mb-3">
					<label for="contact_name" class="form-label contact-label">Your Name</label>
					<input id="contact_name" name="name" type="text" class="form-control" placeholder="Enter your name">
				</div>
				<div class="mb-3">
					<label for="contact_email" class="form-label contact-label">Your Email</label>
					<input id="contact_email" name="email" type="email" class="form-control" placeholder="Enter your email address">
				</div>
				<div class="mb-3">
					<label for="contact_subject" class="form-label contact-label">Subject</label>
					<input id="contact_subject" name="subject" type="text" class="form-control" placeholder="Subject of your message">
				</div>
				<div class="mb-3">
					<label for="contact_message" class="form-label contact-label">Message</label>
					<textarea id="contact_message" name="message" class="form-control" rows="5" placeholder="Type your message here..."></textarea>
				</div>
				<button type="submit" class="btn btn-outline-secondary px-4">Send Message</button>
			</form>
		</section>
	</div>
</div>
@endsection
