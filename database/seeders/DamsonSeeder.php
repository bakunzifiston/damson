<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\Guide;
use App\Models\LibraryResource;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class DamsonSeeder extends Seeder
{
    public function run(): void
    {
        BlogPost::query()->updateOrCreate(
            ['slug' => 'five-ways-to-reduce-contamination'],
            [
                'title' => 'Five ways to reduce contamination in warm climates',
                'excerpt' => 'Practical hygiene habits that pay off in the fruiting room.',
                'body' => "## Start clean\n\n- Filter intake air and keep positive pressure where possible.\n- Stage tools in a **dedicated wash** area.\n\n## Monitor, don't guess\n\nPair visual checks with DMMS alerts so you catch RH spikes overnight.",
                'published_at' => now()->subDays(5),
                'is_published' => true,
            ]
        );

        BlogPost::query()->updateOrCreate(
            ['slug' => 'spawn-viability-windows'],
            [
                'title' => 'Understanding spawn viability windows',
                'excerpt' => 'How we label generations and what it means for your inoculation schedule.',
                'body' => "Always note the batch date on arrival. Plan inoculation inside the window printed on the label — viability drops faster when cold chain breaks.\n\nAsk our lab team if you are scaling into a new species.",
                'published_at' => now()->subDays(12),
                'is_published' => true,
            ]
        );

        Guide::query()->updateOrCreate(
            ['slug' => 'first-tube-grow'],
            [
                'title' => 'Your first mushroom tube grow (beginner)',
                'difficulty' => 'beginner',
                'excerpt' => 'From receipt to pinning — a concise checklist.',
                'body' => "### 1. Receiving\nInspect bags for punctures. Log batch codes.\n\n### 2. Incubation\nHold target temperature per species sheet. Avoid direct sun.\n\n### 3. Fruiting\nIntroduce fresh air and light gradually. Watch DMMS humidity traces.",
                'sort_order' => 1,
            ]
        );

        Guide::query()->updateOrCreate(
            ['slug' => 'scaling-dmms'],
            [
                'title' => 'Scaling DMMS across multiple rooms',
                'difficulty' => 'advanced',
                'excerpt' => 'Zones, naming conventions, and alert fatigue.',
                'body' => "Name zones after **building + room + rack** so SMS alerts are instantly actionable.\n\nStagger alert thresholds between similar rooms to detect HVAC drift early.",
                'sort_order' => 2,
            ]
        );

        $faqs = [
            ['category' => 'Spawn', 'question' => 'How should spawn be stored after delivery?', 'answer' => 'Refrigerate immediately at the temperature range on your batch sheet. Avoid freeze–thaw cycles.', 'sort_order' => 1],
            ['category' => 'Spawn', 'question' => 'Can I mix species in one fruiting room?', 'answer' => 'Only if their temperature and RH targets overlap. Otherwise use partitions or separate air handlers.', 'sort_order' => 2],
            ['category' => 'DMMS', 'question' => 'Does DMMS work offline?', 'answer' => 'Gateways buffer readings and sync when connectivity returns. Configure alert routing for SMS for critical breaches.', 'sort_order' => 3],
            ['category' => 'Products', 'question' => 'Do you ship internationally?', 'answer' => 'Contact sales with your region — spawn shipments depend on quarantine rules and viable transit times.', 'sort_order' => 4],
        ];
        foreach ($faqs as $row) {
            Faq::query()->updateOrCreate(
                ['question' => $row['question']],
                $row
            );
        }

        LibraryResource::query()->updateOrCreate(
            ['title' => 'DMMS sensor placement guide (PDF placeholder)'],
            [
                'category' => 'DMMS',
                'description' => 'Height, spacing, and calibration checklist.',
                'resource_type' => 'pdf',
                'external_url' => 'https://example.com/dmms-sensor-placement',
            ]
        );
        LibraryResource::query()->updateOrCreate(
            ['title' => 'Substrate moisture targets — quick reference'],
            [
                'category' => 'Farming methods',
                'description' => 'One-page infographic for common species.',
                'resource_type' => 'infographic',
                'external_url' => 'https://example.com/moisture-reference',
            ]
        );
        LibraryResource::query()->updateOrCreate(
            ['title' => 'Webinar: Yield stability in variable seasons'],
            [
                'category' => 'Industry',
                'description' => 'Recorded session with Q&A.',
                'resource_type' => 'video',
                'external_url' => 'https://example.com/webinar-yield',
            ]
        );

        Testimonial::query()->updateOrCreate(
            ['name' => 'Amaka O.', 'headline' => 'DMMS paid for itself in one season'],
            [
                'location' => 'Southwest grower cooperative',
                'quote' => 'We caught a humidity fault three days before pinning would have collapsed. The tubes and spawn quality match what we were promised — finally a supplier that understands our climate.',
                'is_featured' => true,
                'sort_order' => 1,
            ]
        );
        Testimonial::query()->updateOrCreate(
            ['name' => 'Jonas M.', 'headline' => 'Cleaner runs, less waste'],
            [
                'location' => 'Mid-size indoor farm',
                'quote' => 'Switching spawn batches to DAMSON cut our contamination events roughly in half. Their team helped tune DMMS thresholds for our hybrid rooms.',
                'is_featured' => true,
                'sort_order' => 2,
            ]
        );
        Testimonial::query()->updateOrCreate(
            ['name' => 'Elena R.', 'headline' => 'Support that scales with you'],
            [
                'location' => 'Startup mushroom brand',
                'quote' => 'From ten tubes to five hundred, the guidance stayed practical — no jargon, just SOPs we could hand to new staff.',
                'is_featured' => true,
                'sort_order' => 3,
            ]
        );

        $products = [
            [
                'name' => 'Premium oyster tubes (standard)',
                'slug' => 'premium-oyster-tubes-standard',
                'sku' => 'TUB-OYS-STD',
                'category' => 'tubes',
                'unit' => 'piece',
                'cost_price' => 2.10,
                'description' => "High-gas-exchange oyster **tubes** optimized for tropical and temperate houses. Includes printed moisture target card.\n\nTypical use: 1–1.2 kg wet substrate equivalent — confirm with your species sheet.",
                'price' => 4.50,
                'stock' => 500,
            ],
            [
                'name' => 'Shiitake sawdust spawn (2.5 kg)',
                'slug' => 'shiitake-spawn-2-5kg',
                'sku' => 'SPN-SHI-25',
                'category' => 'spawn',
                'unit' => 'kg',
                'cost_price' => 14.00,
                'description' => 'Second-generation sawdust spawn, lab-tested for vigor. Ship cold; use within the viability window on the label.',
                'price' => 28.00,
                'stock' => 120,
            ],
            [
                'name' => 'DMMS starter kit (3 sensors + gateway)',
                'slug' => 'dmms-starter-kit',
                'sku' => 'DMMS-START',
                'category' => 'dmms',
                'unit' => 'unit',
                'cost_price' => 520.00,
                'description' => "Everything to monitor **one fruiting room**: three combined temp/RH nodes, one gateway, and twelve months of cloud access.\n\nProfessional installation available in select regions.",
                'price' => 890.00,
                'stock' => 35,
            ],
        ];
        foreach ($products as $p) {
            Product::query()->updateOrCreate(
                ['slug' => $p['slug']],
                array_merge($p, ['is_active' => true])
            );
        }
    }
}
