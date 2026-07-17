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
        ];
    }

    public static function featured()
    {
        return [
            'title' => '5 Signs Your Business Needs an FAQ Page',
            'image' => '',
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
            'splash_image' => '',
            'company' => [
                'company_id' => 28587,
                'name' => 'M 8 CAR ACCESSORIES AND TINTED (M) SDN BHD',
                'emails' => ['info@m8car.com.my'],
                'address' => '15, Jalan Keruing 1, Taman Rinting, 81750 Masai, Johor, Malaysia.',
                'website' => 'https://www.m8tint.com.my',
                'map_url' => 'https://www.google.com/maps/search/?api=1&query=1.49,103.85',
                'logo' => '',
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
