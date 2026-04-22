@extends('layouts.app')
@section('title', 'About Us')

@push('styles')
<style>
	.about-shell {
		padding: 2rem 0 3rem;
	}
	@media (max-width: 991.98px) {
		.about-shell {
			padding-left: 0.95rem;
			padding-right: 0.95rem;
		}
	}
	@media (max-width: 575.98px) {
		.about-shell {
			padding-left: 1rem;
			padding-right: 1rem;
			padding-top: 1.35rem;
		}
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
	.about-text {
		color: #d8ebff;
		line-height: 1.8;
	}
	.about-list {
		padding-left: 1.1rem;
		margin-bottom: 0;
	}
	.about-list li {
		margin-bottom: 0.5rem;
		color: #d8ebff;
	}
	.about-list li:last-child {
		margin-bottom: 0;
	}
	.team-grid {
		display: grid;
		grid-template-columns: repeat(2, minmax(0, 1fr));
		gap: 1rem;
	}
	.team-member {
		background-color: rgba(143, 179, 217, 0.07);
		border: 1px solid var(--bg3-border);
		border-radius: 8px;
		padding: 1rem;
	}
	@media (max-width: 767.98px) {
		.team-grid {
			grid-template-columns: 1fr;
		}
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
				<p class="about-text mb-3">
					BG3 Guide exists to make Baldur's Gate 3 easier to learn and more fun to master.
					We collect practical, tested tips so players can spend less time searching and more
					time adventuring.
				</p>
				<p class="about-text mb-3">
					Our focus is clarity. We explain mechanics in plain language, highlight common mistakes,
					and provide step-by-step guidance that works for casual and experienced players alike.
				</p>
				<ul class="about-list">
					<li>Publish clear walkthroughs for quests and hidden outcomes.</li>
					<li>Share class and party build ideas for different playstyles.</li>
					<li>Keep guides beginner-friendly without losing depth for veterans.</li>
				</ul>
			</div>

			<div id="team" class="bg3-card p-4 p-md-5 mb-4">
				<h3 class="text-gold mb-4">Our Team</h3>
				<div class="team-grid">
					<div class="team-member">
						<h4 class="h5 text-gold mb-3"><i class="bi bi-person-circle me-2"></i>Marius Stuopelis</h4>
						<p class="about-text mb-2"><strong>College:</strong> DKIT</p>
						<p class="about-text mb-0"><strong>Program:</strong> Software Development</p>
					</div>
					<div class="team-member">
						<h4 class="h5 text-gold mb-3"><i class="bi bi-person-circle me-2"></i>Gvidonas Buikys</h4>
						<p class="about-text mb-2"><strong>College:</strong> DKIT</p>
						<p class="about-text mb-0"><strong>Program:</strong> Software Development</p>
					</div>
				</div>
			</div>

			<div id="community" class="bg3-card p-4 p-md-5">
				<h3 class="text-gold mb-4">Community</h3>
				<p class="about-text mb-3">
					BG3 Guide grows through player feedback. If you find a better route, a stronger build,
					or a missed detail in a guide, we want to hear it.
				</p>
				<p class="about-text mb-4">
					New contributors are welcome. You can start by creating an account and sharing your
					favorite tactics with the community.
				</p>
				<p class="about-text mb-4">
					As the game updates, we keep refining existing guides so the information stays relevant,
					accurate, and useful for every new playthrough.
				</p>
				<div class="d-flex flex-wrap gap-2">
					<a href="{{ route('register') }}" class="btn btn-gold">
						<i class="bi bi-person-plus me-2"></i>Join Our Community
					</a>
					<a href="{{ route('guides.index') }}" class="btn btn-outline-gold">
						<i class="bi bi-book me-2"></i>Browse Guides
					</a>
				</div>
			</div>
		</section>
	</div>
</div>
@endsection
