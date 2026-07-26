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

<h2 class="font-headline-md text-headline-md text-on-background mt-8 mb-3 font-bold">2. The Data We Collect About You</h2>
<p class="leading-relaxed mb-4">We may collect, use, store and transfer different kinds of personal data about you which we have grouped together into several categories. Specifically, we collect <strong>Identity Data</strong> (which includes your first name, last name, username or similar identifier), <strong>Contact Data</strong> (such as your billing address, delivery address, email address and telephone numbers), <strong>Vehicle Data</strong> (including the license plate, make, model, and year of the vehicle you register for services), and <strong>Transaction Data</strong> (which comprises details about payments to and from you as well as other details of products and services you have purchased from us).</p>

<h2 class="font-headline-md text-headline-md text-on-background mt-8 mb-3 font-bold">3. How We Use Your Personal Data</h2>
<p class="leading-relaxed mb-4">We will only use your personal data when the law allows us to do so. Most commonly, we will use your personal data in three main circumstances: first, where we need to perform the contract we are about to enter into or have entered into with you, such as providing vehicle maintenance and repair services; second, where it is necessary for our legitimate business interests (or those of a third party) and your interests and fundamental rights do not override those interests; and third, where we need to comply with a regulatory or legal obligation.</p>'
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
                'content' => '<div class="space-y-md text-on-surface-variant font-body-md text-body-md">
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
</div>'
            ],
            [
                'slug' => 'support',
                'title' => 'Help & Support',
                'content' => '<div class="space-y-8">
    <div class="relative max-w-2xl mx-auto my-8 mb-12">
        <span class="material-symbols-outlined absolute left-4 top-3.5 text-on-surface-variant">search</span>
        <input type="text" id="faq-search" class="w-full pl-12 pr-4 py-3.5 rounded-full border border-outline-variant focus:border-primary shadow-sm bg-transparent text-on-background" placeholder="Search for help (e.g., How to book a service?)">
    </div>

    <div class="mb-12">
        <h2 class="font-headline-md text-2xl text-on-background font-bold mb-6">Frequently Asked Questions</h2>
        <div class="space-y-4" id="faq-list">
            <div class="faq-item border border-outline-variant rounded-xl overflow-hidden bg-surface-container-lowest transition-all" x-data="{ open: false }">
                <button @click="open = !open" class="w-full text-left p-5 font-bold text-lg flex justify-between items-center hover:bg-surface-container-low/50 transition-colors text-on-background">
                    <span>How do I book a service appointment?</span>
                    <span class="material-symbols-outlined transition-transform duration-300" :class="open ? \'rotate-180\' : \'\'">expand_more</span>
                </button>
                <div x-show="open" x-transition class="p-5 pt-0 text-on-surface-variant border-t border-outline-variant/10 leading-relaxed">
                    You can easily book a service by logging into your Customer Portal, selecting "Booking", choosing an available date, and specifying your vehicle issues.
                </div>
            </div>
            
            <div class="faq-item border border-outline-variant rounded-xl overflow-hidden bg-surface-container-lowest transition-all" x-data="{ open: false }">
                <button @click="open = !open" class="w-full text-left p-5 font-bold text-lg flex justify-between items-center hover:bg-surface-container-low/50 transition-colors text-on-background">
                    <span>How can I track the progress of my vehicle?</span>
                    <span class="material-symbols-outlined transition-transform duration-300" :class="open ? \'rotate-180\' : \'\'">expand_more</span>
                </button>
                <div x-show="open" x-transition class="p-5 pt-0 text-on-surface-variant border-t border-outline-variant/10 leading-relaxed">
                    Once you drop off your vehicle, you can use the "Cek Status" feature on our homepage by entering your license plate and phone number, or track it directly from your Portal Dashboard.
                </div>
            </div>
            
            <div class="faq-item border border-outline-variant rounded-xl overflow-hidden bg-surface-container-lowest transition-all" x-data="{ open: false }">
                <button @click="open = !open" class="w-full text-left p-5 font-bold text-lg flex justify-between items-center hover:bg-surface-container-low/50 transition-colors text-on-background">
                    <span>Are the spare parts original?</span>
                    <span class="material-symbols-outlined transition-transform duration-300" :class="open ? \'rotate-180\' : \'\'">expand_more</span>
                </button>
                <div x-show="open" x-transition class="p-5 pt-0 text-on-surface-variant border-t border-outline-variant/10 leading-relaxed">
                    Yes! We guarantee that all spare parts sold and installed at SIBENGKEL are 100% original and come with the official manufacturer warranty.
                </div>
            </div>
            
            <div id="no-results" class="hidden text-center py-8 text-on-surface-variant">
                <span class="material-symbols-outlined text-4xl mb-2 opacity-50">search_off</span>
                <p>No matching questions found.</p>
            </div>
        </div>
    </div>
    
    <div class="bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] text-on-surface dark:text-[#EDEDEC] p-lg rounded-xl text-center">
        <span class="material-symbols-outlined text-4xl mb-2 text-primary dark:text-[#EDEDEC]">help_center</span>
        <h3 class="font-headline-sm text-headline-sm font-bold mb-2 text-on-surface dark:text-[#EDEDEC]">Still need help?</h3>
        <p class="mb-4 text-on-surface-variant dark:text-gray-400">Can\'t find the answer you\'re looking for? Our dedicated support team is ready to assist you.</p>
        <a href="/p/contact-us" class="inline-block bg-primary dark:bg-white text-on-primary dark:text-black font-bold px-6 py-2 rounded-lg hover:opacity-90">
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
