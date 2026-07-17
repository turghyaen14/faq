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
                'image' => 'https://picsum.photos/seed/ppf-car/800/500', 'url' => 'id/11040', 'company_id' => 28587, 'company_name' => 'M8 Car Accessories',
                'company_url' => 'm8tint.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=M8&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'M8', 'tags' => ['Services', 'Specialist'],
            ],
            [
                'article_id' => 11070, 'title' => 'Choosing the Right Replacement LCD Screen', 'slug' => 'lcd-screen-faqs',
                'category' => 'Guides', 'date' => '2026-05-28',
                'excerpt' => 'A quick comparison of OLED, Incell, and LCD replacement panels and when each makes sense for a repair job.',
                'image' => 'https://picsum.photos/seed/lcd-screen/800/500', 'url' => 'id/11070', 'company_id' => 19240, 'company_name' => 'Bemax Distribution',
                'company_url' => 'bemax.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=BX&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'BX', 'tags' => ['Distributor', 'Supplier'],
            ],
            [
                'article_id' => 11081, 'title' => 'When Can You Start Your Aligner Journey?', 'slug' => 'clear-aligner',
                'category' => 'Case Study', 'date' => '2026-05-09',
                'excerpt' => 'Aligner treatment can begin as early as age 8 for mild to moderate cases — here is how the timeline typically works.',
                'image' => 'https://picsum.photos/seed/dental-aligner/800/500', 'url' => 'id/11081', 'company_id' => 20114, 'company_name' => 'EZ Dental Studio',
                'company_url' => 'ezdental.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=EZ&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'EZ', 'tags' => ['Dental Clinic'],
            ],
            [
                'article_id' => 11063, 'title' => 'What Actually Makes a Refurbished iPhone "Refurbished"', 'slug' => 'product-quality',
                'category' => 'Insights', 'date' => '2026-04-22',
                'excerpt' => 'A look at the inspection, testing, and restoration process that separates refurbished devices from simple used ones.',
                'image' => 'https://picsum.photos/seed/refurb-iphone/800/500', 'url' => 'id/11063', 'company_id' => 21830, 'company_name' => 'Newlife Mobile Tech',
                'company_url' => 'newlifemobiletech.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=NL&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'NL', 'tags' => ['Second-Hand Phones Supplier'],
            ],
            [
                'article_id' => 11092, 'title' => 'Picking the Right Castor for Industrial Mobility', 'slug' => 'general-questions',
                'category' => 'Best Practices', 'date' => '2026-04-02',
                'excerpt' => 'From leveling castors to heavy-duty wheels, matching load and surface type keeps equipment moving safely.',
                'image' => 'https://picsum.photos/seed/castors/800/500', 'url' => 'id/11092', 'company_id' => 22015, 'company_name' => 'KSW Castors & Wheels',
                'company_url' => 'kswcastor.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=KS&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'KS', 'tags' => ['Supplier', 'Supply'],
            ],
            [
                'article_id' => 11105, 'title' => 'What to Expect from a Security Door Installation', 'slug' => 'security-door-installation',
                'category' => 'Guides', 'date' => '2026-03-18',
                'excerpt' => 'Coverage, exclusions, and timelines for security door installs across West Malaysia.',
                'image' => 'https://picsum.photos/seed/security-door/800/500', 'url' => 'id/11105', 'company_id' => 22340, 'company_name' => 'THC Metal Engineering',
                'company_url' => 'thcsecuritydoor.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=TH&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'TH', 'tags' => ['Manufacturer', 'Supply'],
            ],
            [
                'article_id' => 11118, 'title' => 'Writing FAQs That Actually Answer Questions', 'slug' => 'best-practices',
                'category' => 'Best Practices', 'date' => '2026-03-02',
                'excerpt' => 'A short guide on structuring answers so customers stop opening support tickets for things already covered.',
                'image' => 'https://picsum.photos/seed/faq-writing/800/500', 'url' => 'id/11118', 'company_id' => 23110, 'company_name' => 'MAC Apparels',
                'company_url' => 'macdesign.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=MA&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'MA', 'tags' => ['Printing Services', 'Supplier'],
            ],
            [
                'article_id' => 11124, 'title' => 'The Difference Between FAQs and Knowledge Bases', 'slug' => 'production',
                'category' => 'Insights', 'date' => '2026-02-14',
                'excerpt' => 'FAQs answer what customers actually ask; knowledge bases document everything. Here is when to use each.',
                'image' => 'https://picsum.photos/seed/knowledge-base/800/500', 'url' => 'id/11124', 'company_id' => 23890, 'company_name' => 'QingTing Industrial',
                'company_url' => 'qtblinds.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=QT&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'QT', 'tags' => ['Supplier', 'Manufacturer'],
            ],
            [
                'article_id' => 11150, 'title' => 'What to Do If Your Security Camera Feed Drops', 'slug' => 'troubleshooting',
                'category' => 'Guides', 'date' => '2026-06-20',
                'excerpt' => 'Common causes of CCTV feed dropouts and the quick checks to run before calling a technician.',
                'image' => 'https://picsum.photos/seed/security-camera/800/500', 'url' => 'id/11150', 'company_id' => 24010, 'company_name' => 'Vantage CCTV Solutions',
                'company_url' => 'vantagecctv.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=VC&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'VC', 'tags' => ['Installation', 'Security'],
            ],
            [
                'article_id' => 11161, 'title' => 'Choosing a POS System for a Small Retail Shop', 'slug' => 'buying-guide',
                'category' => 'Guides', 'date' => '2026-06-08',
                'excerpt' => 'What actually matters when comparing point-of-sale systems: inventory sync, receipt printing, and offline mode.',
                'image' => 'https://picsum.photos/seed/pos-system/800/500', 'url' => 'id/11161', 'company_id' => 24122, 'company_name' => 'RetailFlow POS',
                'company_url' => 'retailflow.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=RF&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'RF', 'tags' => ['Software', 'Supplier'],
            ],
            [
                'article_id' => 11172, 'title' => 'How Much Weight Can a Warehouse Racking Bay Hold', 'slug' => 'load-capacity',
                'category' => 'Best Practices', 'date' => '2026-05-30',
                'excerpt' => 'Load capacity depends on beam gauge, bay width, and floor condition — here is how installers calculate a safe limit.',
                'image' => 'https://picsum.photos/seed/warehouse-racking/800/500', 'url' => 'id/11172', 'company_id' => 24233, 'company_name' => 'SteelSpan Racking',
                'company_url' => 'steelspan.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=SS&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'SS', 'tags' => ['Manufacturer', 'Supply'],
            ],
            [
                'article_id' => 11183, 'title' => 'Is Solar Worth It for a Terrace House in Malaysia', 'slug' => 'roi-explained',
                'category' => 'Case Study', 'date' => '2026-05-22',
                'excerpt' => 'A breakdown of typical payback periods for residential solar installs under current NEM rates.',
                'image' => 'https://picsum.photos/seed/solar-panel/800/500', 'url' => 'id/11183', 'company_id' => 24344, 'company_name' => 'SunHarvest Energy',
                'company_url' => 'sunharvest.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=SH&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'SH', 'tags' => ['Installation', 'Renewable Energy'],
            ],
            [
                'article_id' => 11194, 'title' => 'Ceramic Coating vs Window Tint: Do You Need Both', 'slug' => 'comparison',
                'category' => 'Insights', 'date' => '2026-05-15',
                'excerpt' => 'They protect different parts of the car and solve different problems — here is when to get one, the other, or both.',
                'image' => 'https://picsum.photos/seed/car-tint/800/500', 'url' => 'id/11194', 'company_id' => 24455, 'company_name' => 'ShieldPro Auto Tint',
                'company_url' => 'shieldproauto.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=SP&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'SP', 'tags' => ['Services', 'Specialist'],
            ],
            [
                'article_id' => 11205, 'title' => 'How Often Should a Commercial Office Be Deep Cleaned', 'slug' => 'cleaning-schedule',
                'category' => 'Best Practices', 'date' => '2026-05-04',
                'excerpt' => 'Foot traffic and floor type both change the right interval for a full deep clean, not just calendar months.',
                'image' => 'https://picsum.photos/seed/office-cleaning/800/500', 'url' => 'id/11205', 'company_id' => 24566, 'company_name' => 'CrystalClean Services',
                'company_url' => 'crystalclean.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=CC&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'CC', 'tags' => ['Services', 'Supplier'],
            ],
            [
                'article_id' => 11216, 'title' => 'What File Formats Does a Printing Press Actually Need', 'slug' => 'file-prep',
                'category' => 'Guides', 'date' => '2026-04-28',
                'excerpt' => 'Print-ready PDFs, bleed margins, and color profiles that save a reprint before your job even starts.',
                'image' => 'https://picsum.photos/seed/printing-press/800/500', 'url' => 'id/11216', 'company_id' => 24677, 'company_name' => 'InkWorks Printing',
                'company_url' => 'inkworks.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=IW&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'IW', 'tags' => ['Printing Services', 'Supplier'],
            ],
            [
                'article_id' => 11227, 'title' => 'Tracking a Delivery: What Each Fleet Status Actually Means', 'slug' => 'status-guide',
                'category' => 'Guides', 'date' => '2026-04-19',
                'excerpt' => 'From "dispatched" to "out for delivery" — what triggers each update in a logistics tracking system.',
                'image' => 'https://picsum.photos/seed/logistics-fleet/800/500', 'url' => 'id/11227', 'company_id' => 24788, 'company_name' => 'SwiftHaul Logistics',
                'company_url' => 'swifthaul.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=SL&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'SL', 'tags' => ['Logistics', 'Supplier'],
            ],
            [
                'article_id' => 11238, 'title' => 'Why Is My Aircon Not Cold Even After Servicing', 'slug' => 'troubleshooting',
                'category' => 'Guides', 'date' => '2026-04-10',
                'excerpt' => 'A weak-cooling unit after a service call usually points to one of three things — here is how to check each.',
                'image' => 'https://picsum.photos/seed/aircon-service/800/500', 'url' => 'id/11238', 'company_id' => 24899, 'company_name' => 'CoolBreeze Aircon',
                'company_url' => 'coolbreeze.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=CB&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'CB', 'tags' => ['Services', 'Repair'],
            ],
            [
                'article_id' => 11249, 'title' => 'Solid Wood vs Veneer: What Custom Furniture Buyers Should Know', 'slug' => 'material-guide',
                'category' => 'Insights', 'date' => '2026-04-02',
                'excerpt' => 'Veneer is not automatically lower quality — the substrate underneath matters more than the surface material.',
                'image' => 'https://picsum.photos/seed/furniture-custom/800/500', 'url' => 'id/11249', 'company_id' => 25010, 'company_name' => 'Artisan Furniture Co',
                'company_url' => 'artisanfurniture.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=AF&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'AF', 'tags' => ['Manufacturer', 'Specialist'],
            ],
            [
                'article_id' => 11260, 'title' => 'LED Signage Lifespan: What Actually Shortens It', 'slug' => 'maintenance-tips',
                'category' => 'Best Practices', 'date' => '2026-03-25',
                'excerpt' => 'Heat, moisture ingress, and driver quality affect lifespan far more than the LED chips themselves.',
                'image' => 'https://picsum.photos/seed/signage-led/800/500', 'url' => 'id/11260', 'company_id' => 25121, 'company_name' => 'BrightSign Displays',
                'company_url' => 'brightsign.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=BS&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'BS', 'tags' => ['Manufacturer', 'Installation'],
            ],
            [
                'article_id' => 11271, 'title' => 'Corrugated vs Rigid Boxes: Picking the Right Packaging', 'slug' => 'packaging-basics',
                'category' => 'Guides', 'date' => '2026-03-16',
                'excerpt' => 'Product weight and shipping distance decide which box type actually protects your goods without overpaying.',
                'image' => 'https://picsum.photos/seed/packaging-boxes/800/500', 'url' => 'id/11271', 'company_id' => 25232, 'company_name' => 'PackRight Supplies',
                'company_url' => 'packright.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=PR&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'PR', 'tags' => ['Supplier', 'Manufacturer'],
            ],
            [
                'article_id' => 11282, 'title' => 'How Far Ahead Should You Book Event Catering', 'slug' => 'booking-timeline',
                'category' => 'Case Study', 'date' => '2026-03-09',
                'excerpt' => 'Guest count and menu customization both push the ideal booking window earlier than most people expect.',
                'image' => 'https://picsum.photos/seed/catering-service/800/500', 'url' => 'id/11282', 'company_id' => 25343, 'company_name' => 'Golden Spoon Catering',
                'company_url' => 'goldenspoon.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=GS&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'GS', 'tags' => ['Services', 'Supplier'],
            ],
            [
                'article_id' => 11293, 'title' => 'Signs of a Termite Infestation Before It Gets Structural', 'slug' => 'early-signs',
                'category' => 'Guides', 'date' => '2026-02-26',
                'excerpt' => 'Mud tubes and hollow-sounding wood are late signs — here is what to check earlier during a routine inspection.',
                'image' => 'https://picsum.photos/seed/pest-control/800/500', 'url' => 'id/11293', 'company_id' => 25454, 'company_name' => 'SafeGuard Pest Control',
                'company_url' => 'safeguardpest.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=SG&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'SG', 'tags' => ['Services', 'Specialist'],
            ],
            [
                'article_id' => 11304, 'title' => 'Renovation Permits: What Actually Needs Approval in Malaysia', 'slug' => 'permit-guide',
                'category' => 'Insights', 'date' => '2026-02-18',
                'excerpt' => 'Structural changes and extensions typically need local council approval; cosmetic work usually does not.',
                'image' => 'https://picsum.photos/seed/renovation-work/800/500', 'url' => 'id/11304', 'company_id' => 25565, 'company_name' => 'BuildCraft Renovation',
                'company_url' => 'buildcraft.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=BC&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'BC', 'tags' => ['Services', 'Manufacturer'],
            ],
            [
                'article_id' => 11315, 'title' => 'Why Vending Machines Reject Coins That Look Fine', 'slug' => 'faq',
                'category' => 'Guides', 'date' => '2026-02-09',
                'excerpt' => 'Worn edges and magnetic composition changes are the most common reasons a coin validator rejects a valid coin.',
                'image' => 'https://picsum.photos/seed/vending-machine/800/500', 'url' => 'id/11315', 'company_id' => 25676, 'company_name' => 'SnackHub Vending',
                'company_url' => 'snackhub.com.my', 'company_logo' => 'https://ui-avatars.com/api/?name=SH&background=1b4297&color=fff&size=128&bold=true', 'company_initials' => 'SH', 'tags' => ['Supplier', 'Services'],
            ],
        ];
    }

    public static function featured()
    {
        return [
            'title' => '5 Signs Your Business Needs an FAQ Page',
            'image' => 'https://picsum.photos/seed/blog-hero/1200/500',
            'url' => 'id/11040',
        ];
    }

    public static function articleDetail()
    {
        return [
            'faq_id' => 11040,
            'category' => 'Everything You Need to Know',
            'question' => 'What is Paint Protection Film (PPF)?',
            'answer' => 'PPF is a protective film that shields car paint from scratches, chips, stains, and minor damage.',
            'body' => [
                'Paint Protection Film has become the go-to solution for car owners looking to preserve their vehicle\'s finish without altering its appearance. Unlike a wax or sealant, PPF is a physical layer that absorbs impact from road debris, gravel chips, and minor abrasions before they ever reach the paint underneath.',
                'Most installers apply the film to high-impact zones — the front bumper, hood, mirrors, and door edges — though full-body coverage is increasingly common for owners who want long-term protection across every panel. A quality installation is virtually invisible, with a self-healing top coat that shrugs off light swirl marks when exposed to heat.',
                'Beyond the cosmetic benefit, PPF also helps protect resale value: a car that has spent years shielded from chips and scratches tends to retain a cleaner, more original-looking paint job than one left unprotected.',
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
        ];
    }
}
?>
