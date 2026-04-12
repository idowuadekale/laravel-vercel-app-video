@extends('layouts.default')
@section('title', 'Programs - Lasu C&S Chapter')
@section('TopSectionName', 'Check our Programs')
@section('style')
    <style>
        :root {
            --accent-color: #2e0e8c;
            /* Accent color that represents your brand on the website. It's used for buttons, links, and other elements that need to stand out */
            --default-color: rgba(52, 36, 36, 0.8);
            /* Default color used for the majority of the text content across the entire website */
            --surface-color: #f5f3f9;
            /* The surface color is used as a background of boxed elements within sections, such as cards, icon boxes, or other elements that require a visual separation from the global background. */
        }

        .text-accent {
            color: var(--accent-color);
        }

        .text-accent:hover {
            color: rgb(30, 9, 90);
        }

        /* 🔹 Button styling - smaller + responsive + inline */
        .share-section a {
            display: inline-flex;
            align-items: center;
            font-size: 0.85rem;
            padding: 4px 8px;
            margin: 2px;
            border-radius: 8px;
            text-decoration: none;
            white-space: nowrap;
        }


        .program-details a {
            display: inline-block;
            color: var(--accent-color);
            font-weight: 500;
            font-size: 0.85rem;
            margin-top: 0.25rem;
            text-decoration: none;
        }

        .program-details a:hover {
            text-decoration: underline;
        }
    </style>
@endsection
@section('content')

    <!--================ Top section Area =================-->
    @include('includes.topsection')

    <!-- Services Section -->
    <section id="services" class="services section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="service-header">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-12">
                        <div class="service-intro">
                            <h2 class="service-heading">
                                <div>
                                    Current Administration
                                </div>
                                <div><span>Available programs</span></div>
                            </h2>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="service-summary">
                            <p>
                                Here, you’ll find information about our upcoming and past events, designed to help you grow
                                spiritually, build lasting friendships, and discover your God-given purpose.
                            </p>
                        </div>
                    </div>
                </div>
                <hr>
            </div>

            <div class="row justify-content-center">
                @forelse ($programs as $program)
                    <div class="col-lg-4 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-card position-relative z-1">
                            <div class="service-icon">
                                @if (!empty($program->image))
                                    <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->name }}"
                                        class="img-fluid rounded clickable-image" style="max-width:80px; cursor:pointer;"
                                        title="{{ $program->name }} Flyer"
                                        data-image="{{ asset('storage/' . $program->image) }}">
                                @else
                                    <img src="assets/img/gallery/no-image.jpg" alt="no-image" class="img-fluid"
                                        style="max-width:60px; cursor:not-allowed;" title="No Image">
                                @endif
                            </div>
                            <a href="{{ route('programs.show', $program->slug) }}"
                                class="card-action d-flex align-items-center justify-content-center rounded-circle">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                            <h3>
                                <a href="{{ route('programs.show', $program->slug) }}">
                                    {{ $program->name }}
                                    <span>
                                        {{ \Carbon\Carbon::parse($program->date)->format('l, F jS Y') }}
                                        <br>
                                        <small>
                                            {{ $program->semester }} -
                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $program->time)->format('g:i A') }}
                                        </small>
                                    </span>
                                </a>
                            </h3>
                            @php
                                $fetchBody = strip_tags(html_entity_decode($program->details));
                                $words = explode(' ', $fetchBody);
                                $wordCount = count($words);
                            @endphp
                            <p class="program-details" style="text-align:start">
                                @if ($wordCount <= 30)
                                    {{ $fetchBody }}
                                @else
                                    {{ implode(' ', array_slice($words, 0, 30)) }}...
                                    <a href="{{ route('programs.show', $program->slug) }}">
                                        Read More
                                    </a>
                                @endif
                            </p>
                            {{-- Share Buttons --}}
                            <div class="share-section mt-2">
                                <a href="{{ $program->rsvp }}" class="text-accent" target="_blank">
                                    <i class="fas fa-globe"></i> RSVP
                                </a>
                                <a href="javascript:void(0)" class="text-accent save-to-calendar"
                                    data-title="{{ $program->name }}"
                                    data-date="{{ $program->date }}T{{ $program->time }}" data-duration="120"
                                    data-description="{{ $program->details }}" data-location="Church Auditorium">
                                    <i class="far fa-calendar-plus"></i> Add to Calendar
                                </a>
                                {{-- Native Share (mobile) --}}
                                <a href="javascript:void(0)" class="text-accent share-program"
                                    data-title="{{ $program->name }}"
                                    data-url="{{ route('programs.show', $program->slug) }}"
                                    data-description="{{ Str::limit($program->details, 150) }}"
                                    data-date="{{ \Carbon\Carbon::parse($program->date)->format('l, F jS Y') }}"
                                    data-time="{{ \Carbon\Carbon::createFromFormat('H:i:s', $program->time)->format('g:i A') }}"
                                    data-image="{{ asset('storage/' . $program->image) ?? asset('assets/img/gallery/no-image.jpg') }}">
                                    <i class="fas fa-share-alt"></i> Share
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-transparent border-0 shadow-none">
                                <img id="modalImage" src="" class="img-fluid rounded" alt="Program Flyer">
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h4> No record found... Please check again later...</h4>
                    </div>
                @endforelse
            </div>
            <div class="container">
                <nav class="blog-pagination justify-content-center d-flexo mt-4">
                    {{ $programs->links('pagination::bootstrap-5') }}
                </nav>
            </div>
            {{-- <div class="p-2">
            {{ $programs->links('pagination::bootstrap-5') }}
        </div> --}}

            <!--================ Pagination Area =================-->
            @include('includes.pagination')
        </div>
    </section><!-- /Services Section -->


@endsection
@section('script')
    <script>
        $(document).ready(function() {

            document.addEventListener('click', function(e) {
                let shareBtn = e.target.closest('.share-program');
                if (shareBtn) {
                    let title = shareBtn.getAttribute('data-title');
                    let details = shareBtn.getAttribute('data-description');
                    let date = shareBtn.getAttribute('data-date');
                    let time = shareBtn.getAttribute('data-time');
                    let url = shareBtn.getAttribute('data-url');
                    let image = shareBtn.getAttribute('data-image');

                    let fullMessage =
                        `${title}\n\n${details}\n\n📅 ${date} at ${time}\n🖼 Flyer: ${image}\n🔗 RSVP: ${url}`;

                    if (navigator.share) {
                        navigator.share({
                            title: title,
                            text: fullMessage,
                            url: url
                        }).catch(err => console.log('Share cancelled:', err));
                    } else {
                        // Fallback if share not supported
                        alert("Copy and share this:\n\n" + fullMessage);
                    }
                }
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('toggle-details')) {
                    let p = e.target.closest('p');
                    p.querySelector('.short-text').classList.toggle('d-none');
                    p.querySelector('.full-text').classList.toggle('d-none');
                    e.target.textContent = e.target.textContent === 'Read More' ? 'Show Less' : 'Read More';
                }
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('clickable-image')) {
                    let img = e.target.getAttribute('data-image');
                    document.getElementById('modalImage').src = img;
                    new bootstrap.Modal(document.getElementById('imageModal')).show();
                }
            });

            // Handle all calendar save links
            document.addEventListener('click', function(e) {
                if (e.target.closest('.save-to-calendar')) {
                    e.preventDefault();
                    const link = e.target.closest('.save-to-calendar');
                    addToCalendarDirectly(link);
                }
            });

            function addToCalendarDirectly(link) {
                const title = link.getAttribute('data-title');
                const dateStr = link.getAttribute('data-date');
                const duration = parseInt(link.getAttribute('data-duration')) || 120; // Default 2 hours
                const description = link.getAttribute('data-description') || '';
                const location = link.getAttribute('data-location') || '';

                try {
                    const startDate = new Date(dateStr);
                    const endDate = new Date(startDate.getTime() + duration * 60000);

                    // 1. First try the Web Calendar API (works on some mobile devices)
                    if (navigator.calendar && navigator.calendar.createEvent) {
                        navigator.calendar.createEvent({
                            title: title,
                            location: location,
                            description: description,
                            startDate: startDate,
                            endDate: endDate
                        });
                        showSavedFeedback(link);
                        return;
                    }

                    // 2. Try the MS Outlook protocol (works for Outlook desktop)
                    if (navigator.userAgent.includes('Windows')) {
                        const outlookUrl = generateOutlookUrl(title, startDate, endDate, description, location);
                        window.location.href = outlookUrl;
                        setTimeout(() => showSavedFeedback(link), 500);
                        return;
                    }

                    // 3. Try the Google Calendar web interface
                    const googleUrl = generateGoogleCalendarUrl(title, startDate, endDate, description, location);
                    window.open(googleUrl, '_blank');
                    showSavedFeedback(link);

                } catch (error) {
                    console.error('Error adding to calendar:', error);
                    // Fallback to manual .ics download if all else fails
                    downloadIcsFile(title, startDate, endDate, description, location);
                    showSavedFeedback(link);
                }
            }

            function generateGoogleCalendarUrl(title, startDate, endDate, description, location) {
                const format = (date) => date.toISOString().replace(/-|:|\.\d+/g, '');
                return `https://www.google.com/calendar/render?action=TEMPLATE` +
                    `&text=${encodeURIComponent(title)}` +
                    `&dates=${format(startDate)}/${format(endDate)}` +
                    `&details=${encodeURIComponent(description)}` +
                    `&location=${encodeURIComponent(location)}` +
                    `&sf=true&output=xml`;
            }

            function generateOutlookUrl(title, startDate, endDate, description, location) {
                const format = (date) => date.toISOString().replace(/-|:|\.\d+/g, '').slice(0, 15) + 'Z';
                return `outlookcal:${format(startDate)}/${format(endDate)}` +
                    `?subject=${encodeURIComponent(title)}` +
                    `&body=${encodeURIComponent(description)}` +
                    `&location=${encodeURIComponent(location)}`;
            }

            function downloadIcsFile(title, startDate, endDate, description, location) {
                const icsData = [
                    'BEGIN:VCALENDAR',
                    'VERSION:2.0',
                    'BEGIN:VEVENT',
                    `UID:${Date.now()}@yourdomain.com`,
                    `DTSTAMP:${new Date().toISOString().replace(/-|:|\.\d+/g, '')}`,
                    `DTSTART:${startDate.toISOString().replace(/-|:|\.\d+/g, '')}`,
                    `DTEND:${endDate.toISOString().replace(/-|:|\.\d+/g, '')}`,
                    `SUMMARY:${title}`,
                    `DESCRIPTION:${description.replace(/\n/g, '\\n')}`,
                    `LOCATION:${location}`,
                    'END:VEVENT',
                    'END:VCALENDAR'
                ].join('\r\n');

                // Create invisible iframe to handle the download
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.src = URL.createObjectURL(new Blob([icsData], {
                    type: 'text/calendar'
                }));
                document.body.appendChild(iframe);
                setTimeout(() => document.body.removeChild(iframe), 1000);
            }
        });
    </script>
@endsection
