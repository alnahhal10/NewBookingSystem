
@php
            $menuItems = [
                ['name' => 'Spaghetti Alla Carbonara', 'price' => 49, 'description' => 'Lorem passionate chefs masterfully', 'extra' => 'Extra free juice'],
                ['name' => 'Spaghetti Alla Carbonara', 'price' => 49, 'description' => 'Lorem passionate chefs masterfully', 'extra' => 'Extra free juice'],
                ['name' => 'Spaghetti Alla Carbonara', 'price' => 49, 'description' => 'Lorem passionate chefs masterfully', 'extra' => 'Extra free juice'],
                ['name' => 'Spaghetti Alla Carbonara', 'price' => 49, 'description' => 'Lorem passionate chefs masterfully', 'extra' => 'Extra free juice'],
                ['name' => 'Spaghetti Alla Carbonara', 'price' => 49, 'description' => 'Lorem passionate chefs masterfully', 'extra' => 'Extra free juice'],
            ]; 
        @endphp
<div class="elegancia-hero">
    <div class="elegancia-hero-content">
        <h5>Elegent Italian Food</h5>
    <h1>ELEGANCE RETREAT</h1>
    <h2>RESTAURANT</h2>
        <a href="{{ url('/elegancia') }}" class="btn btn-secondary">Explore Now</a>
    </div>
    
</div>
<!-- Food Showcase Section -->
<section class="food-showcase py-5">
    <div class="container">

        <!-- العنوان -->
        <div class="text-center mb-5">
            <p class="showcase-subtitle">Food Items</p>
            <h2 class="showcase-title">Food Showcase</h2>
        </div>

        <!-- الصور -->
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <img src="{{ asset('img/f1.jpg') }}" alt="Food 1" class="showcase-img">
            </div>
            <div class="col-md-4">
                <img src="{{ asset('img/f2.jpg') }}" alt="Food 2" class="showcase-img">
            </div>
            <div class="col-md-4">
                <img src="{{ asset('img/f3.jpg') }}" alt="Food 3" class="showcase-img">
            </div>
        </div>

    </div>
</section>
<!-- Food Menu Section -->
<section class="food-menu py-5">
    <div class="container">

        <!-- Header -->
        <div class="text-center mb-5">
            <p class="menu-subtitle">Special Selection</p>
            <h2 class="menu-title">Food Menu</h2>
        </div>

        <!-- Menu Items - Two Columns -->
        <div class="row">

            <!-- Left Column -->
            <div class="col-md-6">
                @foreach($menuItems as $item)
                <div class="menu-item">
                    <div class="menu-item-top">
                        <span class="menu-item-name" data-img="{{ asset('img/f3.jpg') }}">{{ $item['name'] }} </span>
                        <span class="menu-item-dots"></span>
                        <span class="menu-item-price">${{ $item['price'] }}</span>
                    </div>
                    <div class="menu-item-bottom">
                        <span class="menu-item-desc">{{ $item['description'] }}</span>
                        <span class="menu-item-extra">{{ $item['extra'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                @foreach($menuItems as $item)
                <div class="menu-item">
                    <div class="menu-item-top">
                        <span class="menu-item-name" data-img="{{ asset('img/f1.jpg') }}">{{ $item['name'] }}</span>
                        <span class="menu-item-dots"></span>
                        <span class="menu-item-price">${{ $item['price'] }}</span>
                    </div>
                    <div class="menu-item-bottom">
                        <span class="menu-item-desc">{{ $item['description'] }}</span>
                        <span class="menu-item-extra">{{ $item['extra'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
        @php
            $menuItems = [
                ['name' => 'Spaghetti Alla Carbonara', 'price' => 49, 'description' => 'Lorem passionate chefs masterfully', 'extra' => 'Extra free juice'],
                ['name' => 'Spaghetti Alla Carbonara', 'price' => 49, 'description' => 'Lorem passionate chefs masterfully', 'extra' => 'Extra free juice'],
                ['name' => 'Spaghetti Alla Carbonara', 'price' => 49, 'description' => 'Lorem passionate chefs masterfully', 'extra' => 'Extra free juice'],
                ['name' => 'Spaghetti Alla Carbonara', 'price' => 49, 'description' => 'Lorem passionate chefs masterfully', 'extra' => 'Extra free juice'],
                ['name' => 'Spaghetti Alla Carbonara', 'price' => 49, 'description' => 'Lorem passionate chefs masterfully', 'extra' => 'Extra free juice'],
            ];
        @endphp

        <!-- View More Button -->
        <div class="text-center mt-5">
            <a href="#" class="menu-view-more">View More</a>
        </div>

    </div>
</section>
<!-- Testimonials Section -->
<section class="testimonials py-5">
    <div class="container">
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">

            <div class="carousel-inner">

                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="testimonial-slide text-center">

                        <!-- Quote marks left -->
                        <div class="quote-left">&ldquo;</div>

                        <!-- Avatar + Name -->
                        <img src="{{ asset('img/f1.jpg') }}" alt="Steven" class="testimonial-avatar">
                        <h5 class="testimonial-name">Steven K. Roberts</h5>
                        <p class="testimonial-location">From USA</p>

                        <!-- Quote Text -->
                        <p class="testimonial-text">
                            "Their talented team of passionate chefs masterfully crafts each dish,
                            combining the finest ingredients with innovative techniques to present
                            culinary creations that are as visually stunning as they are delicious."
                        </p>

                        <!-- Quote marks right -->
                        <div class="quote-right">&rdquo;</div>

                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <div class="testimonial-slide text-center">
                        <div class="quote-left">&ldquo;</div>
                        <img src="{{ asset('img/f3.jpg') }}" alt="Maria" class="testimonial-avatar">
                        <h5 class="testimonial-name">Maria L. Johnson</h5>
                        <p class="testimonial-location">From Italy</p>
                        <p class="testimonial-text">
                            "An unforgettable dining experience. Every detail, from the ambiance
                            to the plating, reflects a deep love for the culinary arts."
                        </p>
                        <div class="quote-right">&rdquo;</div>
                    </div>
                </div>

            </div>

            <!-- Controls -->
            <div class="testimonial-controls">
                <button class="testimonial-btn" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    &#8592;
                </button>
                <button class="testimonial-btn" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    &#8594;
                </button>
            </div>

        </div>
    </div>
</section>
<!-- Opening Hours Section -->
<section class="opening-hours py-5">
    <div class="container">
        <div class="row align-items-center g-5">

            <!-- Left: Image -->
            <div class="col-md-6">
                <img src="{{ asset('img/op.jpg') }}" alt="Restaurant" class="opening-img">
            </div>

            <!-- Right: Content -->
            <div class="col-md-6">
                <h2 class="opening-title">Opening Hours</h2>

                <p class="opening-desc">
                    Lorem to our restaurant, where culinary artistry meets
                    exceptional dining experiences. At, we strive to
                    create a gastronomic haven that.
                </p>

                <div class="opening-time">
                    SUNDAY – THURSDAY: 11:30AM – 11PM
                </div>

                <div class="opening-time">
                    FRIDAY & SATURDAY: 11:30AM – 12AM
                </div>

                <a href="#" class="opening-btn">Reservation</a>
            </div>

        </div>
    </div>
</section>

<!-- Reservations Section -->
<section class="reservations-section py-5">
    <div class="container">

        <!-- Header -->
        <div class="text-center mb-5">
            <p class="res-subtitle">Reservations</p>
            <h2 class="res-title">Reservations</h2>
        </div>

        <!-- Form -->
        <form action="" method="POST">
            @csrf
            <div class="row g-0 justify-content-center">

                <!-- Guests -->
                <div class="col-md-4">
                    <select class="res-input" name="guests">
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                        <option value="4">Four</option>
                        <option value="5">Five</option>
                        <option value="6">Six+</option>
                    </select>
                </div>

                <!-- Time -->
                <div class="col-md-3">
                    <input type="time" class="res-input" name="time" value="03:45">
                </div>

                <!-- Date -->
                <div class="col-md-3">
                    <input type="date" class="res-input" name="date">
                </div>

                <!-- Button -->
                <div class="col-md-2">
                    <button type="submit" class="res-btn">Reservations</button>
                </div>

            </div>
        </form>

    </div>
</section>

<!-- Footer -->
<footer class="site-footer">
    <div class="container">

        <!-- Top: Email + Nav -->
        <div class="footer-top">
            <a href="mailto:info@example.com" class="footer-email">info@example.com</a>
            <nav class="footer-nav">
                <a href="#">Home</a>
                <a href="#">About</a>
                <a href="#">Menu</a>
                <a href="#">Blog</a>
                <a href="#">Chef</a>
                <a href="#">Contact</a>
            </nav>
        </div>

        <hr class="footer-divider">

        <!-- Bottom: Info + Button -->
        <div class="footer-bottom">

            <!-- Phone -->
            <div class="footer-col">
                <p>1-800-915-6271</p>
                <p>1-800-915-6271</p>
            </div>

            <!-- Address -->
            <div class="footer-col">
                <p>2726 AV. PAPINEAUMONTREAL,</p>
                <p>QC H2K 4J6, CANADA</p>
            </div>

            <!-- Hours -->
            <div class="footer-col">
                <p>SUNDAY – THURSDAY: 11:30AM – 11PM</p>
                <p>FRIDAY & SATURDAY: 11:30AM – 12AM</p>
            </div>

            <!-- Button -->
            <div class="footer-col">
                <a href="#" class="footer-res-btn">Reservations</a>
            </div>

        </div>

        <hr class="footer-divider">

        <!-- Copyright -->
        <p class="footer-copy">COPYRIGHT 2026 ALL RIGHT RESERVED</p>

    </div>
</footer>



@endsection
