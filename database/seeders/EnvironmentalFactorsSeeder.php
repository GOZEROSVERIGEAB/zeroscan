<?php

namespace Database\Seeders;

use App\Models\EnvironmentalCategory;
use App\Models\EnvironmentalFactor;
use App\Models\EnvironmentalSource;
use Illuminate\Database\Seeder;

class EnvironmentalFactorsSeeder extends Seeder
{
    public function run(): void
    {
        $this->createSources();
        $this->createCategories();
        $this->createFactors();
    }

    private function createSources(): void
    {
        $sources = [
            [
                'slug' => 'ivl-second-hand-effect-2020',
                'name' => 'Second Hand Effect 2020',
                'organization' => 'IVL Svenska Miljöinstitutet',
                'report_title' => 'The Second Hand Effect Report',
                'report_url' => 'https://www.ivl.se/press/pressmeddelanden/2020-03-30-ny-rapport-visar-klimatfordelarna-med-aterbruk-av-it-utrustning.html',
                'publication_date' => '2020-03-30',
                'methodology' => 'LCA enligt ISO 14040-44',
                'description' => 'Årlig rapport om miljöeffekter av begagnathandel, framtagen av IVL för Schibsted/Adevinta.',
                'is_official' => true,
                'is_peer_reviewed' => true,
            ],
            [
                'slug' => 'ivl-inrego-it-2020',
                'name' => 'IT-produkters klimatpåverkan',
                'organization' => 'IVL Svenska Miljöinstitutet & Inrego',
                'report_title' => 'Klimatfördelar med återbruk av IT-utrustning',
                'report_url' => 'https://inrego.com/our-calculation-model',
                'publication_date' => '2020-03-30',
                'methodology' => 'LCA enligt ISO 14040-44, komponentnivå',
                'description' => 'Databas med klimatdata för IT-produkter ned till komponentnivå. Gratis att använda.',
                'is_official' => true,
                'is_peer_reviewed' => true,
            ],
            [
                'slug' => 'naturskyddsforeningen-2021',
                'name' => 'Andra hand i första hand',
                'organization' => 'Naturskyddsföreningen',
                'report_title' => 'Andra hand i första hand - Klimat- och miljöfördelar med begagnade möbler',
                'report_url' => 'https://cdn.naturskyddsforeningen.se/uploads/2021/09/29164251/Andra-hand-i-forsta-hand-klar.pdf',
                'publication_date' => '2021-09-29',
                'methodology' => 'LCA livscykelanalys',
                'description' => 'Rapport om klimat- och avfallsbesparingar vid köp av begagnade möbler istället för nya.',
                'is_official' => true,
                'is_peer_reviewed' => false,
            ],
            [
                'slug' => 'naturvardsverket-textil-2018',
                'name' => 'Klimatdata för textilier',
                'organization' => 'Naturvårdsverket / RISE (Swerea)',
                'report_title' => 'Klimatdata för textilier',
                'report_url' => 'https://www.naturvardsverket.se/4aacbb/globalassets/amnen/textil/rapport-klimatdata-for-textilier-swerea-2018.pdf',
                'publication_date' => '2018-10-01',
                'methodology' => 'LCA enligt ISO 14040-44',
                'description' => 'Officiell rapport om textiliers klimatpåverkan från Naturvårdsverket.',
                'is_official' => true,
                'is_peer_reviewed' => true,
            ],
            [
                'slug' => 'blocket-ivl-begagnateffekten-2019',
                'name' => 'Begagnateffekten',
                'organization' => 'IVL Svenska Miljöinstitutet / Blocket',
                'report_title' => 'Begagnathandelns klimatnytta',
                'report_url' => 'https://www.ivl.se/download/18.40a6040e17affadfb81c0f/1627976709962/Beg.handel_klimatnytta_rapport.pdf',
                'publication_date' => '2019-12-03',
                'methodology' => 'LCA enligt ISO 14040-44',
                'description' => 'Rapport om begagnathandelns positiva miljöeffekt, framtagen av IVL för Blocket.',
                'is_official' => true,
                'is_peer_reviewed' => true,
            ],
            [
                'slug' => 'carbonfact-2024',
                'name' => 'Fashion Carbon Footprint Database',
                'organization' => 'Carbonfact',
                'report_title' => 'Carbon Footprint of Fashion Products',
                'report_url' => 'https://www.carbonfact.com/carbon-footprint',
                'publication_date' => '2024-01-01',
                'methodology' => 'LCA enligt ISO 14040-44, produktspecifik',
                'description' => 'Databas med CO2-data för 60+ modeprodukter baserat på LCA-studier.',
                'is_official' => true,
                'is_peer_reviewed' => true,
            ],
            [
                'slug' => 'scientific-reports-furniture-2024',
                'name' => 'Furniture LCA Study',
                'organization' => 'Nature Scientific Reports',
                'report_title' => 'Comprehensive life cycle assessment of 25 furniture pieces',
                'report_url' => 'https://www.nature.com/articles/s41598-024-84025-8',
                'publication_date' => '2024-01-01',
                'methodology' => 'LCA enligt ISO 14040-44',
                'description' => 'Peer-reviewed studie av 25 möbeltyper med full LCA-analys.',
                'is_official' => true,
                'is_peer_reviewed' => true,
            ],
        ];

        foreach ($sources as $source) {
            EnvironmentalSource::updateOrCreate(
                ['slug' => $source['slug']],
                $source
            );
        }
    }

    private function createCategories(): void
    {
        $categories = [
            // ==================== MÖBLER ====================
            [
                'slug' => 'furniture',
                'name_sv' => 'Möbler',
                'name_en' => 'Furniture',
                'keywords' => ['möbel', 'möbler', 'furniture', 'inredning'],
                'children' => [
                    [
                        'slug' => 'furniture-seating',
                        'name_sv' => 'Sitsmöbler',
                        'name_en' => 'Seating',
                        'keywords' => ['sits', 'sitta', 'seat'],
                        'children' => [
                            ['slug' => 'furniture-sofa', 'name_sv' => 'Soffa', 'name_en' => 'Sofa', 'keywords' => ['soffa', 'sofa', 'couch', 'bäddsoffa', 'hörnsoffa', 'divansoffa', 'skinnsoffa', 'tygsoffa']],
                            ['slug' => 'furniture-armchair', 'name_sv' => 'Fåtölj', 'name_en' => 'Armchair', 'keywords' => ['fåtölj', 'armchair', 'loungestol', 'öronlappsfåtölj', 'hvilstol']],
                            ['slug' => 'furniture-chair', 'name_sv' => 'Stol', 'name_en' => 'Chair', 'keywords' => ['stol', 'chair', 'matstol', 'köksstol', 'pinnstol', 'trästol', 'stapelbar']],
                            ['slug' => 'furniture-office-chair', 'name_sv' => 'Kontorsstol', 'name_en' => 'Office Chair', 'keywords' => ['kontorsstol', 'skrivbordsstol', 'office chair', 'arbetsstol', 'ergonomisk']],
                            ['slug' => 'furniture-stool', 'name_sv' => 'Pall', 'name_en' => 'Stool', 'keywords' => ['pall', 'stool', 'barstol', 'fotpall', 'pianopall']],
                            ['slug' => 'furniture-bench', 'name_sv' => 'Bänk', 'name_en' => 'Bench', 'keywords' => ['bänk', 'bench', 'sittbänk', 'hallbänk', 'trädgårdsbänk']],
                        ],
                    ],
                    [
                        'slug' => 'furniture-tables',
                        'name_sv' => 'Bord',
                        'name_en' => 'Tables',
                        'keywords' => ['bord', 'table'],
                        'children' => [
                            ['slug' => 'furniture-dining-table', 'name_sv' => 'Matbord', 'name_en' => 'Dining Table', 'keywords' => ['matbord', 'dining table', 'köksbord', 'matsalsbord']],
                            ['slug' => 'furniture-coffee-table', 'name_sv' => 'Soffbord', 'name_en' => 'Coffee Table', 'keywords' => ['soffbord', 'coffee table', 'vardagsrumsbord']],
                            ['slug' => 'furniture-desk', 'name_sv' => 'Skrivbord', 'name_en' => 'Desk', 'keywords' => ['skrivbord', 'desk', 'arbetsbord', 'kontorsbord', 'höj- och sänkbart']],
                            ['slug' => 'furniture-side-table', 'name_sv' => 'Sidobord', 'name_en' => 'Side Table', 'keywords' => ['sidobord', 'nattduksbord', 'lampbord', 'side table', 'sängbord']],
                            ['slug' => 'furniture-console', 'name_sv' => 'Avlastningsbord', 'name_en' => 'Console Table', 'keywords' => ['avlastningsbord', 'console', 'hallbord', 'entréboard']],
                        ],
                    ],
                    [
                        'slug' => 'furniture-storage',
                        'name_sv' => 'Förvaring',
                        'name_en' => 'Storage',
                        'keywords' => ['förvaring', 'storage'],
                        'children' => [
                            ['slug' => 'furniture-bookshelf', 'name_sv' => 'Bokhylla', 'name_en' => 'Bookshelf', 'keywords' => ['bokhylla', 'bookshelf', 'hylla', 'kallax', 'billy', 'hyllsektion']],
                            ['slug' => 'furniture-wardrobe', 'name_sv' => 'Garderob', 'name_en' => 'Wardrobe', 'keywords' => ['garderob', 'wardrobe', 'klädskåp', 'pax', 'hallgarderob']],
                            ['slug' => 'furniture-dresser', 'name_sv' => 'Byrå', 'name_en' => 'Dresser', 'keywords' => ['byrå', 'dresser', 'kommod', 'malm', 'lådskåp']],
                            ['slug' => 'furniture-cabinet', 'name_sv' => 'Skåp', 'name_en' => 'Cabinet', 'keywords' => ['skåp', 'cabinet', 'vitrinskåp', 'sideboard', 'tv-bänk']],
                            ['slug' => 'furniture-shelf', 'name_sv' => 'Hylla', 'name_en' => 'Shelf', 'keywords' => ['hylla', 'shelf', 'vägghylla', 'svävande hylla']],
                        ],
                    ],
                    [
                        'slug' => 'furniture-beds',
                        'name_sv' => 'Sängar',
                        'name_en' => 'Beds',
                        'keywords' => ['säng', 'bed', 'sova'],
                        'children' => [
                            ['slug' => 'furniture-bed', 'name_sv' => 'Säng', 'name_en' => 'Bed', 'keywords' => ['säng', 'bed', 'sängstomme', 'dubbelsäng', 'enkelsäng', 'kontinentalsäng']],
                            ['slug' => 'furniture-mattress', 'name_sv' => 'Madrass', 'name_en' => 'Mattress', 'keywords' => ['madrass', 'mattress', 'resårmadrass', 'skummadrass']],
                            ['slug' => 'furniture-bunk-bed', 'name_sv' => 'Våningssäng', 'name_en' => 'Bunk Bed', 'keywords' => ['våningssäng', 'bunk bed', 'loftsäng']],
                        ],
                    ],
                    [
                        'slug' => 'furniture-kitchen',
                        'name_sv' => 'Kök',
                        'name_en' => 'Kitchen',
                        'keywords' => ['kök', 'kitchen'],
                        'children' => [
                            ['slug' => 'furniture-kitchen-cabinet', 'name_sv' => 'Köksskåp', 'name_en' => 'Kitchen Cabinet', 'keywords' => ['köksskåp', 'kitchen cabinet', 'bänkskiva', 'köksinredning']],
                            ['slug' => 'furniture-kitchen-island', 'name_sv' => 'Köksö', 'name_en' => 'Kitchen Island', 'keywords' => ['köksö', 'kitchen island', 'rullbord']],
                        ],
                    ],
                    [
                        'slug' => 'furniture-outdoor',
                        'name_sv' => 'Utemöbler',
                        'name_en' => 'Outdoor Furniture',
                        'keywords' => ['utemöbler', 'outdoor', 'trädgård', 'balkong', 'altan', 'utomhus'],
                        'children' => [
                            ['slug' => 'furniture-outdoor-table', 'name_sv' => 'Trädgårdsbord', 'name_en' => 'Garden Table', 'keywords' => ['trädgårdsbord', 'utebord', 'altanbord', 'cafébord']],
                            ['slug' => 'furniture-outdoor-chair', 'name_sv' => 'Trädgårdsstol', 'name_en' => 'Garden Chair', 'keywords' => ['trädgårdsstol', 'utestol', 'solstol', 'däckstol', 'caféstol']],
                            ['slug' => 'furniture-outdoor-sofa', 'name_sv' => 'Utesoffa', 'name_en' => 'Outdoor Sofa', 'keywords' => ['utesoffa', 'loungesoffa', 'hammock', 'hängmatta']],
                            ['slug' => 'furniture-parasol', 'name_sv' => 'Parasoll', 'name_en' => 'Parasol', 'keywords' => ['parasoll', 'solskydd', 'markis']],
                        ],
                    ],
                ],
            ],

            // ==================== ELEKTRONIK ====================
            [
                'slug' => 'electronics',
                'name_sv' => 'Elektronik',
                'name_en' => 'Electronics',
                'keywords' => ['elektronik', 'electronics', 'el', 'teknik'],
                'children' => [
                    [
                        'slug' => 'electronics-computers',
                        'name_sv' => 'Datorer',
                        'name_en' => 'Computers',
                        'keywords' => ['dator', 'computer'],
                        'children' => [
                            ['slug' => 'electronics-laptop', 'name_sv' => 'Bärbar dator', 'name_en' => 'Laptop', 'keywords' => ['laptop', 'bärbar dator', 'notebook', 'macbook', 'chromebook']],
                            ['slug' => 'electronics-desktop', 'name_sv' => 'Stationär dator', 'name_en' => 'Desktop', 'keywords' => ['stationär', 'desktop', 'tower', 'pc', 'imac', 'gaming pc']],
                            ['slug' => 'electronics-monitor', 'name_sv' => 'Datorskärm', 'name_en' => 'Monitor', 'keywords' => ['skärm', 'monitor', 'bildskärm', 'display', 'gamingskärm']],
                            ['slug' => 'electronics-tablet', 'name_sv' => 'Surfplatta', 'name_en' => 'Tablet', 'keywords' => ['surfplatta', 'tablet', 'ipad', 'platta', 'android tablet']],
                            ['slug' => 'electronics-keyboard', 'name_sv' => 'Tangentbord', 'name_en' => 'Keyboard', 'keywords' => ['tangentbord', 'keyboard', 'mekaniskt']],
                            ['slug' => 'electronics-mouse', 'name_sv' => 'Mus', 'name_en' => 'Mouse', 'keywords' => ['mus', 'mouse', 'datormus', 'trådlös mus']],
                        ],
                    ],
                    [
                        'slug' => 'electronics-phones',
                        'name_sv' => 'Telefoner',
                        'name_en' => 'Phones',
                        'keywords' => ['telefon', 'phone', 'mobil'],
                        'children' => [
                            ['slug' => 'electronics-smartphone', 'name_sv' => 'Smartphone', 'name_en' => 'Smartphone', 'keywords' => ['smartphone', 'mobil', 'mobiltelefon', 'iphone', 'android', 'samsung']],
                            ['slug' => 'electronics-smartwatch', 'name_sv' => 'Smartklocka', 'name_en' => 'Smartwatch', 'keywords' => ['smartklocka', 'smartwatch', 'apple watch', 'fitnesstracker']],
                        ],
                    ],
                    [
                        'slug' => 'electronics-av',
                        'name_sv' => 'Ljud & Bild',
                        'name_en' => 'Audio & Video',
                        'keywords' => ['ljud', 'bild', 'audio', 'video'],
                        'children' => [
                            ['slug' => 'electronics-tv', 'name_sv' => 'TV', 'name_en' => 'Television', 'keywords' => ['tv', 'television', 'smart-tv', 'platt-tv', 'oled', 'lcd']],
                            ['slug' => 'electronics-speaker', 'name_sv' => 'Högtalare', 'name_en' => 'Speaker', 'keywords' => ['högtalare', 'speaker', 'ljudsystem', 'sonos', 'bluetooth']],
                            ['slug' => 'electronics-headphones', 'name_sv' => 'Hörlurar', 'name_en' => 'Headphones', 'keywords' => ['hörlurar', 'headphones', 'airpods', 'earbuds', 'over-ear']],
                            ['slug' => 'electronics-camera', 'name_sv' => 'Kamera', 'name_en' => 'Camera', 'keywords' => ['kamera', 'camera', 'systemkamera', 'kompaktkamera', 'videokamera']],
                            ['slug' => 'electronics-projector', 'name_sv' => 'Projektor', 'name_en' => 'Projector', 'keywords' => ['projektor', 'projector', 'beamer']],
                        ],
                    ],
                    [
                        'slug' => 'electronics-appliances',
                        'name_sv' => 'Vitvaror',
                        'name_en' => 'Appliances',
                        'keywords' => ['vitvaror', 'appliances', 'hushåll'],
                        'children' => [
                            ['slug' => 'electronics-fridge', 'name_sv' => 'Kylskåp', 'name_en' => 'Refrigerator', 'keywords' => ['kylskåp', 'kyl', 'frys', 'refrigerator', 'fridge', 'kylfrysskåp']],
                            ['slug' => 'electronics-freezer', 'name_sv' => 'Frys', 'name_en' => 'Freezer', 'keywords' => ['frys', 'freezer', 'frysskåp', 'frysbox']],
                            ['slug' => 'electronics-washing-machine', 'name_sv' => 'Tvättmaskin', 'name_en' => 'Washing Machine', 'keywords' => ['tvättmaskin', 'washing machine', 'tvätt', 'tvättmaskin']],
                            ['slug' => 'electronics-dryer', 'name_sv' => 'Torktumlare', 'name_en' => 'Dryer', 'keywords' => ['torktumlare', 'torkskåp', 'dryer', 'torktumla']],
                            ['slug' => 'electronics-dishwasher', 'name_sv' => 'Diskmaskin', 'name_en' => 'Dishwasher', 'keywords' => ['diskmaskin', 'dishwasher', 'disk']],
                            ['slug' => 'electronics-oven', 'name_sv' => 'Ugn', 'name_en' => 'Oven', 'keywords' => ['ugn', 'oven', 'inbyggnadsugn', 'spis', 'häll']],
                            ['slug' => 'electronics-microwave', 'name_sv' => 'Mikrovågsugn', 'name_en' => 'Microwave', 'keywords' => ['mikrovågsugn', 'microwave', 'mikro']],
                        ],
                    ],
                    [
                        'slug' => 'electronics-small-appliances',
                        'name_sv' => 'Småelektronik',
                        'name_en' => 'Small Appliances',
                        'keywords' => ['småelektronik', 'small appliances'],
                        'children' => [
                            ['slug' => 'electronics-vacuum', 'name_sv' => 'Dammsugare', 'name_en' => 'Vacuum Cleaner', 'keywords' => ['dammsugare', 'vacuum', 'robotdammsugare', 'dyson']],
                            ['slug' => 'electronics-coffee-machine', 'name_sv' => 'Kaffemaskin', 'name_en' => 'Coffee Machine', 'keywords' => ['kaffemaskin', 'kaffebryggare', 'espresso', 'nespresso', 'dolce gusto']],
                            ['slug' => 'electronics-printer', 'name_sv' => 'Skrivare', 'name_en' => 'Printer', 'keywords' => ['skrivare', 'printer', 'scanner', 'kopiator']],
                            ['slug' => 'electronics-blender', 'name_sv' => 'Mixer', 'name_en' => 'Blender', 'keywords' => ['mixer', 'blender', 'matberedare', 'smoothie']],
                            ['slug' => 'electronics-toaster', 'name_sv' => 'Brödrost', 'name_en' => 'Toaster', 'keywords' => ['brödrost', 'toaster']],
                            ['slug' => 'electronics-iron', 'name_sv' => 'Strykjärn', 'name_en' => 'Iron', 'keywords' => ['strykjärn', 'iron', 'ångstrykjärn', 'ångstation']],
                        ],
                    ],
                    [
                        'slug' => 'electronics-gaming',
                        'name_sv' => 'Spel & Gaming',
                        'name_en' => 'Gaming',
                        'keywords' => ['gaming', 'spel', 'konsol'],
                        'children' => [
                            ['slug' => 'electronics-console', 'name_sv' => 'Spelkonsol', 'name_en' => 'Game Console', 'keywords' => ['spelkonsol', 'playstation', 'xbox', 'nintendo', 'switch', 'ps5']],
                            ['slug' => 'electronics-vr', 'name_sv' => 'VR-headset', 'name_en' => 'VR Headset', 'keywords' => ['vr', 'virtual reality', 'oculus', 'quest']],
                        ],
                    ],
                ],
            ],

            // ==================== KLÄDER ====================
            [
                'slug' => 'clothing',
                'name_sv' => 'Kläder',
                'name_en' => 'Clothing',
                'keywords' => ['kläder', 'clothing', 'textil', 'plagg'],
                'children' => [
                    [
                        'slug' => 'clothing-tops',
                        'name_sv' => 'Överdelar',
                        'name_en' => 'Tops',
                        'keywords' => ['överdel', 'top'],
                        'children' => [
                            ['slug' => 'clothing-tshirt', 'name_sv' => 'T-shirt', 'name_en' => 'T-Shirt', 'keywords' => ['t-shirt', 'tshirt', 'tröja', 'linne', 'tank top']],
                            ['slug' => 'clothing-shirt', 'name_sv' => 'Skjorta', 'name_en' => 'Shirt', 'keywords' => ['skjorta', 'shirt', 'blus', 'pikétröja', 'piké', 'polo', 'flanellskjorta']],
                            ['slug' => 'clothing-sweater', 'name_sv' => 'Tröja', 'name_en' => 'Sweater', 'keywords' => ['tröja', 'sweater', 'stickad', 'hoodie', 'collegetröja', 'sweatshirt']],
                            ['slug' => 'clothing-cardigan', 'name_sv' => 'Kofta', 'name_en' => 'Cardigan', 'keywords' => ['kofta', 'cardigan', 'stickad kofta']],
                            ['slug' => 'clothing-tank-top', 'name_sv' => 'Linne', 'name_en' => 'Tank Top', 'keywords' => ['linne', 'tank top', 'singlet', 'topp']],
                            ['slug' => 'clothing-blouse', 'name_sv' => 'Blus', 'name_en' => 'Blouse', 'keywords' => ['blus', 'blouse', 'tunika']],
                        ],
                    ],
                    [
                        'slug' => 'clothing-bottoms',
                        'name_sv' => 'Underdelar',
                        'name_en' => 'Bottoms',
                        'keywords' => ['underdel', 'bottom'],
                        'children' => [
                            ['slug' => 'clothing-jeans', 'name_sv' => 'Jeans', 'name_en' => 'Jeans', 'keywords' => ['jeans', 'denim', 'jeansbyxor']],
                            ['slug' => 'clothing-pants', 'name_sv' => 'Byxor', 'name_en' => 'Pants', 'keywords' => ['byxor', 'pants', 'chinos', 'kostymbyxor', 'tygbyxor']],
                            ['slug' => 'clothing-skirt', 'name_sv' => 'Kjol', 'name_en' => 'Skirt', 'keywords' => ['kjol', 'skirt', 'maxikjol', 'minikjol']],
                            ['slug' => 'clothing-shorts', 'name_sv' => 'Shorts', 'name_en' => 'Shorts', 'keywords' => ['shorts', 'kortbyxor', 'bermuda']],
                            ['slug' => 'clothing-leggings', 'name_sv' => 'Leggings', 'name_en' => 'Leggings', 'keywords' => ['leggings', 'tights', 'yogabyxor']],
                        ],
                    ],
                    [
                        'slug' => 'clothing-outerwear',
                        'name_sv' => 'Ytterkläder',
                        'name_en' => 'Outerwear',
                        'keywords' => ['ytter', 'outerwear', 'jacka'],
                        'children' => [
                            ['slug' => 'clothing-jacket', 'name_sv' => 'Jacka', 'name_en' => 'Jacket', 'keywords' => ['jacka', 'jacket', 'kavaj', 'blazer', 'skinnjacka', 'jeansjacka']],
                            ['slug' => 'clothing-coat', 'name_sv' => 'Kappa', 'name_en' => 'Coat', 'keywords' => ['kappa', 'coat', 'rock', 'vinterjacka', 'dunjacka', 'parkas']],
                            ['slug' => 'clothing-fleece', 'name_sv' => 'Fleece', 'name_en' => 'Fleece', 'keywords' => ['fleece', 'fleecejacka', 'softshell']],
                            ['slug' => 'clothing-vest', 'name_sv' => 'Väst', 'name_en' => 'Vest', 'keywords' => ['väst', 'vest', 'dunväst', 'gilet']],
                            ['slug' => 'clothing-raincoat', 'name_sv' => 'Regnkläder', 'name_en' => 'Rainwear', 'keywords' => ['regnjacka', 'regnkläder', 'regnbyxor', 'regnrock']],
                        ],
                    ],
                    [
                        'slug' => 'clothing-dresses',
                        'name_sv' => 'Klänningar',
                        'name_en' => 'Dresses',
                        'keywords' => ['klänning', 'dress'],
                        'children' => [
                            ['slug' => 'clothing-dress', 'name_sv' => 'Klänning', 'name_en' => 'Dress', 'keywords' => ['klänning', 'dress', 'festklänning', 'maxiklänning']],
                            ['slug' => 'clothing-jumpsuit', 'name_sv' => 'Jumpsuit', 'name_en' => 'Jumpsuit', 'keywords' => ['jumpsuit', 'overall', 'playsuit']],
                        ],
                    ],
                    [
                        'slug' => 'clothing-suits',
                        'name_sv' => 'Kostymer',
                        'name_en' => 'Suits',
                        'keywords' => ['kostym', 'suit'],
                        'children' => [
                            ['slug' => 'clothing-suit', 'name_sv' => 'Kostym', 'name_en' => 'Suit', 'keywords' => ['kostym', 'suit', 'kavaj', 'kostymbyxor']],
                        ],
                    ],
                    [
                        'slug' => 'clothing-underwear',
                        'name_sv' => 'Underkläder',
                        'name_en' => 'Underwear',
                        'keywords' => ['underkläder', 'underwear'],
                        'children' => [
                            ['slug' => 'clothing-underwear-general', 'name_sv' => 'Underkläder', 'name_en' => 'Underwear', 'keywords' => ['underkläder', 'kalsonger', 'trosor', 'bh', 'boxers']],
                            ['slug' => 'clothing-socks', 'name_sv' => 'Strumpor', 'name_en' => 'Socks', 'keywords' => ['strumpor', 'socks', 'strumpbyxor', 'tights']],
                            ['slug' => 'clothing-pajamas', 'name_sv' => 'Pyjamas', 'name_en' => 'Pajamas', 'keywords' => ['pyjamas', 'pajamas', 'nattlinne', 'morgonrock']],
                        ],
                    ],
                    [
                        'slug' => 'clothing-sportswear',
                        'name_sv' => 'Träningskläder',
                        'name_en' => 'Sportswear',
                        'keywords' => ['träningskläder', 'sportswear', 'aktivkläder'],
                        'children' => [
                            ['slug' => 'clothing-sport-top', 'name_sv' => 'Träningstopp', 'name_en' => 'Sports Top', 'keywords' => ['träningstopp', 'sport-bh', 'funktionslinne']],
                            ['slug' => 'clothing-sport-pants', 'name_sv' => 'Träningsbyxor', 'name_en' => 'Sports Pants', 'keywords' => ['träningsbyxor', 'joggingbyxor', 'mjukisbyxor']],
                            ['slug' => 'clothing-swimwear', 'name_sv' => 'Badkläder', 'name_en' => 'Swimwear', 'keywords' => ['badkläder', 'bikini', 'baddräkt', 'badbyxor', 'badshorts']],
                            ['slug' => 'clothing-wetsuit', 'name_sv' => 'Våtdräkt', 'name_en' => 'Wetsuit', 'keywords' => ['våtdräkt', 'wetsuit', 'dykardräkt']],
                        ],
                    ],
                    [
                        'slug' => 'clothing-shoes',
                        'name_sv' => 'Skor',
                        'name_en' => 'Shoes',
                        'keywords' => ['sko', 'skor', 'shoes', 'footwear'],
                        'children' => [
                            ['slug' => 'clothing-shoes-general', 'name_sv' => 'Skor', 'name_en' => 'Shoes', 'keywords' => ['skor', 'shoes', 'vardagsskor']],
                            ['slug' => 'clothing-sneakers', 'name_sv' => 'Sneakers', 'name_en' => 'Sneakers', 'keywords' => ['sneakers', 'träningsskor', 'tennisskor', 'gympaskor']],
                            ['slug' => 'clothing-boots', 'name_sv' => 'Stövlar', 'name_en' => 'Boots', 'keywords' => ['stövlar', 'boots', 'kängor', 'vinterstövlar', 'gummistövlar']],
                            ['slug' => 'clothing-sandals', 'name_sv' => 'Sandaler', 'name_en' => 'Sandals', 'keywords' => ['sandaler', 'sandals', 'flip-flops', 'sommarskor']],
                            ['slug' => 'clothing-heels', 'name_sv' => 'Klackskor', 'name_en' => 'Heels', 'keywords' => ['klackskor', 'heels', 'pumps', 'högklackade']],
                            ['slug' => 'clothing-loafers', 'name_sv' => 'Loafers', 'name_en' => 'Loafers', 'keywords' => ['loafers', 'mockasiner', 'slip-ons']],
                        ],
                    ],
                    [
                        'slug' => 'clothing-accessories',
                        'name_sv' => 'Accessoarer',
                        'name_en' => 'Accessories',
                        'keywords' => ['accessoar', 'accessories'],
                        'children' => [
                            ['slug' => 'clothing-hat', 'name_sv' => 'Hattar & Mössor', 'name_en' => 'Hats', 'keywords' => ['hatt', 'mössa', 'keps', 'beanie', 'basker']],
                            ['slug' => 'clothing-scarf', 'name_sv' => 'Halsduk', 'name_en' => 'Scarf', 'keywords' => ['halsduk', 'scarf', 'sjal', 'poncho']],
                            ['slug' => 'clothing-gloves', 'name_sv' => 'Handskar', 'name_en' => 'Gloves', 'keywords' => ['handskar', 'gloves', 'vantar', 'tumvantar']],
                            ['slug' => 'clothing-belt', 'name_sv' => 'Bälte', 'name_en' => 'Belt', 'keywords' => ['bälte', 'belt', 'skärp', 'läderbälte']],
                            ['slug' => 'clothing-tie', 'name_sv' => 'Slips', 'name_en' => 'Tie', 'keywords' => ['slips', 'tie', 'fluga', 'näsduk']],
                            ['slug' => 'clothing-sunglasses', 'name_sv' => 'Solglasögon', 'name_en' => 'Sunglasses', 'keywords' => ['solglasögon', 'sunglasses', 'glasögon']],
                        ],
                    ],
                ],
            ],

            // ==================== VÄSKOR ====================
            [
                'slug' => 'bags',
                'name_sv' => 'Väskor',
                'name_en' => 'Bags',
                'keywords' => ['väska', 'bags', 'bag'],
                'children' => [
                    ['slug' => 'bags-handbag', 'name_sv' => 'Handväska', 'name_en' => 'Handbag', 'keywords' => ['handväska', 'handbag', 'axelremsväska', 'clutch']],
                    ['slug' => 'bags-backpack', 'name_sv' => 'Ryggsäck', 'name_en' => 'Backpack', 'keywords' => ['ryggsäck', 'backpack', 'skolväska']],
                    ['slug' => 'bags-suitcase', 'name_sv' => 'Resväska', 'name_en' => 'Suitcase', 'keywords' => ['resväska', 'suitcase', 'kabinväska', 'trolley']],
                    ['slug' => 'bags-wallet', 'name_sv' => 'Plånbok', 'name_en' => 'Wallet', 'keywords' => ['plånbok', 'wallet', 'börs', 'korthållare']],
                    ['slug' => 'bags-laptop-bag', 'name_sv' => 'Datorväska', 'name_en' => 'Laptop Bag', 'keywords' => ['datorväska', 'laptop bag', 'portfölj', 'datorfodral']],
                    ['slug' => 'bags-sports-bag', 'name_sv' => 'Sportväska', 'name_en' => 'Sports Bag', 'keywords' => ['sportväska', 'sports bag', 'träningsväska', 'duffelbag']],
                ],
            ],

            // ==================== SPORT & FRITID ====================
            [
                'slug' => 'sports',
                'name_sv' => 'Sport & Fritid',
                'name_en' => 'Sports & Leisure',
                'keywords' => ['sport', 'fritid', 'träning', 'outdoor'],
                'children' => [
                    ['slug' => 'sports-bicycle', 'name_sv' => 'Cykel', 'name_en' => 'Bicycle', 'keywords' => ['cykel', 'bicycle', 'bike', 'elcykel', 'mountainbike', 'racercykel', 'stadscykel', 'barncykel']],
                    ['slug' => 'sports-ebike', 'name_sv' => 'Elcykel', 'name_en' => 'E-Bike', 'keywords' => ['elcykel', 'e-bike', 'electric bike', 'el-cykel']],
                    ['slug' => 'sports-skis', 'name_sv' => 'Skidor', 'name_en' => 'Skis', 'keywords' => ['skidor', 'ski', 'längdskidor', 'slalom', 'skidpjäxor', 'pjäxor', 'fiskfjäll', 'skidkant', 'kantslip', 'längdåkning', 'vintersport', 'alpint', 'carving']],
                    ['slug' => 'sports-snowboard', 'name_sv' => 'Snowboard', 'name_en' => 'Snowboard', 'keywords' => ['snowboard', 'bräda', 'snowboardboots', 'snowboardbindning']],
                    ['slug' => 'sports-skating', 'name_sv' => 'Skridskor', 'name_en' => 'Ice Skates', 'keywords' => ['skridskor', 'skates', 'skridsko', 'skridskoskydd', 'skridskopingvin', 'åkhjälp', 'ishockey', 'konståkning']],
                    ['slug' => 'sports-inline', 'name_sv' => 'Inlines', 'name_en' => 'Inline Skates', 'keywords' => ['inlines', 'rullskridskor', 'rollerblades', 'rullhockey']],
                    ['slug' => 'sports-skateboard', 'name_sv' => 'Skateboard', 'name_en' => 'Skateboard', 'keywords' => ['skateboard', 'longboard', 'pennyboard', 'bräda']],
                    ['slug' => 'sports-athletics', 'name_sv' => 'Friidrott', 'name_en' => 'Athletics', 'keywords' => ['friidrott', 'häck', 'häckar', 'höjdhopp', 'höjdhoppsmatta', 'stavhopp', 'kula', 'spjut', 'diskus', 'löpning']],
                    ['slug' => 'sports-balls', 'name_sv' => 'Bollar', 'name_en' => 'Balls', 'keywords' => ['boll', 'bollar', 'fotboll', 'basketboll', 'volleyboll', 'gummiboll', 'tennisboll', 'handboll']],
                    ['slug' => 'sports-golf', 'name_sv' => 'Golf', 'name_en' => 'Golf', 'keywords' => ['golf', 'golfklubbor', 'golfbag', 'driver', 'putter', 'golfbollar']],
                    ['slug' => 'sports-tennis', 'name_sv' => 'Tennis & Racket', 'name_en' => 'Tennis & Racket', 'keywords' => ['tennis', 'badminton', 'squash', 'racket', 'padel']],
                    ['slug' => 'sports-fitness', 'name_sv' => 'Träningsutrustning', 'name_en' => 'Fitness Equipment', 'keywords' => ['träning', 'fitness', 'vikter', 'löpband', 'crosstrainer', 'motionscykel', 'hantlar', 'kettlebell', 'yogamatta']],
                    ['slug' => 'sports-camping', 'name_sv' => 'Camping', 'name_en' => 'Camping', 'keywords' => ['camping', 'tält', 'sovsäck', 'friluftsliv', 'liggunderlag', 'campingkök']],
                    ['slug' => 'sports-hiking', 'name_sv' => 'Vandring', 'name_en' => 'Hiking', 'keywords' => ['vandring', 'hiking', 'vandringsryggsäck', 'vandringskängor', 'vandringsstavar']],
                    ['slug' => 'sports-water', 'name_sv' => 'Vattensport', 'name_en' => 'Water Sports', 'keywords' => ['vattensport', 'kajak', 'kanot', 'sup', 'surfbräda', 'paddel', 'flytväst']],
                    ['slug' => 'sports-fishing', 'name_sv' => 'Fiske', 'name_en' => 'Fishing', 'keywords' => ['fiske', 'fishing', 'fiskespö', 'rulle', 'flugfiske', 'fiskeutrustning']],
                    ['slug' => 'sports-hunting', 'name_sv' => 'Jakt', 'name_en' => 'Hunting', 'keywords' => ['jakt', 'hunting', 'jaktkläder', 'kikare']],
                    ['slug' => 'sports-equestrian', 'name_sv' => 'Ridning', 'name_en' => 'Equestrian', 'keywords' => ['ridning', 'ridkläder', 'ridhjälm', 'sadel', 'hästutrustning']],
                    ['slug' => 'sports-climbing', 'name_sv' => 'Klättring', 'name_en' => 'Climbing', 'keywords' => ['klättring', 'climbing', 'klättersele', 'klätterskor', 'rep', 'karbinhakar']],
                ],
            ],

            // ==================== BARN & BABY ====================
            [
                'slug' => 'baby',
                'name_sv' => 'Barn & Baby',
                'name_en' => 'Baby & Kids',
                'keywords' => ['barn', 'baby', 'bebis', 'kids'],
                'children' => [
                    ['slug' => 'baby-stroller', 'name_sv' => 'Barnvagn', 'name_en' => 'Stroller', 'keywords' => ['barnvagn', 'stroller', 'sulky', 'sittvagn', 'liggvagn', 'duo']],
                    ['slug' => 'baby-car-seat', 'name_sv' => 'Bilbarnstol', 'name_en' => 'Car Seat', 'keywords' => ['bilbarnstol', 'car seat', 'babyskydd', 'isofix', 'bälteskudde']],
                    ['slug' => 'baby-crib', 'name_sv' => 'Spjälsäng', 'name_en' => 'Crib', 'keywords' => ['spjälsäng', 'crib', 'babysäng', 'vagga', 'bedside crib']],
                    ['slug' => 'baby-high-chair', 'name_sv' => 'Barnstol', 'name_en' => 'High Chair', 'keywords' => ['barnstol', 'high chair', 'matstol', 'trip trap']],
                    ['slug' => 'baby-carrier', 'name_sv' => 'Bärsele', 'name_en' => 'Baby Carrier', 'keywords' => ['bärsele', 'baby carrier', 'bärsjal']],
                    ['slug' => 'baby-playpen', 'name_sv' => 'Lekhage', 'name_en' => 'Playpen', 'keywords' => ['lekhage', 'playpen', 'babygym']],
                    ['slug' => 'baby-changing-table', 'name_sv' => 'Skötbord', 'name_en' => 'Changing Table', 'keywords' => ['skötbord', 'changing table', 'skötväska']],
                ],
            ],

            // ==================== LEKSAKER ====================
            [
                'slug' => 'toys',
                'name_sv' => 'Leksaker',
                'name_en' => 'Toys',
                'keywords' => ['leksak', 'leksaker', 'toys', 'barn', 'lek'],
                'children' => [
                    ['slug' => 'toys-plastic', 'name_sv' => 'Plastleksaker', 'name_en' => 'Plastic Toys', 'keywords' => ['plast', 'plastic', 'lego', 'duplo', 'playmobil']],
                    ['slug' => 'toys-soft', 'name_sv' => 'Mjukdjur', 'name_en' => 'Soft Toys', 'keywords' => ['mjukdjur', 'gosedjur', 'plush', 'nalle', 'docka']],
                    ['slug' => 'toys-games', 'name_sv' => 'Spel', 'name_en' => 'Games', 'keywords' => ['spel', 'game', 'brädspel', 'pussel', 'kortspel']],
                    ['slug' => 'toys-wooden', 'name_sv' => 'Träleksaker', 'name_en' => 'Wooden Toys', 'keywords' => ['trä', 'wooden', 'tågbana', 'brio', 'klossar']],
                    ['slug' => 'toys-outdoor', 'name_sv' => 'Uteleksaker', 'name_en' => 'Outdoor Toys', 'keywords' => ['uteleksak', 'gunga', 'sandlåda', 'rutschkana', 'studsmatta']],
                    ['slug' => 'toys-rc', 'name_sv' => 'Radiostyrda leksaker', 'name_en' => 'RC Toys', 'keywords' => ['rc', 'radiostyrda', 'drönare', 'drone', 'radiobil']],
                ],
            ],

            // ==================== BÖCKER & MEDIA ====================
            [
                'slug' => 'books',
                'name_sv' => 'Böcker & Media',
                'name_en' => 'Books & Media',
                'keywords' => ['bok', 'böcker', 'books', 'media'],
                'children' => [
                    ['slug' => 'books-paperback', 'name_sv' => 'Bok', 'name_en' => 'Book', 'keywords' => ['bok', 'book', 'pocket', 'inbunden', 'roman', 'facklitteratur']],
                    ['slug' => 'books-vinyl', 'name_sv' => 'Vinyl', 'name_en' => 'Vinyl Records', 'keywords' => ['vinyl', 'lp', 'skiva', 'grammofonskiva']],
                    ['slug' => 'books-cd', 'name_sv' => 'CD/DVD', 'name_en' => 'CD/DVD', 'keywords' => ['cd', 'dvd', 'bluray', 'film', 'musik']],
                ],
            ],

            // ==================== HUSHÅLL ====================
            [
                'slug' => 'household',
                'name_sv' => 'Hushåll',
                'name_en' => 'Household',
                'keywords' => ['hushåll', 'household', 'hem', 'home'],
                'children' => [
                    ['slug' => 'household-kitchenware', 'name_sv' => 'Köksartiklar', 'name_en' => 'Kitchenware', 'keywords' => ['kök', 'kitchen', 'kastruller', 'porslin', 'bestick', 'stekpanna', 'gryta']],
                    ['slug' => 'household-textiles', 'name_sv' => 'Hemtextil', 'name_en' => 'Home Textiles', 'keywords' => ['textil', 'matta', 'gardin', 'kudde', 'filt', 'lakan', 'entrématta', 'täcke', 'pläd']],
                    ['slug' => 'household-decor', 'name_sv' => 'Dekoration', 'name_en' => 'Decoration', 'keywords' => ['dekoration', 'decor', 'tavla', 'vas', 'ljusstake', 'spegel', 'konst', 'skulptur']],
                    ['slug' => 'household-lamps', 'name_sv' => 'Lampor', 'name_en' => 'Lamps', 'keywords' => ['lampa', 'lamp', 'belysning', 'taklampa', 'golvlampa', 'bordslampa', 'caravaggio', 'pendel', 'ljuskrona', 'vägglampa']],
                    ['slug' => 'household-electrical', 'name_sv' => 'El & Installation', 'name_en' => 'Electrical', 'keywords' => ['el', 'elinstallation', 'strömbrytare', 'uttag', 'dimmer', 'elcentral']],
                    ['slug' => 'household-bathroom', 'name_sv' => 'Badrum', 'name_en' => 'Bathroom', 'keywords' => ['badrum', 'bathroom', 'handfat', 'toalett', 'dusch', 'badkar', 'kran']],
                    ['slug' => 'household-cleaning', 'name_sv' => 'Städutrustning', 'name_en' => 'Cleaning', 'keywords' => ['städ', 'cleaning', 'mopp', 'hink', 'städmaskin']],
                ],
            ],

            // ==================== TRÄDGÅRD ====================
            [
                'slug' => 'garden',
                'name_sv' => 'Trädgård',
                'name_en' => 'Garden',
                'keywords' => ['trädgård', 'garden', 'utomhus', 'gräsmatta'],
                'children' => [
                    ['slug' => 'garden-lawnmower', 'name_sv' => 'Gräsklippare', 'name_en' => 'Lawnmower', 'keywords' => ['gräsklippare', 'lawnmower', 'robotgräsklippare', 'åkgräsklippare']],
                    ['slug' => 'garden-tools', 'name_sv' => 'Trädgårdsredskap', 'name_en' => 'Garden Tools', 'keywords' => ['trädgårdsredskap', 'spade', 'räfsa', 'kratta', 'sekatör', 'trädgårdssax']],
                    ['slug' => 'garden-pots', 'name_sv' => 'Krukor', 'name_en' => 'Pots', 'keywords' => ['kruka', 'pot', 'blomlåda', 'planteringslåda', 'ampel']],
                    ['slug' => 'garden-grill', 'name_sv' => 'Grill', 'name_en' => 'Grill', 'keywords' => ['grill', 'bbq', 'kolgrill', 'gasolsgrill', 'smoker']],
                    ['slug' => 'garden-pool', 'name_sv' => 'Pool & Bad', 'name_en' => 'Pool', 'keywords' => ['pool', 'badtunna', 'uppblåsbar pool', 'trädgårdspool']],
                    ['slug' => 'garden-greenhouse', 'name_sv' => 'Växthus', 'name_en' => 'Greenhouse', 'keywords' => ['växthus', 'greenhouse', 'drivhus', 'pallkrage']],
                ],
            ],

            // ==================== VERKTYG ====================
            [
                'slug' => 'tools',
                'name_sv' => 'Verktyg',
                'name_en' => 'Tools',
                'keywords' => ['verktyg', 'tools', 'bygga', 'renovera'],
                'children' => [
                    ['slug' => 'tools-power', 'name_sv' => 'Elverktyg', 'name_en' => 'Power Tools', 'keywords' => ['elverktyg', 'power tools', 'borrmaskin', 'skruvdragare', 'sticksåg', 'cirkelsåg', 'slipmaskin']],
                    ['slug' => 'tools-hand', 'name_sv' => 'Handverktyg', 'name_en' => 'Hand Tools', 'keywords' => ['handverktyg', 'hand tools', 'hammare', 'skruvmejsel', 'tång', 'vattenpass', 'måttband']],
                    ['slug' => 'tools-workbench', 'name_sv' => 'Arbetsbänk', 'name_en' => 'Workbench', 'keywords' => ['arbetsbänk', 'workbench', 'verktygsskåp', 'verktygslåda']],
                    ['slug' => 'tools-ladder', 'name_sv' => 'Stege', 'name_en' => 'Ladder', 'keywords' => ['stege', 'ladder', 'trappstege', 'vikstege', 'ställning']],
                ],
            ],

            // ==================== MUSIKINSTRUMENT ====================
            [
                'slug' => 'music',
                'name_sv' => 'Musikinstrument',
                'name_en' => 'Musical Instruments',
                'keywords' => ['musik', 'instrument', 'music'],
                'children' => [
                    ['slug' => 'music-guitar', 'name_sv' => 'Gitarr', 'name_en' => 'Guitar', 'keywords' => ['gitarr', 'guitar', 'elgitarr', 'akustisk gitarr', 'bas', 'ukulele']],
                    ['slug' => 'music-piano', 'name_sv' => 'Piano', 'name_en' => 'Piano', 'keywords' => ['piano', 'keyboard', 'synthesizer', 'flygel', 'digitalpiano']],
                    ['slug' => 'music-drums', 'name_sv' => 'Trummor', 'name_en' => 'Drums', 'keywords' => ['trummor', 'drums', 'trumset', 'cymbaler', 'eltrummor']],
                    ['slug' => 'music-wind', 'name_sv' => 'Blåsinstrument', 'name_en' => 'Wind Instruments', 'keywords' => ['blåsinstrument', 'saxophone', 'trumpet', 'flöjt', 'klarinett', 'trombon']],
                    ['slug' => 'music-strings', 'name_sv' => 'Stråkinstrument', 'name_en' => 'String Instruments', 'keywords' => ['stråkinstrument', 'violin', 'fiol', 'cello', 'kontrabas']],
                ],
            ],

            // ==================== FORDON ====================
            [
                'slug' => 'vehicles',
                'name_sv' => 'Fordon',
                'name_en' => 'Vehicles',
                'keywords' => ['fordon', 'vehicle', 'transport'],
                'children' => [
                    ['slug' => 'vehicles-car-parts', 'name_sv' => 'Bildelar', 'name_en' => 'Car Parts', 'keywords' => ['bildelar', 'car parts', 'däck', 'fälgar', 'reservdelar', 'bilbatteri']],
                    ['slug' => 'vehicles-motorcycle', 'name_sv' => 'MC & Moped', 'name_en' => 'Motorcycle', 'keywords' => ['mc', 'moped', 'motorcykel', 'scooter', 'eu-moped']],
                    ['slug' => 'vehicles-boat', 'name_sv' => 'Båt & Marin', 'name_en' => 'Boat', 'keywords' => ['båt', 'boat', 'utombordare', 'segelbåt', 'båtmotor', 'marin']],
                    ['slug' => 'vehicles-trailer', 'name_sv' => 'Släp', 'name_en' => 'Trailer', 'keywords' => ['släp', 'trailer', 'släpvagn', 'båtsläp']],
                ],
            ],

            // ==================== BYGGMATERIAL ====================
            [
                'slug' => 'building',
                'name_sv' => 'Byggmaterial',
                'name_en' => 'Building Materials',
                'keywords' => ['bygg', 'byggmaterial', 'building', 'construction', 'renovering'],
                'children' => [
                    ['slug' => 'building-windows', 'name_sv' => 'Fönster', 'name_en' => 'Windows', 'keywords' => ['fönster', 'window', 'tvåluftsfönster', 'spröjs', 'glasruta', 'treglasfönster']],
                    ['slug' => 'building-doors', 'name_sv' => 'Dörrar', 'name_en' => 'Doors', 'keywords' => ['dörr', 'door', 'innerdörr', 'ytterdörr', 'glasdörr', 'skjutdörr']],
                    ['slug' => 'building-flooring', 'name_sv' => 'Golv', 'name_en' => 'Flooring', 'keywords' => ['golv', 'floor', 'parkett', 'laminat', 'klinker', 'golvplattor', 'kakel', 'trägolv']],
                    ['slug' => 'building-glass', 'name_sv' => 'Glas', 'name_en' => 'Glass', 'keywords' => ['glas', 'glass', 'glasparti', 'glasvägg', 'glasskiva', 'härdat glas']],
                    ['slug' => 'building-concrete', 'name_sv' => 'Betong & Bruk', 'name_en' => 'Concrete', 'keywords' => ['betong', 'concrete', 'bruk', 'cement', 'finja', 'finbetong', 'puts', 'byggmaterial', 'murbruk', 'fog']],
                    ['slug' => 'building-wood', 'name_sv' => 'Trävirke', 'name_en' => 'Timber', 'keywords' => ['trä', 'virke', 'timber', 'plank', 'bräda', 'regel', 'bjälke', 'träpanel']],
                    ['slug' => 'building-insulation', 'name_sv' => 'Isolering', 'name_en' => 'Insulation', 'keywords' => ['isolering', 'insulation', 'mineralull', 'cellplast', 'styrox', 'stenull']],
                    ['slug' => 'building-roofing', 'name_sv' => 'Tak', 'name_en' => 'Roofing', 'keywords' => ['tak', 'roofing', 'takpannor', 'plåttak', 'takpapp']],
                    ['slug' => 'building-tiles', 'name_sv' => 'Kakel & Klinker', 'name_en' => 'Tiles', 'keywords' => ['kakel', 'klinker', 'tiles', 'mosaik', 'väggkakel']],
                    ['slug' => 'building-paint', 'name_sv' => 'Färg & Tapeter', 'name_en' => 'Paint & Wallpaper', 'keywords' => ['färg', 'paint', 'tapet', 'lackfärg', 'grundfärg', 'väggfärg']],
                    ['slug' => 'building-plumbing', 'name_sv' => 'VVS', 'name_en' => 'Plumbing', 'keywords' => ['vvs', 'plumbing', 'rör', 'koppling', 'ventil', 'avlopp', 'vattenrör']],
                ],
            ],

            // ==================== KONST & HOBBY ====================
            [
                'slug' => 'art',
                'name_sv' => 'Konst & Hobby',
                'name_en' => 'Art & Hobby',
                'keywords' => ['konst', 'art', 'hobby', 'hantverk'],
                'children' => [
                    ['slug' => 'art-painting', 'name_sv' => 'Tavlor', 'name_en' => 'Paintings', 'keywords' => ['tavla', 'painting', 'konst', 'målning', 'oljemålning', 'affisch', 'poster']],
                    ['slug' => 'art-crafts', 'name_sv' => 'Hantverk', 'name_en' => 'Crafts', 'keywords' => ['hantverk', 'crafts', 'stickning', 'sömnad', 'symaskin', 'garn']],
                    ['slug' => 'art-antiques', 'name_sv' => 'Antikviteter', 'name_en' => 'Antiques', 'keywords' => ['antikviteter', 'antiques', 'vintage', 'retro', 'samlarprylar']],
                    ['slug' => 'art-collectibles', 'name_sv' => 'Samlarobjekt', 'name_en' => 'Collectibles', 'keywords' => ['samlarprylar', 'collectibles', 'frimärken', 'mynt', 'leksaksfigurer']],
                ],
            ],

            // ==================== ÖVRIGT ====================
            [
                'slug' => 'other',
                'name_sv' => 'Övrigt',
                'name_en' => 'Other',
                'keywords' => ['övrigt', 'other', 'diverse'],
                'children' => [
                    ['slug' => 'other-office', 'name_sv' => 'Kontor', 'name_en' => 'Office', 'keywords' => ['kontor', 'office', 'kontorsmaterial', 'pärmar', 'whiteboard']],
                    ['slug' => 'other-pet', 'name_sv' => 'Djurtillbehör', 'name_en' => 'Pet Supplies', 'keywords' => ['djur', 'pet', 'hundbädd', 'kattlåda', 'bur', 'akvarium', 'hundkoppel']],
                ],
            ],
        ];

        foreach ($categories as $category) {
            $this->createCategoryWithChildren($category);
        }
    }

    private function createCategoryWithChildren(array $data, ?int $parentId = null): void
    {
        $children = $data['children'] ?? [];
        unset($data['children']);

        $data['parent_id'] = $parentId;

        $category = EnvironmentalCategory::updateOrCreate(
            ['slug' => $data['slug']],
            $data
        );

        foreach ($children as $child) {
            $this->createCategoryWithChildren($child, $category->id);
        }
    }

    private function createFactors(): void
    {
        // Get source references
        $ivlSecondHand = EnvironmentalSource::where('slug', 'ivl-second-hand-effect-2020')->first();
        $ivlInrego = EnvironmentalSource::where('slug', 'ivl-inrego-it-2020')->first();
        $naturskydd = EnvironmentalSource::where('slug', 'naturskyddsforeningen-2021')->first();
        $naturvardsverket = EnvironmentalSource::where('slug', 'naturvardsverket-textil-2018')->first();
        $blocketIvl = EnvironmentalSource::where('slug', 'blocket-ivl-begagnateffekten-2019')->first();
        $carbonfact = EnvironmentalSource::where('slug', 'carbonfact-2024')->first();
        $furnitureLca = EnvironmentalSource::where('slug', 'scientific-reports-furniture-2024')->first();

        // ==================== MÖBLER - Naturskyddsföreningen ====================
        $this->createFurnitureFactors($naturskydd, $furnitureLca);

        // ==================== IT/ELEKTRONIK - IVL/Inrego ====================
        $this->createElectronicsFactors($ivlInrego, $blocketIvl);

        // ==================== KLÄDER - Carbonfact & IVL ====================
        $this->createClothingFactors($carbonfact, $ivlSecondHand, $naturvardsverket);

        // ==================== VÄSKOR - Carbonfact ====================
        $this->createBagFactors($carbonfact);

        // ==================== SPORT & FRITID ====================
        $this->createSportsFactors($blocketIvl);

        // ==================== BARN & BABY ====================
        $this->createBabyFactors($blocketIvl);

        // ==================== LEKSAKER ====================
        $this->createToyFactors($ivlSecondHand);

        // ==================== BÖCKER & MEDIA ====================
        $this->createBookFactors($ivlSecondHand);

        // ==================== HUSHÅLL ====================
        $this->createHouseholdFactors($naturskydd, $blocketIvl);

        // ==================== TRÄDGÅRD ====================
        $this->createGardenFactors($blocketIvl);

        // ==================== VERKTYG ====================
        $this->createToolFactors($blocketIvl);

        // ==================== MUSIKINSTRUMENT ====================
        $this->createMusicFactors($blocketIvl);

        // ==================== FORDON ====================
        $this->createVehicleFactors($blocketIvl);

        // ==================== BYGGMATERIAL ====================
        $this->createBuildingFactors($blocketIvl);

        // ==================== KONST & HOBBY ====================
        $this->createArtFactors($blocketIvl);
    }

    private function createFurnitureFactors($naturskydd, $furnitureLca): void
    {
        $factors = [
            ['slug' => 'furniture-sofa', 'co2' => 260, 'waste' => 530, 'savings' => 88],
            ['slug' => 'furniture-armchair', 'co2' => 74, 'waste' => 144, 'savings' => 96],
            ['slug' => 'furniture-office-chair', 'co2' => 55, 'savings' => 87],
            ['slug' => 'furniture-chair', 'co2' => 16, 'savings' => 87], // Updated from research
            ['slug' => 'furniture-stool', 'co2' => 12, 'savings' => 85],
            ['slug' => 'furniture-bench', 'co2' => 25, 'savings' => 85],
            ['slug' => 'furniture-dining-table', 'co2' => 85, 'savings' => 87],
            ['slug' => 'furniture-coffee-table', 'co2' => 55, 'savings' => 85],
            ['slug' => 'furniture-desk', 'co2' => 65, 'savings' => 87],
            ['slug' => 'furniture-side-table', 'co2' => 25, 'savings' => 85],
            ['slug' => 'furniture-console', 'co2' => 35, 'savings' => 85],
            ['slug' => 'furniture-bookshelf', 'co2' => 45, 'savings' => 88],
            ['slug' => 'furniture-wardrobe', 'co2' => 120, 'savings' => 88],
            ['slug' => 'furniture-dresser', 'co2' => 60, 'savings' => 88],
            ['slug' => 'furniture-cabinet', 'co2' => 55, 'savings' => 88],
            ['slug' => 'furniture-shelf', 'co2' => 20, 'savings' => 85],
            ['slug' => 'furniture-bed', 'co2' => 260, 'waste' => 820, 'savings' => 88],
            ['slug' => 'furniture-mattress', 'co2' => 150, 'savings' => 85],
            ['slug' => 'furniture-bunk-bed', 'co2' => 180, 'savings' => 88],
            ['slug' => 'furniture-kitchen-cabinet', 'co2' => 274, 'waste' => 320, 'savings' => 92],
            ['slug' => 'furniture-kitchen-island', 'co2' => 100, 'savings' => 88],
            ['slug' => 'furniture-outdoor-table', 'co2' => 60, 'savings' => 85],
            ['slug' => 'furniture-outdoor-chair', 'co2' => 25, 'savings' => 85],
            ['slug' => 'furniture-outdoor-sofa', 'co2' => 120, 'savings' => 85],
            ['slug' => 'furniture-parasol', 'co2' => 30, 'savings' => 80],
        ];

        foreach ($factors as $f) {
            $this->createFactor($f['slug'], [
                'source_id' => $naturskydd?->id,
                'co2_new_kg' => $f['co2'],
                'co2_savings_percent' => $f['savings'],
                'waste_new_kg' => $f['waste'] ?? null,
                'source_name' => 'Naturskyddsföreningen',
                'source_report' => 'Andra hand i första hand',
                'source_url' => 'https://cdn.naturskyddsforeningen.se/uploads/2021/09/29164251/Andra-hand-i-forsta-hand-klar.pdf',
                'source_publication_date' => '2021-09-29',
                'source_methodology' => 'LCA livscykelanalys',
                'is_verified' => true,
                'verified_by' => 'Naturskyddsföreningen',
                'verified_at' => '2021-09-29',
            ]);
        }
    }

    private function createElectronicsFactors($ivlInrego, $blocketIvl): void
    {
        // IT Equipment - IVL/Inrego
        $itFactors = [
            ['slug' => 'electronics-laptop', 'co2' => 280],
            ['slug' => 'electronics-desktop', 'co2' => 350],
            ['slug' => 'electronics-monitor', 'co2' => 520],
            ['slug' => 'electronics-tablet', 'co2' => 120],
            ['slug' => 'electronics-keyboard', 'co2' => 15],
            ['slug' => 'electronics-mouse', 'co2' => 8],
            ['slug' => 'electronics-smartphone', 'co2' => 70],
            ['slug' => 'electronics-smartwatch', 'co2' => 25],
            ['slug' => 'electronics-printer', 'co2' => 80],
        ];

        foreach ($itFactors as $f) {
            $this->createFactor($f['slug'], [
                'source_id' => $ivlInrego?->id,
                'co2_new_kg' => $f['co2'],
                'co2_savings_percent' => 95,
                'source_name' => 'IVL Svenska Miljöinstitutet & Inrego',
                'source_report' => 'Klimatfördelar med återbruk av IT-utrustning',
                'source_url' => 'https://inrego.com/our-calculation-model',
                'source_publication_date' => '2020-03-30',
                'source_methodology' => 'LCA enligt ISO 14040-44, komponentnivå',
                'is_verified' => true,
                'verified_by' => 'IVL Svenska Miljöinstitutet',
                'verified_at' => '2020-03-30',
            ]);
        }

        // Appliances - Blocket/IVL
        $applianceFactors = [
            ['slug' => 'electronics-fridge', 'co2' => 350],
            ['slug' => 'electronics-freezer', 'co2' => 280],
            ['slug' => 'electronics-washing-machine', 'co2' => 300],
            ['slug' => 'electronics-dryer', 'co2' => 280],
            ['slug' => 'electronics-dishwasher', 'co2' => 250],
            ['slug' => 'electronics-oven', 'co2' => 200],
            ['slug' => 'electronics-microwave', 'co2' => 100],
            ['slug' => 'electronics-tv', 'co2' => 350],
            ['slug' => 'electronics-speaker', 'co2' => 40],
            ['slug' => 'electronics-headphones', 'co2' => 15],
            ['slug' => 'electronics-camera', 'co2' => 80],
            ['slug' => 'electronics-projector', 'co2' => 120],
            ['slug' => 'electronics-vacuum', 'co2' => 60],
            ['slug' => 'electronics-coffee-machine', 'co2' => 50],
            ['slug' => 'electronics-blender', 'co2' => 25],
            ['slug' => 'electronics-toaster', 'co2' => 15],
            ['slug' => 'electronics-iron', 'co2' => 20],
            ['slug' => 'electronics-console', 'co2' => 100],
            ['slug' => 'electronics-vr', 'co2' => 60],
        ];

        foreach ($applianceFactors as $f) {
            $this->createFactor($f['slug'], [
                'source_id' => $blocketIvl?->id,
                'co2_new_kg' => $f['co2'],
                'co2_savings_percent' => 90,
                'source_name' => 'IVL Svenska Miljöinstitutet / Blocket',
                'source_report' => 'Begagnathandelns klimatnytta',
                'source_url' => 'https://www.ivl.se/download/18.40a6040e17affadfb81c0f/1627976709962/Beg.handel_klimatnytta_rapport.pdf',
                'source_publication_date' => '2019-12-03',
                'source_methodology' => 'LCA enligt ISO 14040-44',
                'is_verified' => true,
                'verified_by' => 'IVL Svenska Miljöinstitutet',
                'verified_at' => '2019-12-03',
            ]);
        }
    }

    private function createClothingFactors($carbonfact, $ivlSecondHand, $naturvardsverket): void
    {
        // Carbonfact data - comprehensive fashion database
        $clothingFactors = [
            // Tops
            ['slug' => 'clothing-tshirt', 'co2' => 10.6, 'water' => 2700],
            ['slug' => 'clothing-shirt', 'co2' => 12.0],
            ['slug' => 'clothing-sweater', 'co2' => 19.0],
            ['slug' => 'clothing-cardigan', 'co2' => 27.0],
            ['slug' => 'clothing-tank-top', 'co2' => 6.9],
            ['slug' => 'clothing-blouse', 'co2' => 11.0],
            // Bottoms
            ['slug' => 'clothing-jeans', 'co2' => 16.3, 'water' => 8000],
            ['slug' => 'clothing-pants', 'co2' => 27.5],
            ['slug' => 'clothing-skirt', 'co2' => 11.2],
            ['slug' => 'clothing-shorts', 'co2' => 10.0],
            ['slug' => 'clothing-leggings', 'co2' => 6.2],
            // Outerwear
            ['slug' => 'clothing-jacket', 'co2' => 29.7],
            ['slug' => 'clothing-coat', 'co2' => 35.0],
            ['slug' => 'clothing-fleece', 'co2' => 18.0],
            ['slug' => 'clothing-vest', 'co2' => 21.0],
            ['slug' => 'clothing-raincoat', 'co2' => 25.0],
            // Dresses & Suits
            ['slug' => 'clothing-dress', 'co2' => 14.2],
            ['slug' => 'clothing-jumpsuit', 'co2' => 20.0],
            ['slug' => 'clothing-suit', 'co2' => 45.0],
            // Underwear
            ['slug' => 'clothing-underwear-general', 'co2' => 5.0],
            ['slug' => 'clothing-socks', 'co2' => 1.8],
            ['slug' => 'clothing-pajamas', 'co2' => 13.5],
            // Sportswear
            ['slug' => 'clothing-sport-top', 'co2' => 8.0],
            ['slug' => 'clothing-sport-pants', 'co2' => 12.0],
            ['slug' => 'clothing-swimwear', 'co2' => 4.9],
            ['slug' => 'clothing-wetsuit', 'co2' => 77.3],
            // Shoes
            ['slug' => 'clothing-shoes-general', 'co2' => 27.2],
            ['slug' => 'clothing-sneakers', 'co2' => 12.1],
            ['slug' => 'clothing-boots', 'co2' => 80.0],
            ['slug' => 'clothing-sandals', 'co2' => 15.0],
            ['slug' => 'clothing-heels', 'co2' => 62.4],
            ['slug' => 'clothing-loafers', 'co2' => 68.3],
            // Accessories
            ['slug' => 'clothing-hat', 'co2' => 5.0],
            ['slug' => 'clothing-scarf', 'co2' => 8.6],
            ['slug' => 'clothing-gloves', 'co2' => 4.7],
            ['slug' => 'clothing-belt', 'co2' => 11.2],
            ['slug' => 'clothing-tie', 'co2' => 4.3],
            ['slug' => 'clothing-sunglasses', 'co2' => 5.5],
        ];

        foreach ($clothingFactors as $f) {
            $this->createFactor($f['slug'], [
                'source_id' => $carbonfact?->id,
                'co2_new_kg' => $f['co2'],
                'co2_savings_percent' => 95,
                'water_new_liters' => $f['water'] ?? null,
                'water_savings_percent' => isset($f['water']) ? 95 : null,
                'source_name' => 'Carbonfact',
                'source_report' => 'Carbon Footprint of Fashion Products',
                'source_url' => 'https://www.carbonfact.com/carbon-footprint',
                'source_publication_date' => '2024-01-01',
                'source_methodology' => 'LCA enligt ISO 14040-44, produktspecifik',
                'is_verified' => true,
                'verified_by' => 'Carbonfact / Peer-reviewed LCA studies',
                'verified_at' => '2024-01-01',
            ]);
        }
    }

    private function createBagFactors($carbonfact): void
    {
        $bagFactors = [
            ['slug' => 'bags-handbag', 'co2' => 11.8],
            ['slug' => 'bags-backpack', 'co2' => 15.0],
            ['slug' => 'bags-suitcase', 'co2' => 45.0],
            ['slug' => 'bags-wallet', 'co2' => 6.8],
            ['slug' => 'bags-laptop-bag', 'co2' => 18.0],
            ['slug' => 'bags-sports-bag', 'co2' => 20.0],
        ];

        foreach ($bagFactors as $f) {
            $this->createFactor($f['slug'], [
                'source_id' => $carbonfact?->id,
                'co2_new_kg' => $f['co2'],
                'co2_savings_percent' => 90,
                'source_name' => 'Carbonfact',
                'source_report' => 'Carbon Footprint of Fashion Products',
                'source_url' => 'https://www.carbonfact.com/carbon-footprint',
                'source_publication_date' => '2024-01-01',
                'source_methodology' => 'LCA enligt ISO 14040-44',
                'is_verified' => true,
                'verified_by' => 'Carbonfact',
                'verified_at' => '2024-01-01',
            ]);
        }
    }

    private function createSportsFactors($blocketIvl): void
    {
        $sportsFactors = [
            ['slug' => 'sports-bicycle', 'co2' => 100],
            ['slug' => 'sports-ebike', 'co2' => 134],
            ['slug' => 'sports-skis', 'co2' => 28], // Updated from research
            ['slug' => 'sports-snowboard', 'co2' => 30],
            ['slug' => 'sports-skating', 'co2' => 25],
            ['slug' => 'sports-inline', 'co2' => 30],
            ['slug' => 'sports-skateboard', 'co2' => 15],
            ['slug' => 'sports-athletics', 'co2' => 40],
            ['slug' => 'sports-balls', 'co2' => 5],
            ['slug' => 'sports-golf', 'co2' => 80],
            ['slug' => 'sports-tennis', 'co2' => 20],
            ['slug' => 'sports-fitness', 'co2' => 60],
            ['slug' => 'sports-camping', 'co2' => 50],
            ['slug' => 'sports-hiking', 'co2' => 30],
            ['slug' => 'sports-water', 'co2' => 80],
            ['slug' => 'sports-fishing', 'co2' => 25],
            ['slug' => 'sports-hunting', 'co2' => 40],
            ['slug' => 'sports-equestrian', 'co2' => 60],
            ['slug' => 'sports-climbing', 'co2' => 35],
        ];

        foreach ($sportsFactors as $f) {
            $this->createFactor($f['slug'], [
                'source_id' => $blocketIvl?->id,
                'co2_new_kg' => $f['co2'],
                'co2_savings_percent' => 90,
                'source_name' => 'IVL Svenska Miljöinstitutet / Blocket',
                'source_report' => 'Begagnathandelns klimatnytta',
                'source_url' => 'https://begagnateffekten.se/',
                'source_publication_date' => '2019-12-03',
                'source_methodology' => 'LCA enligt ISO 14040-44',
                'is_verified' => true,
                'verified_by' => 'IVL Svenska Miljöinstitutet',
                'verified_at' => '2019-12-03',
            ]);
        }
    }

    private function createBabyFactors($blocketIvl): void
    {
        $babyFactors = [
            ['slug' => 'baby-stroller', 'co2' => 100], // Research shows 60-321 kg
            ['slug' => 'baby-car-seat', 'co2' => 50],
            ['slug' => 'baby-crib', 'co2' => 80],
            ['slug' => 'baby-high-chair', 'co2' => 30],
            ['slug' => 'baby-carrier', 'co2' => 15],
            ['slug' => 'baby-playpen', 'co2' => 40],
            ['slug' => 'baby-changing-table', 'co2' => 45],
        ];

        foreach ($babyFactors as $f) {
            $this->createFactor($f['slug'], [
                'source_id' => $blocketIvl?->id,
                'co2_new_kg' => $f['co2'],
                'co2_savings_percent' => 92,
                'source_name' => 'IVL Svenska Miljöinstitutet / Blocket',
                'source_report' => 'Begagnathandelns klimatnytta',
                'source_url' => 'https://begagnateffekten.se/',
                'source_publication_date' => '2019-12-03',
                'source_methodology' => 'LCA enligt ISO 14040-44',
                'is_verified' => true,
                'verified_by' => 'IVL Svenska Miljöinstitutet',
                'verified_at' => '2019-12-03',
            ]);
        }
    }

    private function createToyFactors($ivlSecondHand): void
    {
        $toyFactors = [
            ['slug' => 'toys-plastic', 'co2' => 6],
            ['slug' => 'toys-soft', 'co2' => 4],
            ['slug' => 'toys-games', 'co2' => 3],
            ['slug' => 'toys-wooden', 'co2' => 5],
            ['slug' => 'toys-outdoor', 'co2' => 40],
            ['slug' => 'toys-rc', 'co2' => 15],
        ];

        foreach ($toyFactors as $f) {
            $this->createFactor($f['slug'], [
                'source_id' => $ivlSecondHand?->id,
                'co2_new_kg' => $f['co2'],
                'co2_savings_percent' => 90,
                'source_name' => 'IVL Svenska Miljöinstitutet',
                'source_report' => 'Second Hand Effect Report',
                'source_url' => 'https://www.adevinta.com/news/second-hand-effect-report2018/',
                'source_publication_date' => '2020-06-05',
                'source_methodology' => 'LCA enligt ISO 14040-44',
                'is_verified' => true,
                'verified_by' => 'IVL Svenska Miljöinstitutet',
                'verified_at' => '2020-06-05',
            ]);
        }
    }

    private function createBookFactors($ivlSecondHand): void
    {
        $bookFactors = [
            ['slug' => 'books-paperback', 'co2' => 2, 'water' => 150],
            ['slug' => 'books-vinyl', 'co2' => 3],
            ['slug' => 'books-cd', 'co2' => 1],
        ];

        foreach ($bookFactors as $f) {
            $this->createFactor($f['slug'], [
                'source_id' => $ivlSecondHand?->id,
                'co2_new_kg' => $f['co2'],
                'co2_savings_percent' => 95,
                'water_new_liters' => $f['water'] ?? null,
                'water_savings_percent' => isset($f['water']) ? 95 : null,
                'source_name' => 'IVL Svenska Miljöinstitutet',
                'source_report' => 'Second Hand Effect Report',
                'source_url' => 'https://www.adevinta.com/news/second-hand-effect-report2018/',
                'source_publication_date' => '2020-06-05',
                'source_methodology' => 'LCA enligt ISO 14040-44',
                'is_verified' => true,
                'verified_by' => 'IVL Svenska Miljöinstitutet',
                'verified_at' => '2020-06-05',
            ]);
        }
    }

    private function createHouseholdFactors($naturskydd, $blocketIvl): void
    {
        // Hemtextil from Naturskyddsföreningen
        $this->createFactor('household-textiles', [
            'source_id' => $naturskydd?->id,
            'co2_new_kg' => 110,
            'co2_savings_percent' => 97,
            'waste_new_kg' => 344,
            'source_name' => 'Naturskyddsföreningen',
            'source_report' => 'Andra hand i första hand',
            'source_url' => 'https://cdn.naturskyddsforeningen.se/uploads/2021/09/29164251/Andra-hand-i-forsta-hand-klar.pdf',
            'source_publication_date' => '2021-09-29',
            'source_methodology' => 'LCA livscykelanalys',
            'is_verified' => true,
            'verified_by' => 'Naturskyddsföreningen',
            'verified_at' => '2021-09-29',
        ]);

        $householdFactors = [
            ['slug' => 'household-kitchenware', 'co2' => 15],
            ['slug' => 'household-decor', 'co2' => 10],
            ['slug' => 'household-lamps', 'co2' => 20],
            ['slug' => 'household-electrical', 'co2' => 5],
            ['slug' => 'household-bathroom', 'co2' => 40],
            ['slug' => 'household-cleaning', 'co2' => 15],
        ];

        foreach ($householdFactors as $f) {
            $this->createFactor($f['slug'], [
                'source_id' => $blocketIvl?->id,
                'co2_new_kg' => $f['co2'],
                'co2_savings_percent' => 85,
                'source_name' => 'IVL Svenska Miljöinstitutet / Blocket',
                'source_report' => 'Begagnathandelns klimatnytta',
                'source_url' => 'https://begagnateffekten.se/',
                'source_publication_date' => '2019-12-03',
                'source_methodology' => 'LCA enligt ISO 14040-44',
                'is_verified' => true,
                'verified_by' => 'IVL Svenska Miljöinstitutet',
                'verified_at' => '2019-12-03',
            ]);
        }
    }

    private function createGardenFactors($blocketIvl): void
    {
        $gardenFactors = [
            ['slug' => 'garden-lawnmower', 'co2' => 150],
            ['slug' => 'garden-tools', 'co2' => 15],
            ['slug' => 'garden-pots', 'co2' => 8],
            ['slug' => 'garden-grill', 'co2' => 80],
            ['slug' => 'garden-pool', 'co2' => 100],
            ['slug' => 'garden-greenhouse', 'co2' => 200],
        ];

        foreach ($gardenFactors as $f) {
            $this->createFactor($f['slug'], [
                'source_id' => $blocketIvl?->id,
                'co2_new_kg' => $f['co2'],
                'co2_savings_percent' => 88,
                'source_name' => 'IVL Svenska Miljöinstitutet / Blocket',
                'source_report' => 'Begagnathandelns klimatnytta',
                'source_url' => 'https://begagnateffekten.se/',
                'source_publication_date' => '2019-12-03',
                'source_methodology' => 'LCA enligt ISO 14040-44',
                'is_verified' => true,
                'verified_by' => 'IVL Svenska Miljöinstitutet',
                'verified_at' => '2019-12-03',
            ]);
        }
    }

    private function createToolFactors($blocketIvl): void
    {
        $toolFactors = [
            ['slug' => 'tools-power', 'co2' => 40],
            ['slug' => 'tools-hand', 'co2' => 10],
            ['slug' => 'tools-workbench', 'co2' => 60],
            ['slug' => 'tools-ladder', 'co2' => 25],
        ];

        foreach ($toolFactors as $f) {
            $this->createFactor($f['slug'], [
                'source_id' => $blocketIvl?->id,
                'co2_new_kg' => $f['co2'],
                'co2_savings_percent' => 88,
                'source_name' => 'IVL Svenska Miljöinstitutet / Blocket',
                'source_report' => 'Begagnathandelns klimatnytta',
                'source_url' => 'https://begagnateffekten.se/',
                'source_publication_date' => '2019-12-03',
                'source_methodology' => 'LCA enligt ISO 14040-44',
                'is_verified' => true,
                'verified_by' => 'IVL Svenska Miljöinstitutet',
                'verified_at' => '2019-12-03',
            ]);
        }
    }

    private function createMusicFactors($blocketIvl): void
    {
        $musicFactors = [
            ['slug' => 'music-guitar', 'co2' => 35],
            ['slug' => 'music-piano', 'co2' => 400],
            ['slug' => 'music-drums', 'co2' => 150],
            ['slug' => 'music-wind', 'co2' => 25],
            ['slug' => 'music-strings', 'co2' => 30],
        ];

        foreach ($musicFactors as $f) {
            $this->createFactor($f['slug'], [
                'source_id' => $blocketIvl?->id,
                'co2_new_kg' => $f['co2'],
                'co2_savings_percent' => 90,
                'source_name' => 'IVL Svenska Miljöinstitutet / Blocket',
                'source_report' => 'Begagnathandelns klimatnytta',
                'source_url' => 'https://begagnateffekten.se/',
                'source_publication_date' => '2019-12-03',
                'source_methodology' => 'LCA enligt ISO 14040-44',
                'is_verified' => true,
                'verified_by' => 'IVL Svenska Miljöinstitutet',
                'verified_at' => '2019-12-03',
            ]);
        }
    }

    private function createVehicleFactors($blocketIvl): void
    {
        $vehicleFactors = [
            ['slug' => 'vehicles-car-parts', 'co2' => 50],
            ['slug' => 'vehicles-motorcycle', 'co2' => 500],
            ['slug' => 'vehicles-boat', 'co2' => 1000],
            ['slug' => 'vehicles-trailer', 'co2' => 300],
        ];

        foreach ($vehicleFactors as $f) {
            $this->createFactor($f['slug'], [
                'source_id' => $blocketIvl?->id,
                'co2_new_kg' => $f['co2'],
                'co2_savings_percent' => 92,
                'source_name' => 'IVL Svenska Miljöinstitutet / Blocket',
                'source_report' => 'Begagnathandelns klimatnytta',
                'source_url' => 'https://begagnateffekten.se/',
                'source_publication_date' => '2019-12-03',
                'source_methodology' => 'LCA enligt ISO 14040-44',
                'is_verified' => true,
                'verified_by' => 'IVL Svenska Miljöinstitutet',
                'verified_at' => '2019-12-03',
            ]);
        }
    }

    private function createBuildingFactors($blocketIvl): void
    {
        $buildingFactors = [
            ['slug' => 'building-windows', 'co2' => 80],
            ['slug' => 'building-doors', 'co2' => 50],
            ['slug' => 'building-flooring', 'co2' => 15],
            ['slug' => 'building-glass', 'co2' => 100],
            ['slug' => 'building-concrete', 'co2' => 10],
            ['slug' => 'building-wood', 'co2' => 5],
            ['slug' => 'building-insulation', 'co2' => 8],
            ['slug' => 'building-roofing', 'co2' => 25],
            ['slug' => 'building-tiles', 'co2' => 12],
            ['slug' => 'building-paint', 'co2' => 5],
            ['slug' => 'building-plumbing', 'co2' => 15],
        ];

        foreach ($buildingFactors as $f) {
            $this->createFactor($f['slug'], [
                'source_id' => $blocketIvl?->id,
                'co2_new_kg' => $f['co2'],
                'co2_savings_percent' => 88,
                'source_name' => 'IVL Svenska Miljöinstitutet',
                'source_report' => 'Återbruk av byggmaterial',
                'source_url' => 'https://www.ivl.se/press/pressmeddelanden/2022-10-24-aterbruk-sparar-klimatet---aven-om-trafonstret-skickas-anda-till-kapstaden.html',
                'source_publication_date' => '2022-10-24',
                'source_methodology' => 'LCA enligt ISO 14040-44',
                'is_verified' => true,
                'verified_by' => 'IVL Svenska Miljöinstitutet',
                'verified_at' => '2022-10-24',
            ]);
        }
    }

    private function createArtFactors($blocketIvl): void
    {
        $artFactors = [
            ['slug' => 'art-painting', 'co2' => 8],
            ['slug' => 'art-crafts', 'co2' => 15],
            ['slug' => 'art-antiques', 'co2' => 50],
            ['slug' => 'art-collectibles', 'co2' => 5],
        ];

        foreach ($artFactors as $f) {
            $this->createFactor($f['slug'], [
                'source_id' => $blocketIvl?->id,
                'co2_new_kg' => $f['co2'],
                'co2_savings_percent' => 95,
                'source_name' => 'IVL Svenska Miljöinstitutet / Blocket',
                'source_report' => 'Begagnathandelns klimatnytta',
                'source_url' => 'https://begagnateffekten.se/',
                'source_publication_date' => '2019-12-03',
                'source_methodology' => 'LCA enligt ISO 14040-44',
                'is_verified' => true,
                'verified_by' => 'IVL Svenska Miljöinstitutet',
                'verified_at' => '2019-12-03',
            ]);
        }
    }

    private function createFactor(string $categorySlug, array $data): void
    {
        $category = EnvironmentalCategory::where('slug', $categorySlug)->first();

        if (!$category) {
            return;
        }

        $data['category_id'] = $category->id;
        $data['is_active'] = true;

        EnvironmentalFactor::updateOrCreate(
            ['category_id' => $category->id],
            $data
        );
    }
}
