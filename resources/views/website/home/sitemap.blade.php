@extends('layouts.website')

@section('content')
<div class="section form-header">   
    <div class="content">
        <div class="header-desc">
            <center>
                <h1 class="text-capitalize">sitemap</h1>
            </center>
            <p>&nbsp;</p>
        </div>
    </div>
</div>
<div class="section ssx-info container-fluid">
    <div class="content">
		<h4 class="sitemap-h4"><a href="{{ route('home') }}">HOMEPAGE</a></h4>
		<ul class="sitemap-menu">
			<li><a href="{{ route('events-activities.index') }}">Events & Activities</a>
				<ul>
					<li><a href="{{ route('events-activities.index') }}">Featured Partner Events</a></li>
					<li><a href="{{ route('events-activities.index') }}#global-initiatives">Global Initiatives</a></li>
					<li><a href="{{ route('events-activities.index') }}#webinars">Webinars</a></li>
					<li><a href="{{ route('events-activities.index') }}#local-highlights">Local Highlights</a></li>
					<li><a href="{{ route('events-activities.index') }}#on-demand-resources">On-Demand Resources</a></li>
				</ul>
			</li>
			<li><a href="{{ route('about-us') }}">About</a>				
				<ul>
					<li><a href="{{ route('about-us') }}">About SSX</a></li>
					<li><a href="{{ route('about-us') }}">Event Components</a></li>
					<li><a href="{{ route('about-us') }}">Partners</a></li>
					<li><a href="{{ route('about-us') }}">Organizers</a></li>
					<li><a href="{{ route('about-us') }}#contactUs">Contact Us</a></li>
				</ul>
			</li>
			<li><a href="javascript:;">Directory</a>	
				<ul>
					<li><a href="{{ route('solutions.directories.index') }}">Suppliers/Exhibitors</a></li>
					<li><a href="{{ route('solutions.sustainable.index') }}">Sustainable Solutions</a></li>
				</ul>
			</li>
			<li><a href="javascript:;">Services</a>
				<ul>
					<li><a href="{{ route('services.export-enablers.index') }}">Export Enablers</a></li>
				</ul>
			</li>
			<li><a href="javascript:;">Resources and News</a>			
				<ul>
					<li><a href="{{ route('news-articles.index') }}">News & Articles</a></li>
					<li><a href="{{ route('solutions.intelligence.index') }}">Solutions Intelligence</a></li>
					<li><a href="{{ route('resources-news.digital-exhibition-conference-2022.index') }}">Digital Exhibition & Conference 2025</a></li>
					<li><a href="{{ route('news-articles.index') }}">Ambisyon Natin 2040</a></li>
					<li><a href="https://www.sec.gov.ph/wp-content/uploads/2019/10/2019MCNo04.pdf" target="_blank">SEC Sustainability Reporting Guidelines</a></li>
					<li><a href="{{ route('certifications.index') }}">Glossary of Certifications</a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>
@endsection

@push('styles')
@endpush
@push('scripts')
@endpush