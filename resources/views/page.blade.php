<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>
<body>

    {{-- Main loop to display all page sections --}}
    @if($page->sections)
        @foreach($page->sections as $section)
            @switch($section['section_type'])

                @case('HeroSection')
                    <section class="page_hero" style="background-image: url('{{ asset('storage/' . $section['background_image']) }}');">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="page_hero_content">
                                        <h1 class="text-white">{{ $section['title'] }}</h1>
                                        @if(!empty($section['subtitle']))
                                            <p class="text-white">{{ $section['subtitle'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    @break

                @case('TextWithImages')
                    <section class="feature_section py-5">
                        <div class="container">
                            <div class="row">
                                @foreach($section['items'] ?? [] as $item)
                                    <div class="col-md-4 mb-4">
                                        <div class="feature_item">
                                            @if(!empty($item['image']))
                                                <img src="{{ asset('storage/' . $item['image']) }}" class="img-fluid" alt="{{ $item['title'] }}">
                                            @endif
                                            @if(!empty($item['title']))
                                                <h3 class="mt-3">{{ $item['title'] }}</h3>
                                            @endif
                                            @if(!empty($item['description']))
                                                <p>{{ $item['description'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                    @break

                @case('FAQs')
                    <section class="faq_section py-5">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="section-title text-center mb-4">
                                        <h2>Frequently Asked Questions</h2>
                                    </div>
                                    <div class="accordion" id="faqAccordion-{{ $loop->index }}">
                                        @foreach($section['items'] ?? [] as $index => $faq)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading-{{ $loop->parent->index }}-{{ $index }}">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->parent->index }}-{{ $index }}" aria-expanded="false">
                                                        {{ $faq['question'] }}
                                                    </button>
                                                </h2>
                                                <div id="collapse-{{ $loop->parent->index }}-{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion-{{ $loop->index }}">
                                                    <div class="accordion-body">
                                                        {{ $faq['answer'] }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    @break

                @case('Carousel')
                    <section class="slider_section py-5">
                        <div class="container">
                            <div class="owl-carousel owl-theme">
                                @foreach($section['slides'] ?? [] as $slide)
                                    <div class="item">
                                        <img src="{{ asset('storage/' . $slide['image']) }}" alt="{{ $slide['caption'] ?? '' }}">
                                        @if(!empty($slide['caption']))
                                            <div class="carousel-caption d-none d-md-block">
                                                <p>{{ $slide['caption'] }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                    @break

                @case('TextEditor')
                    <section class="py-5">
                        <div class="container">
                            <div class="content-area">
                                {!! $section['content'] ?? '' !!}
                            </div>
                        </div>
                    </section>
                    @break

            @endswitch
        @endforeach
    @endif

    {{-- "Edit Page" button for logged-in admins --}}
    @auth
        @if (auth()->user()->canAccessPanel(\Filament\Facades\Filament::getPanel('admin')))
            <a href="{{ \App\Filament\Resources\PageResource::getUrl('edit', ['record' => $page]) }}"
               style="position: fixed; bottom: 20px; right: 20px; background-color: #005188; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; z-index: 1000;"
               target="_blank">
                Edit this Page
            </a>
        @endif
    @endauth

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.fancybox.min.js') }}"></script>
    <script>
        // Initialize Owl Carousel
        $(document).ready(function(){
            $('.owl-carousel').owlCarousel({
                loop:true,
                margin:10,
                nav:true,
                responsive:{
                    0:{ items:1 },
                    600:{ items:2 },
                    1000:{ items:3 }
                }
            });
        });
    </script>

</body>
</html>
