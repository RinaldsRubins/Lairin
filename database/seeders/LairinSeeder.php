<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\Industry;
use App\Models\Project;
use App\Models\SeoPage;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class LairinSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);

        $admin = User::updateOrCreate(
            ['email' => 'admin@lairin.lv'],
            [
                'name' => 'Lairin Admin',
                'password' => Hash::make('Lairin2026!'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        $this->seedServiceCategories();
        $this->seedIndustries();
        $this->seedProjects();
        $this->seedBlogPosts($admin);
        $this->seedFaqs();
        $this->seedTestimonials();
        $this->seedSiteSettings();
        $this->seedSeoPages();
    }

    protected function seedServiceCategories(): void
    {
        $categories = [
            'IT infrastruktūra' => [
                'icon' => 'server',
                'description' => 'Uzticama IT infrastruktūra un mākoņa risinājumi uzņēmumiem.',
                'items' => ['Serveri', 'Datu centri', 'Datortīkli', 'WiFi', 'Microsoft 365', 'Azure', 'Google Workspace', 'Backup', 'Virtualizācija', 'IT audits'],
            ],
            'Kiberdrošība' => [
                'icon' => 'shield',
                'description' => 'Visaptveroša kiberdrošība un risku pārvaldība.',
                'items' => ['Firewall', 'VPN', 'MFA', 'Zero Trust', 'EDR', 'XDR', 'SOC', 'SIEM', 'Pen Testing', 'Backup'],
            ],
            'AI risinājumi' => [
                'icon' => 'cpu',
                'description' => 'Mākslīgā intelekta integrācija un automatizācija.',
                'items' => ['AI Chatbots', 'ChatGPT integrācija', 'Microsoft Copilot', 'AI automatizācija', 'OCR', 'AI dokumentu analīze', 'AI asistenti', 'AI datu analītika', 'AI prognozēšana'],
            ],
            'Digitalizācija' => [
                'icon' => 'document',
                'description' => 'Procesu digitalizācija un darba plūsmu optimizācija.',
                'items' => ['Uzņēmumu digitalizācija', 'Dokumentu digitalizācija', 'Dokumentu vadības sistēmas', 'Darba plūsmas', 'Inventāra uzskaite', 'Noliktavas uzskaite', 'Grāmatvedības procesu digitalizācija', 'Personāla uzskaite', 'Elektroniskā dokumentu aprite'],
            ],
            'Programmatūras izstrāde' => [
                'icon' => 'code',
                'description' => 'Pielāgotas programmatūras un SaaS risinājumi.',
                'items' => ['CRM', 'ERP', 'Web sistēmas', 'Klientu portāli', 'API Integrācijas', 'SaaS', 'Mobilās aplikācijas'],
            ],
            'Mājaslapas' => [
                'icon' => 'globe',
                'description' => 'Modernas mājaslapas, e-veikali un SEO.',
                'items' => ['Mājaslapu izstrāde', 'Interneta veikali', 'E-komercija', 'SEO', 'UX/UI', 'Hostings', 'Domēni', 'ERP Integrācijas', 'CRM Integrācijas'],
            ],
            'Videonovērošana' => [
                'icon' => 'camera',
                'description' => 'IP kameras, AI analītika un piekļuves kontrole.',
                'items' => ['IP kameras', 'AI analītika', 'Numurzīmju atpazīšana', 'Signalizācijas', 'Piekļuves kontrole', 'Gudrās ēkas'],
            ],
            'Dronu pakalpojumi' => [
                'icon' => 'drone',
                'description' => 'Profesionāla aerofotografēšana un monitorings.',
                'items' => ['Aerofotografēšana', 'Aerofilmēšana', 'Fotogrammetrija', '3D modeļi', 'Termogrāfija', 'Jumtu inspekcijas', 'Būvobjektu uzmērīšana', 'Lauksaimniecības monitorings', 'Mežu monitorings'],
            ],
            'GIS risinājumi' => [
                'icon' => 'map',
                'description' => 'Telpiskie dati, kartogrāfija un WebGIS.',
                'items' => ['WebGIS', 'Kartogrāfija', 'Digitālās kartes', 'Telpisko datu analīze', 'Dronu datu integrācija', 'Pašvaldību GIS', 'Inženierkomunikāciju kartes'],
            ],
            'IoT' => [
                'icon' => 'chip',
                'description' => 'Sensori, gudrās ēkas un Industrial IoT.',
                'items' => ['Sensori', 'Gudrās ēkas', 'Enerģijas monitorings', 'Attālināta uzraudzība', 'Industrial IoT'],
            ],
        ];

        $order = 0;
        foreach ($categories as $name => $data) {
            $slug = Str::slug($name);
            $category = ServiceCategory::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'icon' => $data['icon'],
                    'description' => $data['description'],
                    'sort_order' => $order++,
                    'is_active' => true,
                    'meta_title' => "{$name} | Lairin",
                    'meta_description' => $data['description'],
                ]
            );

            $itemOrder = 0;
            foreach ($data['items'] as $item) {
                Service::updateOrCreate(
                    ['service_category_id' => $category->id, 'name' => $item],
                    [
                        'slug' => Str::slug($item),
                        'sort_order' => $itemOrder++,
                        'is_active' => true,
                        'is_bookable' => false,
                    ]
                );
            }

            Service::updateOrCreate(
                ['service_category_id' => $category->id, 'name' => "Konsultācija: {$name}"],
                [
                    'slug' => Str::slug("konsultacija-{$slug}"),
                    'description' => "Bezmaksas konsultācija par {$name} risinājumiem.",
                    'duration_minutes' => 45,
                    'sort_order' => 999,
                    'is_active' => true,
                    'is_bookable' => true,
                ]
            );
        }
    }

    protected function seedIndustries(): void
    {
        $industries = [
            ['Valsts iestādes', 'building', 'IT risinājumi valsts pārvaldei un drošībai.'],
            ['Pašvaldības', 'city', 'Digitalizācija un GIS pašvaldībām.'],
            ['Ražošana', 'factory', 'Industrial IoT un IT infrastruktūra ražotnēm.'],
            ['Būvniecība', 'construction', 'Dronu pakalpojumi un projektu uzraudzība.'],
            ['Loģistika', 'truck', 'Datortīkli un uzskaites sistēmas.'],
            ['Lauksaimniecība', 'leaf', 'GIS un dronu monitorings lauksaimniecībā.'],
            ['Medicīna', 'heart', 'Droša IT infrastruktūra veselības aprūpei.'],
            ['Izglītība', 'book', 'Digitalizācija un mākoņa risinājumi izglītībai.'],
            ['Finanšu sektors', 'chart', 'Kiberdrošība un atbilstība finanšu sektoram.'],
            ['Mazie un vidējie uzņēmumi', 'briefcase', 'Pilns IT atbalsta cikls MVU.'],
        ];

        foreach ($industries as $i => [$name, $icon, $desc]) {
            Industry::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'icon' => $icon,
                    'description' => $desc,
                    'sort_order' => $i,
                    'is_active' => true,
                ]
            );
        }
    }

    protected function seedProjects(): void
    {
        $projects = [
            ['Valsts iestādes IT modernizācija', 'Valsts iestāde', 'Valsts iestādes', 'infrastructure', ['Azure', 'Microsoft 365', 'Kiberdrošība']],
            ['Pašvaldības WebGIS platforma', 'Pašvaldība', 'Pašvaldības', 'gis', ['WebGIS', 'PostGIS', 'Laravel']],
            ['Ražotnes Industrial IoT', 'Ražošanas uzņēmums', 'Ražošana', 'iot', ['IoT', 'Azure IoT Hub', 'Power BI']],
            ['E-veikala izstrāde', 'Tirdzniecības uzņēmums', 'E-komercija', 'web', ['Laravel', 'Vue.js', 'Stripe']],
            ['Videonovērošanas sistēma', 'Loģistikas centrs', 'Loģistika', 'security', ['IP kameras', 'AI analītika', 'Milestone']],
            ['Dronu inspekcijas platforma', 'Būvniecības uzņēmums', 'Būvniecība', 'drone', ['Fotogrammetrija', '3D modeļi', 'GIS']],
        ];

        foreach ($projects as $i => [$title, $client, $industry, $category, $techs]) {
            Project::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'description' => "Veiksmīgi īstenots {$title} projekts ar pilnu cikla atbalstu.",
                    'content' => "<p>Lairin komanda nodrošināja projekta plānošanu, ieviešanu un uzturēšanu. Risinājums ievērojami uzlaboja klienta operatīvo efektivitāti un drošību.</p>",
                    'client' => $client,
                    'industry' => $industry,
                    'category' => $category,
                    'technologies' => $techs,
                    'is_featured' => true,
                    'is_published' => true,
                    'sort_order' => $i,
                    'published_at' => now()->subMonths($i + 1),
                ]
            );
        }
    }

    protected function seedBlogPosts(User $admin): void
    {
        $posts = [
            ['IT pakalpojumi Latvijā 2026: ko izvēlēties?', 'it-pakalpojumi-latvija-2026', 'IT pakalpojumi', 'Pārskats par galvenajiem IT ārpakalpojumu trendiem Latvijā.'],
            ['Kiberdrošības pamati uzņēmumiem', 'kiberdrosibas-pamati', 'Kiberdrošība', 'Praktiski padomi, kā aizsargāt uzņēmumu no kiberdraudiem.'],
            ['AI risinājumi biznesā: kur sākt?', 'ai-risinajumi-biznesa', 'AI risinājumi', 'Kā ieviest mākslīgo intelektu bez liekiem riskiem.'],
        ];

        foreach ($posts as $i => [$title, $slug, $tag, $excerpt]) {
            BlogPost::updateOrCreate(
                ['slug' => $slug],
                [
                    'user_id' => $admin->id,
                    'title' => $title,
                    'excerpt' => $excerpt,
                    'content' => "<p>{$excerpt}</p><p>Lairin eksperti dalās ar praktisku pieredzi un ieteikumiem, kas palīdz uzņēmumiem pieņemt pareizos IT lēmumus.</p>",
                    'tags' => [$tag],
                    'is_published' => true,
                    'meta_title' => "{$title} | Lairin Blogs",
                    'meta_description' => $excerpt,
                    'published_at' => now()->subDays($i * 7 + 3),
                ]
            );
        }
    }

    protected function seedFaqs(): void
    {
        $faqs = [
            ['Kādas IT pakalpojumu jomas Lairin apkalpo?', 'Mēs nodrošinām IT infrastruktūru, kiberdrošību, AI risinājumus, digitalizāciju, programmatūras izstrādi, GIS, dronu pakalpojumus, videonovērošanu un IoT.'],
            ['Vai piedāvājat bezmaksas konsultāciju?', 'Jā, pirmā konsultācija ir bez maksas. Rezervējiet laiku mūsu mājaslapā.'],
            ['Cik ilgi ilgst projekta ieviešana?', 'Atkarībā no projekta apjoma — no dažām dienām līdz vairākiem mēnešiem. Precīzu termiņu nosakām pēc vajadzību analīzes.'],
            ['Vai strādājat ar valsts iestādēm?', 'Jā, mums ir pieredze ar valsts iestādēm un pašvaldībām.'],
            ['Kāda ir atbalsta pieejamība?', 'Nodrošinām SLA atbalstu pēc klienta vajadzībām — 24/7 kritiskajām sistēmām.'],
        ];

        foreach ($faqs as $i => [$q, $a]) {
            Faq::updateOrCreate(['question' => $q], ['answer' => $a, 'sort_order' => $i, 'is_active' => true]);
        }
    }

    protected function seedTestimonials(): void
    {
        $items = [
            ['Jānis Bērziņš', 'SIA TechLat', 'IT direktors', 'Lairin komanda ātri un profesionāli ieviesa mūsu mākoņa infrastruktūru. Ieteicam!', 5],
            ['Anna Ozola', 'Pašvaldība', 'Projektu vadītāja', 'GIS risinājums pārsniedza mūsu gaidas. Lieliska sadarbība!', 5],
            ['Māris Kalniņš', 'SIA BuildPro', 'Direktors', 'Dronu inspekcijas pakalpojums ietaupīja laiku un naudu. Paldies Lairin!', 5],
        ];

        foreach ($items as $i => [$name, $company, $position, $content, $rating]) {
            Testimonial::updateOrCreate(
                ['name' => $name, 'company' => $company],
                ['position' => $position, 'content' => $content, 'rating' => $rating, 'sort_order' => $i, 'is_active' => true]
            );
        }
    }

    protected function seedSiteSettings(): void
    {
        $settings = [
            ['company_name', 'Lairin', 'general'],
            ['legal_name', 'SIA VENAB', 'general'],
            ['reg_number', '40203639381', 'general'],
            ['vat_number', '', 'general'],
            ['legal_address', 'Jelgava, Loka maģistrāle 30, LV-3004', 'general'],
            ['bank_details', '', 'general'],
            ['email', 'info@lairin.lv', 'contact'],
            ['phone', '+371 26447608', 'contact'],
            ['address', 'Rīga, Latvija', 'contact'],
            ['maps_lat', '56.9496', 'contact'],
            ['maps_lng', '24.1052', 'contact'],
            ['ga_id', '', 'analytics'],
            ['gsc_verification', '', 'analytics'],
        ];

        foreach ($settings as [$key, $value, $group]) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        }
    }

    protected function seedSeoPages(): void
    {
        $ogImage = '/images/og-image.png';
        $pages = [
            ['/', 'Lairin — IT risinājumi un ārpakalpojumi Latvijā', 'Lairin — uzticams IT partneris Latvijā. IT infrastruktūra, kiberdrošība, Azure, Microsoft 365, mākslīgais intelekts, digitalizācija, GIS, dronu pakalpojumi un videonovērošana. Bezmaksas konsultācija.', 'IT pakalpojumi Latvijā, IT ārpakalpojumi, kiberdrošība, AI risinājumi, digitalizācija, dronu pakalpojumi, GIS, ģis, videonovērošana, mājaslapu izstrāde, e-veikalu izstrāde, Microsoft 365, Azure, cloud, Lairin'],
            ['/pakalpojumi', 'IT pakalpojumi Latvijā | Lairin', 'Pilns IT pakalpojumu klāsts Latvijas uzņēmumiem: serveri, datortīkli, kiberdrošība, AI, CRM, e-veikali, GIS un IoT.', 'IT pakalpojumi Latvijā, Azure, Microsoft 365, cloud, kiberdrošība'],
            ['/nozares', 'IT risinājumi nozarēm | Lairin Latvija', 'IT risinājumi valsts iestādēm, pašvaldībām, ražošanai, būvniecībai, medicīnai un MVU Latvijā.', 'IT risinājumi Latvijā, valsts iestādes, ražošana'],
            ['/projekti', 'IT projekti un portfolio | Lairin', 'Realizētie IT projekti Latvijā — infrastruktūra, GIS, e-komercija, videonovērošana.', 'IT projekti Latvijā, portfolio'],
            ['/blogs', 'IT blogs | Lairin Latvija', 'Ekspertu raksti par kiberdrošību, AI, digitalizāciju un mākoņa risinājumiem Latvijā.', 'IT blogs Latvijā, kiberdrošība, AI'],
            ['/par-mums', 'Par Lairin | Latvijas IT uzņēmums', 'Lairin — Latvijas tehnoloģiju uzņēmums ar pilna cikla IT pakalpojumiem.', 'Lairin, IT uzņēmums Latvijā'],
            ['/kontakti', 'Kontakti | Lairin — info@lairin.lv', 'Sazinieties ar Lairin: info@lairin.lv, +371 26447608. Rīga, Latvija.', 'Lairin kontakti, IT konsultācija Latvijā'],
            ['/konsultacija', 'Bezmaksas IT konsultācija | Lairin', 'Rezervējiet bezmaksas IT konsultāciju tiešsaistē. Google Calendar integrācija.', 'IT konsultācija Latvijā, bezmaksas konsultācija'],
            ['/buj', 'Biežāk uzdotie jautājumi | Lairin', 'Atbildes uz populārākajiem jautājumiem par Lairin IT pakalpojumiem Latvijā.', 'BUJ, IT pakalpojumi'],
        ];

        foreach ($pages as [$path, $title, $desc, $keywords]) {
            SeoPage::updateOrCreate(
                ['path' => $path],
                ['title' => $title, 'description' => $desc, 'keywords' => $keywords, 'og_image' => $ogImage]
            );
        }
    }
}
