<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'privacy-policy',
                'title' => 'Privacy Policy',
                'content' => '<p>Last updated: July 23, 2026</p>
        
<h2 class="font-headline-md text-headline-md text-on-background mt-lg">1. Introduction</h2>
<p>Welcome to SIBENGKEL. We respect your privacy and are committed to protecting your personal data. This privacy policy will inform you about how we look after your personal data when you visit our website and tell you about your privacy rights and how the law protects you.</p>

<h2 class="font-headline-md text-headline-md text-on-background mt-lg">2. The Data We Collect About You</h2>
<p>We may collect, use, store and transfer different kinds of personal data about you which we have grouped together as follows:</p>
<ul class="list-disc pl-6 space-y-2 mt-sm">
    <li><strong>Identity Data:</strong> includes first name, last name, username or similar identifier.</li>
    <li><strong>Contact Data:</strong> includes billing address, delivery address, email address and telephone numbers.</li>
    <li><strong>Vehicle Data:</strong> includes license plate, make, model, and year of the vehicle you register for services.</li>
    <li><strong>Transaction Data:</strong> includes details about payments to and from you and other details of products and services you have purchased from us.</li>
</ul>

<h2 class="font-headline-md text-headline-md text-on-background mt-lg">3. How We Use Your Personal Data</h2>
<p>We will only use your personal data when the law allows us to. Most commonly, we will use your personal data in the following circumstances:</p>
<ul class="list-disc pl-6 space-y-2 mt-sm">
    <li>Where we need to perform the contract we are about to enter into or have entered into with you (e.g. providing vehicle maintenance).</li>
    <li>Where it is necessary for our legitimate interests (or those of a third party) and your interests and fundamental rights do not override those interests.</li>
    <li>Where we need to comply with a legal obligation.</li>
</ul>'
            ],
            [
                'slug' => 'terms-of-service',
                'title' => 'Terms of Service',
                'content' => '<p>Last updated: July 23, 2026</p>
        
<h2 class="font-headline-md text-headline-md text-on-background mt-lg">1. Agreement to Terms</h2>
<p>By accessing or using our services, you agree to be bound by these Terms of Service. If you disagree with any part of the terms, then you may not access our services.</p>

<h2 class="font-headline-md text-headline-md text-on-background mt-lg">2. Booking and Appointments</h2>
<p>When you book a service through SIBENGKEL, you agree to provide accurate, current, and complete information. We reserve the right to refuse or cancel any booking if fraud or an unauthorized or illegal transaction is suspected.</p>

<h2 class="font-headline-md text-headline-md text-on-background mt-lg">3. Spareparts and Services</h2>
<p>All spare parts are subject to availability. Prices for our products are subject to change without notice. We reserve the right at any time to modify or discontinue the Service (or any part or content thereof) without notice at any time.</p>

<h2 class="font-headline-md text-headline-md text-on-background mt-lg">4. User Accounts</h2>
<p>You are responsible for maintaining the confidentiality of your account and password, including but not limited to the restriction of access to your computer and/or account. You agree to accept responsibility for any and all activities or actions that occur under your account and/or password.</p>'
            ],
            [
                'slug' => 'contact-us',
                'title' => 'Contact Us',
                'content' => '<div class="grid md:grid-cols-2 gap-xl">
    <div class="space-y-md text-on-surface-variant font-body-md text-body-md">
        <p>Have a question or need assistance? Our team is here to help you with your vehicle\'s needs.</p>
        
        <div class="space-y-4 mt-lg">
            <div class="flex items-start gap-4">
                <span class="material-symbols-outlined text-primary text-3xl">location_on</span>
                <div>
                    <h3 class="font-headline-sm text-headline-sm text-on-background font-bold mb-1">Our Workshop</h3>
                    <p>Jl. Raya Industri No. 123<br>Kawasan Otomotif, Jakarta 10110</p>
                </div>
            </div>
            
            <div class="flex items-start gap-4">
                <span class="material-symbols-outlined text-primary text-3xl">call</span>
                <div>
                    <h3 class="font-headline-sm text-headline-sm text-on-background font-bold mb-1">Phone Number</h3>
                    <p>+62 21 1234 5678</p>
                    <p class="text-sm mt-1">Available Mon-Sat, 08:00 - 17:00 WIB</p>
                </div>
            </div>
            
            <div class="flex items-start gap-4">
                <span class="material-symbols-outlined text-primary text-3xl">mail</span>
                <div>
                    <h3 class="font-headline-sm text-headline-sm text-on-background font-bold mb-1">Email Address</h3>
                    <p>info@sibengkel.web.id</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg">
        <h3 class="font-headline-md text-headline-md text-on-background font-bold mb-md">Send us a message</h3>
        <form class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text" class="w-full rounded border-outline-variant p-2" placeholder="Your full name">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" class="w-full rounded border-outline-variant p-2" placeholder="your@email.com">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Message</label>
                <textarea class="w-full rounded border-outline-variant p-2 min-h-[120px]" placeholder="How can we help you?"></textarea>
            </div>
            <button type="button" class="bg-primary text-on-primary font-bold py-2 px-6 rounded hover:opacity-90 w-full transition-opacity">
                Send Message
            </button>
        </form>
    </div>
</div>'
            ],
            [
                'slug' => 'support',
                'title' => 'Help & Support',
                'content' => '<div class="space-y-xl">
    <div class="relative max-w-2xl mx-auto mb-xl">
        <span class="material-symbols-outlined absolute left-4 top-3 text-on-surface-variant">search</span>
        <input type="text" id="faq-search" class="w-full pl-12 pr-4 py-3 rounded-full border border-outline-variant focus:border-primary shadow-sm" placeholder="Search for help (e.g., How to book a service?)">
    </div>

    <div>
        <h2 class="font-headline-md text-headline-md text-on-background font-bold mb-md">Frequently Asked Questions</h2>
        <div class="space-y-4" id="faq-list">
            <div class="faq-item border border-outline-variant rounded-lg p-4 bg-surface-container-lowest transition-all">
                <h3 class="font-bold text-lg mb-2">How do I book a service appointment?</h3>
                <p class="text-on-surface-variant">You can easily book a service by logging into your Customer Portal, selecting "Booking", choosing an available date, and specifying your vehicle issues.</p>
            </div>
            
            <div class="faq-item border border-outline-variant rounded-lg p-4 bg-surface-container-lowest transition-all">
                <h3 class="font-bold text-lg mb-2">How can I track the progress of my vehicle?</h3>
                <p class="text-on-surface-variant">Once you drop off your vehicle, you can use the "Cek Status" feature on our homepage by entering your license plate and phone number, or track it directly from your Portal Dashboard.</p>
            </div>
            
            <div class="faq-item border border-outline-variant rounded-lg p-4 bg-surface-container-lowest transition-all">
                <h3 class="font-bold text-lg mb-2">Are the spare parts original?</h3>
                <p class="text-on-surface-variant">Yes! We guarantee that all spare parts sold and installed at SIBENGKEL are 100% original and come with the official manufacturer warranty.</p>
            </div>
            
            <div id="no-results" class="hidden text-center py-8 text-on-surface-variant">
                <span class="material-symbols-outlined text-4xl mb-2 opacity-50">search_off</span>
                <p>No matching questions found.</p>
            </div>
        </div>
    </div>
    
    <div class="bg-primary-container text-on-primary-container p-lg rounded-xl text-center">
        <span class="material-symbols-outlined text-4xl mb-2">help_center</span>
        <h3 class="font-headline-sm text-headline-sm font-bold mb-2">Still need help?</h3>
        <p class="mb-4">Can\'t find the answer you\'re looking for? Our dedicated support team is ready to assist you.</p>
        <a href="/p/contact-us" class="inline-block bg-primary text-on-primary font-bold px-6 py-2 rounded-lg hover:opacity-90">
            Contact Support
        </a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("faq-search");
        const faqItems = document.querySelectorAll(".faq-item");
        const noResults = document.getElementById("no-results");

        if(searchInput) {
            searchInput.addEventListener("input", function(e) {
                const searchTerm = e.target.value.toLowerCase();
                let hasVisibleItem = false;

                faqItems.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        item.style.display = "block";
                        hasVisibleItem = true;
                    } else {
                        item.style.display = "none";
                    }
                });

                if (hasVisibleItem) {
                    noResults.classList.add("hidden");
                } else {
                    noResults.classList.remove("hidden");
                }
            });
        }
    });
</script>'
            ]
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
