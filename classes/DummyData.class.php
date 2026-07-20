<?php
// Frontend/backend seam — dummy data only. See docs/DATA_CONTRACT.md Section A.
// Every key here must match the contract exactly. Values are placeholders.
class DummyData
{
    // NOTE: no faqItems() here — Home's FAQs column uses real backend data
    // (Faq::getLimitFaqList + Company::getCompanyDetails), same as the rest
    // of the site. Only genuinely-missing article fields are stubbed below.

    public static function articleCards()
    {
        return [
            [
                'article_id' => 11040, 'title' => 'What is Paint Protection Film (PPF)?', 'slug' => 'everything-you-need-to-know',
                'category' => 'Services', 'date' => '2026-06-12',
                'excerpt' => 'PPF is a protective film that shields car paint from scratches, chips, stains, and minor damage.',
                'image' => 'https://picsum.photos/seed/ppf-car/800/500', 'url' => 'blog/id/11040', 'company_id' => 28587, 'company_name' => 'M8 Car Accessories',
                'company_url' => 'm8tint.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=M8&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'M8', 'tags' => ['Services', 'Specialist'],
            ],
            [
                'article_id' => 11070, 'title' => 'Choosing the Right Replacement LCD Screen', 'slug' => 'lcd-screen-faqs',
                'category' => 'Guides', 'date' => '2026-05-28',
                'excerpt' => 'A quick comparison of OLED, Incell, and LCD replacement panels and when each makes sense for a repair job.',
                'image' => 'https://picsum.photos/seed/lcd-screen/800/500', 'url' => 'blog/id/11070', 'company_id' => 19240, 'company_name' => 'Bemax Distribution',
                'company_url' => 'bemax.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=BX&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'BX', 'tags' => ['Distributor', 'Supplier'],
            ],
            [
                'article_id' => 11081, 'title' => 'When Can You Start Your Aligner Journey?', 'slug' => 'clear-aligner',
                'category' => 'Case Study', 'date' => '2026-05-09',
                'excerpt' => 'Aligner treatment can begin as early as age 8 for mild to moderate cases — here is how the timeline typically works.',
                'image' => 'https://picsum.photos/seed/dental-aligner/800/500', 'url' => 'blog/id/11081', 'company_id' => 20114, 'company_name' => 'EZ Dental Studio',
                'company_url' => 'ezdental.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=EZ&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'EZ', 'tags' => ['Dental Clinic'],
            ],
            [
                'article_id' => 11063, 'title' => 'What Actually Makes a Refurbished iPhone "Refurbished"', 'slug' => 'product-quality',
                'category' => 'Insights', 'date' => '2026-04-22',
                'excerpt' => 'A look at the inspection, testing, and restoration process that separates refurbished devices from simple used ones.',
                'image' => 'https://picsum.photos/seed/refurb-iphone/800/500', 'url' => 'blog/id/11063', 'company_id' => 21830, 'company_name' => 'Newlife Mobile Tech',
                'company_url' => 'newlifemobiletech.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=NL&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'NL', 'tags' => ['Second-Hand Phones Supplier'],
            ],
            [
                'article_id' => 11092, 'title' => 'Picking the Right Castor for Industrial Mobility', 'slug' => 'general-questions',
                'category' => 'Best Practices', 'date' => '2026-04-02',
                'excerpt' => 'From leveling castors to heavy-duty wheels, matching load and surface type keeps equipment moving safely.',
                'image' => 'https://picsum.photos/seed/castors/800/500', 'url' => 'blog/id/11092', 'company_id' => 22015, 'company_name' => 'KSW Castors & Wheels',
                'company_url' => 'kswcastor.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=KS&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'KS', 'tags' => ['Supplier', 'Supply'],
            ],
            [
                'article_id' => 11105, 'title' => 'What to Expect from a Security Door Installation', 'slug' => 'security-door-installation',
                'category' => 'Guides', 'date' => '2026-03-18',
                'excerpt' => 'Coverage, exclusions, and timelines for security door installs across West Malaysia.',
                'image' => 'https://picsum.photos/seed/security-door/800/500', 'url' => 'blog/id/11105', 'company_id' => 22340, 'company_name' => 'THC Metal Engineering',
                'company_url' => 'thcsecuritydoor.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=TH&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'TH', 'tags' => ['Manufacturer', 'Supply'],
            ],
            [
                'article_id' => 11118, 'title' => 'Writing FAQs That Actually Answer Questions', 'slug' => 'best-practices',
                'category' => 'Best Practices', 'date' => '2026-03-02',
                'excerpt' => 'A short guide on structuring answers so customers stop opening support tickets for things already covered.',
                'image' => 'https://picsum.photos/seed/faq-writing/800/500', 'url' => 'blog/id/11118', 'company_id' => 23110, 'company_name' => 'MAC Apparels',
                'company_url' => 'macdesign.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=MA&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'MA', 'tags' => ['Printing Services', 'Supplier'],
            ],
            [
                'article_id' => 11124, 'title' => 'The Difference Between FAQs and Knowledge Bases', 'slug' => 'production',
                'category' => 'Insights', 'date' => '2026-02-14',
                'excerpt' => 'FAQs answer what customers actually ask; knowledge bases document everything. Here is when to use each.',
                'image' => 'https://picsum.photos/seed/knowledge-base/800/500', 'url' => 'blog/id/11124', 'company_id' => 23890, 'company_name' => 'QingTing Industrial',
                'company_url' => 'qtblinds.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=QT&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'QT', 'tags' => ['Supplier', 'Manufacturer'],
            ],
            [
                'article_id' => 11150, 'title' => 'What to Do If Your Security Camera Feed Drops', 'slug' => 'troubleshooting',
                'category' => 'Guides', 'date' => '2026-06-20',
                'excerpt' => 'Common causes of CCTV feed dropouts and the quick checks to run before calling a technician.',
                'image' => 'https://picsum.photos/seed/security-camera/800/500', 'url' => 'blog/id/11150', 'company_id' => 24010, 'company_name' => 'Vantage CCTV Solutions',
                'company_url' => 'vantagecctv.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=VC&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'VC', 'tags' => ['Installation', 'Security'],
            ],
            [
                'article_id' => 11161, 'title' => 'Choosing a POS System for a Small Retail Shop', 'slug' => 'buying-guide',
                'category' => 'Guides', 'date' => '2026-06-08',
                'excerpt' => 'What actually matters when comparing point-of-sale systems: inventory sync, receipt printing, and offline mode.',
                'image' => 'https://picsum.photos/seed/pos-system/800/500', 'url' => 'blog/id/11161', 'company_id' => 24122, 'company_name' => 'RetailFlow POS',
                'company_url' => 'retailflow.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=RF&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'RF', 'tags' => ['Software', 'Supplier'],
            ],
            [
                'article_id' => 11172, 'title' => 'How Much Weight Can a Warehouse Racking Bay Hold', 'slug' => 'load-capacity',
                'category' => 'Best Practices', 'date' => '2026-05-30',
                'excerpt' => 'Load capacity depends on beam gauge, bay width, and floor condition — here is how installers calculate a safe limit.',
                'image' => 'https://picsum.photos/seed/warehouse-racking/800/500', 'url' => 'blog/id/11172', 'company_id' => 24233, 'company_name' => 'SteelSpan Racking',
                'company_url' => 'steelspan.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=SS&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'SS', 'tags' => ['Manufacturer', 'Supply'],
            ],
            [
                'article_id' => 11183, 'title' => 'Is Solar Worth It for a Terrace House in Malaysia', 'slug' => 'roi-explained',
                'category' => 'Case Study', 'date' => '2026-05-22',
                'excerpt' => 'A breakdown of typical payback periods for residential solar installs under current NEM rates.',
                'image' => 'https://picsum.photos/seed/solar-panel/800/500', 'url' => 'blog/id/11183', 'company_id' => 24344, 'company_name' => 'SunHarvest Energy',
                'company_url' => 'sunharvest.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=SH&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'SH', 'tags' => ['Installation', 'Renewable Energy'],
            ],
            [
                'article_id' => 11194, 'title' => 'Ceramic Coating vs Window Tint: Do You Need Both', 'slug' => 'comparison',
                'category' => 'Insights', 'date' => '2026-05-15',
                'excerpt' => 'They protect different parts of the car and solve different problems — here is when to get one, the other, or both.',
                'image' => 'https://picsum.photos/seed/car-tint/800/500', 'url' => 'blog/id/11194', 'company_id' => 24455, 'company_name' => 'ShieldPro Auto Tint',
                'company_url' => 'shieldproauto.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=SP&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'SP', 'tags' => ['Services', 'Specialist'],
            ],
            [
                'article_id' => 11205, 'title' => 'How Often Should a Commercial Office Be Deep Cleaned', 'slug' => 'cleaning-schedule',
                'category' => 'Best Practices', 'date' => '2026-05-04',
                'excerpt' => 'Foot traffic and floor type both change the right interval for a full deep clean, not just calendar months.',
                'image' => 'https://picsum.photos/seed/office-cleaning/800/500', 'url' => 'blog/id/11205', 'company_id' => 24566, 'company_name' => 'CrystalClean Services',
                'company_url' => 'crystalclean.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=CC&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'CC', 'tags' => ['Services', 'Supplier'],
            ],
            [
                'article_id' => 11216, 'title' => 'What File Formats Does a Printing Press Actually Need', 'slug' => 'file-prep',
                'category' => 'Guides', 'date' => '2026-04-28',
                'excerpt' => 'Print-ready PDFs, bleed margins, and color profiles that save a reprint before your job even starts.',
                'image' => 'https://picsum.photos/seed/printing-press/800/500', 'url' => 'blog/id/11216', 'company_id' => 24677, 'company_name' => 'InkWorks Printing',
                'company_url' => 'inkworks.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=IW&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'IW', 'tags' => ['Printing Services', 'Supplier'],
            ],
            [
                'article_id' => 11227, 'title' => 'Tracking a Delivery: What Each Fleet Status Actually Means', 'slug' => 'status-guide',
                'category' => 'Guides', 'date' => '2026-04-19',
                'excerpt' => 'From "dispatched" to "out for delivery" — what triggers each update in a logistics tracking system.',
                'image' => 'https://picsum.photos/seed/logistics-fleet/800/500', 'url' => 'blog/id/11227', 'company_id' => 24788, 'company_name' => 'SwiftHaul Logistics',
                'company_url' => 'swifthaul.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=SL&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'SL', 'tags' => ['Logistics', 'Supplier'],
            ],
            [
                'article_id' => 11238, 'title' => 'Why Is My Aircon Not Cold Even After Servicing', 'slug' => 'troubleshooting',
                'category' => 'Guides', 'date' => '2026-04-10',
                'excerpt' => 'A weak-cooling unit after a service call usually points to one of three things — here is how to check each.',
                'image' => 'https://picsum.photos/seed/aircon-service/800/500', 'url' => 'blog/id/11238', 'company_id' => 24899, 'company_name' => 'CoolBreeze Aircon',
                'company_url' => 'coolbreeze.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=CB&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'CB', 'tags' => ['Services', 'Repair'],
            ],
            [
                'article_id' => 11249, 'title' => 'Solid Wood vs Veneer: What Custom Furniture Buyers Should Know', 'slug' => 'material-guide',
                'category' => 'Insights', 'date' => '2026-04-02',
                'excerpt' => 'Veneer is not automatically lower quality — the substrate underneath matters more than the surface material.',
                'image' => 'https://picsum.photos/seed/furniture-custom/800/500', 'url' => 'blog/id/11249', 'company_id' => 25010, 'company_name' => 'Artisan Furniture Co',
                'company_url' => 'artisanfurniture.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=AF&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'AF', 'tags' => ['Manufacturer', 'Specialist'],
            ],
            [
                'article_id' => 11260, 'title' => 'LED Signage Lifespan: What Actually Shortens It', 'slug' => 'maintenance-tips',
                'category' => 'Best Practices', 'date' => '2026-03-25',
                'excerpt' => 'Heat, moisture ingress, and driver quality affect lifespan far more than the LED chips themselves.',
                'image' => 'https://picsum.photos/seed/signage-led/800/500', 'url' => 'blog/id/11260', 'company_id' => 25121, 'company_name' => 'BrightSign Displays',
                'company_url' => 'brightsign.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=BS&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'BS', 'tags' => ['Manufacturer', 'Installation'],
            ],
            [
                'article_id' => 11271, 'title' => 'Corrugated vs Rigid Boxes: Picking the Right Packaging', 'slug' => 'packaging-basics',
                'category' => 'Guides', 'date' => '2026-03-16',
                'excerpt' => 'Product weight and shipping distance decide which box type actually protects your goods without overpaying.',
                'image' => 'https://picsum.photos/seed/packaging-boxes/800/500', 'url' => 'blog/id/11271', 'company_id' => 25232, 'company_name' => 'PackRight Supplies',
                'company_url' => 'packright.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=PR&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'PR', 'tags' => ['Supplier', 'Manufacturer'],
            ],
            [
                'article_id' => 11282, 'title' => 'How Far Ahead Should You Book Event Catering', 'slug' => 'booking-timeline',
                'category' => 'Case Study', 'date' => '2026-03-09',
                'excerpt' => 'Guest count and menu customization both push the ideal booking window earlier than most people expect.',
                'image' => 'https://picsum.photos/seed/catering-service/800/500', 'url' => 'blog/id/11282', 'company_id' => 25343, 'company_name' => 'Golden Spoon Catering',
                'company_url' => 'goldenspoon.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=GS&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'GS', 'tags' => ['Services', 'Supplier'],
            ],
            [
                'article_id' => 11293, 'title' => 'Signs of a Termite Infestation Before It Gets Structural', 'slug' => 'early-signs',
                'category' => 'Guides', 'date' => '2026-02-26',
                'excerpt' => 'Mud tubes and hollow-sounding wood are late signs — here is what to check earlier during a routine inspection.',
                'image' => 'https://picsum.photos/seed/pest-control/800/500', 'url' => 'blog/id/11293', 'company_id' => 25454, 'company_name' => 'SafeGuard Pest Control',
                'company_url' => 'safeguardpest.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=SG&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'SG', 'tags' => ['Services', 'Specialist'],
            ],
            [
                'article_id' => 11304, 'title' => 'Renovation Permits: What Actually Needs Approval in Malaysia', 'slug' => 'permit-guide',
                'category' => 'Insights', 'date' => '2026-02-18',
                'excerpt' => 'Structural changes and extensions typically need local council approval; cosmetic work usually does not.',
                'image' => 'https://picsum.photos/seed/renovation-work/800/500', 'url' => 'blog/id/11304', 'company_id' => 25565, 'company_name' => 'BuildCraft Renovation',
                'company_url' => 'buildcraft.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=BC&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'BC', 'tags' => ['Services', 'Manufacturer'],
            ],
            [
                'article_id' => 11315, 'title' => 'Why Vending Machines Reject Coins That Look Fine', 'slug' => 'faq',
                'category' => 'Guides', 'date' => '2026-02-09',
                'excerpt' => 'Worn edges and magnetic composition changes are the most common reasons a coin validator rejects a valid coin.',
                'image' => 'https://picsum.photos/seed/vending-machine/800/500', 'url' => 'blog/id/11315', 'company_id' => 25676, 'company_name' => 'SnackHub Vending',
                'company_url' => 'snackhub.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=SH&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'SH', 'tags' => ['Supplier', 'Services'],
            ],
        ];
    }

    // The hero needs company/category/excerpt too now (full-image-with-scrim
    // design), which the old separate featured object didn't carry. Reusing
    // the first articleCard keeps one source of truth instead of two
    // slightly-different copies of the same fields.
    public static function featured()
    {
        $cards = self::articleCards();
        return $cards[0];
    }

    // Keyed by faq_id so different dummy IDs render visibly different content
    // (QA needs this to confirm detail pages actually vary per ID). Falls back
    // to the first entry (11040, PPF) for any ID not listed here — this keeps
    // real FAQ IDs (which aren't in this map at all) working exactly as before.
    public static function articleDetail($faq_id = null)
    {
        $details = self::articleDetails();
        if ($faq_id !== null && isset($details[$faq_id])) {
            return $details[$faq_id];
        }
        return $details[11040];
    }

    private static function articleDetails()
    {
        return [
            11040 => [
                'faq_id' => 11040,
                'category' => 'Everything You Need to Know',
                'question' => 'What is Paint Protection Film (PPF)?',
                'answer' => 'PPF is a protective film that shields car paint from scratches, chips, stains, and minor damage.',
                'tags' => ['Services', 'Specialist'],
                'body' => [
                    'Paint Protection Film has become the go-to solution for car owners looking to preserve their vehicle\'s finish without altering its appearance. Unlike a wax or sealant, PPF is a physical layer that absorbs impact from road debris, gravel chips, and minor abrasions before they ever reach the paint underneath.',
                    'Most installers apply the film to high-impact zones — the front bumper, hood, mirrors, and door edges — though full-body coverage is increasingly common for owners who want long-term protection across every panel. A quality installation is virtually invisible, with a self-healing top coat that shrugs off light swirl marks when exposed to heat.',
                    'Beyond the cosmetic benefit, PPF also helps protect resale value: a car that has spent years shielded from chips and scratches tends to retain a cleaner, more original-looking paint job than one left unprotected.',
                    'The material itself has come a long way since the early days of "clear bra" kits. Modern films are built from thermoplastic polyurethane (TPU), a flexible yet durable polymer that conforms tightly to complex curves and edges. This is what allows a skilled installer to wrap a full bumper or a curved mirror cap with no visible seams, bubbles, or lifting at the corners.',
                    'Self-healing is one of the most talked-about features, and it is not just marketing. The top layer is engineered so that light scratches and swirl marks disappear as the film is warmed — whether by the sun, warm water, or a heat gun. Deeper cuts that reach past the top coat will not self-heal, but the day-to-day micro-scratches that dull a paint job over time simply vanish.',
                    'Installation quality matters far more than most buyers realize. Two shops using the exact same film can deliver very different results: edges tucked cleanly under panels versus edges left exposed to peel, or a dust-free bay versus contamination trapped under the film forever. This is why it is worth asking to see a shop\'s previous work and confirming whether they wrap edges or trim them at the panel line.',
                    'Maintenance is refreshingly simple. A PPF-covered car can be washed exactly like any other vehicle, though it is best to wait a week after installation before the first wash so the film can fully cure. Avoid aggressive automatic car washes with stiff brushes, and steer clear of harsh solvents; a standard pH-neutral car shampoo is all the film needs to stay clear for years.',
                    'Warranty terms vary widely between manufacturers, typically ranging from five to ten years against yellowing, cracking, and delamination. It is important to read what the warranty actually covers — some exclude edges, some require professional installation to remain valid, and almost none cover damage from improper cleaning. A reputable installer will register the warranty on your behalf and walk you through the exclusions.',
                    'So is PPF worth it? For a daily driver that racks up highway miles, a leased vehicle that must be returned in pristine condition, or a prized weekend car, the answer is usually yes. The upfront cost is real, but so is the cost of a full respray after years of accumulated chips — and PPF buys back both the paint and the peace of mind.',
                ],
                'splash_image' => 'https://picsum.photos/seed/article-splash/1200/500',
                'company' => [
                    'company_id' => 28587,
                    'name' => 'M 8 CAR ACCESSORIES AND TINTED (M) SDN BHD',
                    'emails' => ['info@m8car.com.my'],
                    'address' => '15, Jalan Keruing 1, Taman Rinting, 81750 Masai, Johor, Malaysia.',
                    'website' => 'https://www.m8tint.com.my',
                    'map_url' => 'https://www.google.com/maps/search/?api=1&query=1.49,103.85',
                    'logo' => 'https://ui-avatars.com/api/?name=M8&background=1b4297&color=fff&size=128&bold=true',
                    'description' => 'We provided high-quality & affordable tinted window films, professional workmanship and excellent customer service won us many customers and made us one of the popular and leading tinted film companies in Johor Bahru, Kuala Lumpur & Selangor.',
                    'tags' => ['Services', 'Specialist'],
                ],
                'related_faqs' => [
                    ['faq_id' => 11041, 'question' => 'How long does PPF installation take?', 'url' => 'id/11041'],
                    ['faq_id' => 11042, 'question' => 'Does PPF affect the factory paint warranty?', 'url' => 'id/11042'],
                    ['faq_id' => 11043, 'question' => 'How do I maintain a PPF-coated vehicle?', 'url' => 'id/11043'],
                    ['faq_id' => 11044, 'question' => 'What is the difference between PPF and ceramic coating?', 'url' => 'id/11044'],
                ],
            ],
            11070 => [
                'faq_id' => 11070,
                'category' => 'Guides',
                'question' => 'Choosing the Right Replacement LCD Screen',
                'answer' => 'A quick comparison of OLED, Incell, and LCD replacement panels and when each makes sense for a repair job.',
                'tags' => ['Distributor', 'Supplier'],
                'body' => [
                    'Not every replacement screen is built the same, and the difference shows up fast once a repaired phone leaves the shop. The three panel types most repair shops choose between — OEM-grade OLED, Incell LCD, and standard LCD — trade off cost, color accuracy, and touch responsiveness in different ways.',
                    'OLED panels reproduce true blacks and the widest color range, and are the closest match to what came out of the factory. They carry the highest cost per unit, which usually only makes sense for flagship devices or customers who specifically ask for original-spec quality.',
                    'Incell LCD sits in the middle: the touch sensor is built into the LCD layer itself rather than laminated on top, giving a thinner panel with decent touch response at a lower cost than OLED. It is the most common choice for mid-range repair jobs where the customer wants good quality without flagship pricing.',
                    'Standard LCD panels are the most affordable and the most durable against pressure damage, but color accuracy and viewing angles are noticeably weaker — blacks look grey rather than true black, and brightness can be uneven at the edges. These are usually the right call for budget repairs or older device models.',
                    'Touch response is worth testing before installation, not after. A panel with a sluggish digitizer will feel fine sitting on a bench but frustrate a customer within days of daily use — swipe a few gestures across the full surface, including the very edges, before closing up the housing.',
                    'Sourcing matters as much as panel type. The same "OLED" label can come from wildly different factories with very different defect rates; a reliable distributor relationship that stands behind DOA replacements is often worth more than chasing the lowest unit price.',
                ],
                'splash_image' => 'https://picsum.photos/seed/lcd-screen/1200/500',
                'company' => [
                    'company_id' => 19240,
                    'name' => 'BEMAX DISTRIBUTION SDN BHD',
                    'emails' => ['sales@bemax.com.my'],
                    'address' => '22, Jalan Industri 3, Taman Perindustrian Cheras, 43200 Cheras, Selangor, Malaysia.',
                    'website' => 'https://www.bemax.com.my',
                    'map_url' => 'https://www.google.com/maps/search/?api=1&query=3.03,101.77',
                    'logo' => 'https://ui-avatars.com/api/?name=BX&background=1b4297&color=fff&size=128&bold=true',
                    'description' => 'Bemax Distribution supplies replacement mobile screens, batteries, and repair parts to workshops across the Klang Valley, with same-day delivery and DOA replacement on all panel stock.',
                    'tags' => ['Distributor', 'Supplier'],
                ],
                'related_faqs' => [
                    ['faq_id' => 11071, 'question' => 'What is the warranty on replacement screens?', 'url' => 'id/11071'],
                    ['faq_id' => 11072, 'question' => 'Do you supply battery replacements too?', 'url' => 'id/11072'],
                    ['faq_id' => 11073, 'question' => 'How fast is delivery within Klang Valley?', 'url' => 'id/11073'],
                    ['faq_id' => 11074, 'question' => 'Can I return a screen if it is faulty on arrival?', 'url' => 'id/11074'],
                ],
            ],
            11081 => [
                'faq_id' => 11081,
                'category' => 'Case Study',
                'question' => 'When Can You Start Your Aligner Journey?',
                'answer' => 'Aligner treatment can begin as early as age 8 for mild to moderate cases — here is how the timeline typically works.',
                'tags' => ['Dental Clinic'],
                'body' => [
                    'Clear aligner treatment is often assumed to be an adult-only option, but early intervention for children as young as 8 is increasingly common for specific bite issues — particularly crowding and early crossbites that are easier to correct before jaw growth is complete.',
                    'The first step is always a full assessment: photographs, X-rays, and a 3D scan of the bite. This is what determines whether a case is a good candidate for aligners at all, or whether traditional braces or a two-phase approach would serve the patient better.',
                    'For teens and adults, the biggest factor in timeline is compliance — aligners only work if they are worn 20-22 hours a day. Cases with strong compliance can finish noticeably faster than the initial estimate, while inconsistent wear stretches treatment out and sometimes requires additional refinement aligners.',
                    'A typical mild-to-moderate case runs 6 to 12 months; complex cases involving significant crowding or bite correction can run 18 months or longer. Your clinic will usually give a realistic range after the initial scan rather than a single fixed number.',
                ],
                'splash_image' => 'https://picsum.photos/seed/dental-aligner/1200/500',
                'company' => [
                    'company_id' => 20114,
                    'name' => 'EZ DENTAL STUDIO SDN BHD',
                    'emails' => ['hello@ezdental.com.my'],
                    'address' => '8, Jalan Setia Tropika 1/12, Taman Setia Tropika, 81200 Johor Bahru, Johor, Malaysia.',
                    'website' => 'https://www.ezdental.com.my',
                    'map_url' => 'https://www.google.com/maps/search/?api=1&query=1.56,103.73',
                    'logo' => 'https://ui-avatars.com/api/?name=EZ&background=1b4297&color=fff&size=128&bold=true',
                    'description' => 'EZ Dental Studio provides general and cosmetic dentistry including clear aligner treatment, with in-house 3D scanning for a same-visit treatment plan.',
                    'tags' => ['Dental Clinic'],
                ],
                'related_faqs' => [
                    ['faq_id' => 11082, 'question' => 'How much does clear aligner treatment cost?', 'url' => 'id/11082'],
                    ['faq_id' => 11083, 'question' => 'Do aligners hurt more than braces?', 'url' => 'id/11083'],
                    ['faq_id' => 11084, 'question' => 'What happens if I lose an aligner tray?', 'url' => 'id/11084'],
                    ['faq_id' => 11085, 'question' => 'Do I need a retainer after treatment ends?', 'url' => 'id/11085'],
                ],
            ],
            11205 => [
                'faq_id' => 11205,
                'category' => 'Best Practices',
                'question' => 'How Often Should a Commercial Office Be Deep Cleaned',
                'answer' => 'Foot traffic and floor type both change the right interval for a full deep clean, not just calendar months.',
                'tags' => ['Services', 'Supplier'],
                'body' => [
                    'A fixed monthly or quarterly schedule is the easiest way to plan a cleaning contract, but it is not actually the right way to decide when a deep clean is needed. Foot traffic is the biggest driver: a lobby or shared corridor sees dramatically more soil load per week than a private back office, even in the same building.',
                    'Floor type changes the math too. Carpet tiles trap fine dust and allergens that daily vacuuming cannot fully remove, and typically need a hot-water extraction deep clean every 3 to 6 months depending on traffic. Hard floors (vinyl, tile) can often stretch to 6-9 months between deep scrubs if daily mopping is consistent.',
                    'High-touch surfaces — door handles, lift buttons, shared kitchen counters — are a separate concern from floor cleaning entirely, and should be on a daily or twice-daily wipe-down schedule regardless of the deep-clean interval, especially in shared office buildings.',
                    'Seasonal factors matter in Malaysia specifically: haze periods and the monsoon season both increase how much dust and mud gets tracked in, and many facilities managers shift to a shorter interval for those months rather than keeping a flat year-round schedule.',
                    'The most reliable approach is an initial assessment visit rather than guessing from a generic rule of thumb — a facilities team can walk the space, check traffic patterns, and propose an interval that matches the actual building rather than an industry average.',
                ],
                'splash_image' => 'https://picsum.photos/seed/office-cleaning/1200/500',
                'company' => [
                    'company_id' => 24566,
                    'name' => 'CRYSTALCLEAN SERVICES SDN BHD',
                    'emails' => ['enquiry@crystalclean.com.my'],
                    'address' => '17-1, Jalan PJU 1A/41B, Ara Damansara, 47301 Petaling Jaya, Selangor, Malaysia.',
                    'website' => 'https://www.crystalclean.com.my',
                    'map_url' => 'https://www.google.com/maps/search/?api=1&query=3.11,101.58',
                    'logo' => 'https://ui-avatars.com/api/?name=CC&background=1b4297&color=fff&size=128&bold=true',
                    'description' => 'CrystalClean Services provides commercial office cleaning, carpet deep-cleaning, and high-touch sanitation contracts across the Klang Valley.',
                    'tags' => ['Services', 'Supplier'],
                ],
                'related_faqs' => [
                    ['faq_id' => 11206, 'question' => 'Do you clean outside of office hours?', 'url' => 'id/11206'],
                    ['faq_id' => 11207, 'question' => 'What is included in a standard cleaning contract?', 'url' => 'id/11207'],
                    ['faq_id' => 11208, 'question' => 'Can you handle a one-off deep clean without a contract?', 'url' => 'id/11208'],
                    ['faq_id' => 11209, 'question' => 'Are your cleaning products safe for offices with pets?', 'url' => 'id/11209'],
                ],
            ],
        ];
    }
}
?>
