@extends('layouts.app')
@section('title', 'About Us')

@push('styles')
<style>
	.about-shell {
		padding: 2rem 0 3rem;
	}
	.about-sidebar {
		position: sticky;
		top: 1rem;
	}
	.about-link {
		display: block;
		padding: 0.6rem 0;
		color: #d8ebff;
		text-decoration: none;
	}
	.about-link:hover {
		color: var(--bg3-gold);
	}
	.layout-line {
		height: 10px;
		border-radius: 999px;
		background: linear-gradient(90deg, rgba(143, 179, 217, 0.24), rgba(143, 179, 217, 0.08));
		margin-bottom: 0.75rem;
	}
	.layout-line.w-100 { width: 100%; }
	.layout-line.w-90 { width: 90%; }
	.layout-line.w-75 { width: 75%; }
	.layout-line.w-60 { width: 60%; }
	.layout-btn {
		width: 220px;
		height: 46px;
		border-radius: 8px;
		border: 1px solid var(--bg3-border);
		background-color: rgba(143, 179, 217, 0.08);
	}
</style>
@endpush

@section('content')
<div class="container about-shell">
	<div class="row g-4">
		<aside class="col-lg-3">
			<div class="sidebar-card about-sidebar">
				<h2 class="h4 text-gold mb-3">About Us</h2>
				<a class="about-link" href="#mission"><i class="bi bi-bullseye me-2"></i>Mission</a>
				<a class="about-link" href="#team"><i class="bi bi-people me-2"></i>Team</a>
				<a class="about-link" href="#community"><i class="bi bi-chat-dots me-2"></i>Community</a>
			</div>
		</aside>

		<section class="col-lg-9">
			<div id="mission" class="bg3-card p-4 p-md-5 mb-4">
				<h3 class="text-gold mb-4">Our Mission</h3>
				<div class="layout-line w-100"></div>
				<div class="layout-line w-100"></div>
				<div class="layout-line w-90"></div>
				<div class="layout-line w-75"></div>
			</div>

			<div id="team" class="bg3-card p-4 p-md-5 mb-4">
				<h3 class="text-gold mb-4">Our Team</h3>
				<div class="layout-line w-100"></div>
				<div class="layout-line w-90"></div>
				<div class="layout-line w-100"></div>
				<div class="layout-line w-60"></div>
			</div>

			<div id="community" class="bg3-card p-4 p-md-5">
				<h3 class="text-gold mb-4">Community</h3>
				<div class="layout-line w-100"></div>
				<div class="layout-line w-90"></div>
				<div class="layout-line w-75"></div>
				<div class="layout-btn mt-4"></div>
			</div>
		</section>
	</div>
</div>
@endsection
