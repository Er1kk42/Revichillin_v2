<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Flavor;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Ukážkové produkty e-shopu.
 *
 * Spúšťa sa z DatabaseSeeder (po číselníkoch) – pri prvom štarte Dockeru
 * automaticky cez "php artisan migrate --seed" (viď docker/entrypoint.sh).
 * Ručne: php artisan db:seed --class=ProductSeeder
 *
 * Bezpečné spustiť opakovane: produkt sa hľadá podľa názvu, takže existujúci
 * sa nevytvorí druhýkrát a príchute/kategórie sa len doplnia (nič sa neodoberie).
 */
class ProductSeeder extends Seeder
{
    /**
     * ZOZNAM PRODUKTOV – sem dopíš dáta.
     *
     * Kľúče jedného produktu:
     *  - name              (povinné) názov produktu, zároveň podľa neho seeder spozná,
     *                      či produkt už existuje
     *  - price             (povinné) cena v €, napr. 4.99
     *  - stock             (povinné) počet kusov na sklade
     *  - type              (povinné) názov typu, napr. 'Nikotínové vrecká', 'Elektronické cigarety',
     *                      'Tabak', 'Cigarety' (viď ProductTypeSeeder)
     *  - brand             názov značky, napr. 'VELO', 'Killa', 'ELF BAR' (viď BrandSeeder), alebo null
     *  - nicotine_strength obsah nikotínu v mg, alebo null (bez nikotínu)
     *  - description       popis, alebo null
     *  - image             názov súboru v public/img/products/, napr. 'KillaColdMint.png', alebo null
     *                      (súbor musí byť commitnutý v gite, inak na čistej inštalácii chýba)
     *  - flavors           zoznam názvov príchutí, napr. ['Mint'] – ak príchuť neexistuje, vytvorí sa
     *  - categories        zoznam názvov kategórií, napr. ['Novinky'] – ak neexistuje, vytvorí sa
     *
     * Ak typ alebo značka s daným názvom neexistuje, vytvorí sa tiež.
     * @var array<int, array<string, mixed>>
     */
    private array $products = [
        [
            'name' => 'Blu Bar Banana Ice',
            'price' => 7.5,
            'stock' => 50,
            'type' => 'Elektronické Cigarety',
            'brand' => 'Blu Bar',
            'nicotine_strength' => 20,
            'description' => 'Zaži jemne sladkú a krémovú chuť zrelého banánu, ktorú dopĺňa osviežujúci ľadový nádych pre vyvážený a chladivý zážitok.',
            'image' => 'BlubarBanana.png',
            'flavors' => ['Banana'], ['Ice'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Blu bar Blueberry',
            'price' => 7.5,
            'stock' => 50,
            'type' => 'Elektronické Cigarety',
            'brand' => 'Blu Bar',
            'nicotine_strength' => 20,
            'description' => 'Jednorazová elektronická cigareta blu bar je moderné a štýlové zariadenie, ktoré prináša zážitok z vapovania lepší ako kedykoľvek predtým v sladkej a zároveň trpkej príchuti čučoriedky.',
            'image' => 'BlubarBlueberry.png',
            'flavors' => ['Blueberry'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Blu Bar Grape Ice',
            'price' => 7.5,
            'stock' => 50,
            'type' => 'Elektronické Cigarety',
            'brand' => 'Blu Bar',
            'nicotine_strength' => 20,
            'description' => 'Jednorazová elektronická cigareta blu bar je moderné a štýlové zariadenie, ktoré prináša zážitok z vapovania lepší ako kedykoľvek predtým v skvelej príchuti hrozna so sviežim nádychom.',
            'image' => 'BlubarGrape.jpg',
            'flavors' => ['Grape'], ['Ice'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Killa Apple',
            'price' => 0,
            'stock' => 50,
            'type' => 'Nikotínové vrecká',
            'brand' => 'Killa',
            'nicotine_strength' => 12,
            'description' => 'Nikotínové vrecúška Killa Apple vám prinášajú sviežu a sladkú chuť šťavnatých jabĺk, ktoré osviežia vaše chuťové poháriky. Každý sáčok obsahuje 12 mg nikotínu, čo znamená rýchly a silný účinok.',
            'image' => 'KillaApple.png',
            'flavors' => ['Apple'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Killa Blueberry',
            'price' => 5.5,
            'stock' => 50,
            'type' => 'Nikotínové vrecká',
            'brand' => 'Killa',
            'nicotine_strength' => 16,
            'description' => 'Killa Blueberry Extra Strong 13,2 mg/vrecúško sú nikotínové vrecúška bez tabaku s čučoriedkovou príchuťou. Obsah nikotínu je 13,2 mg/vrecúško. Vrecúška majú formát Slim a balenie obsahuje 20 vrecúšok.',
            'image' => 'KillaBlueberry.png',
            'flavors' => ['Blueberry'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Killa Cola',
            'price' => 5.5,
            'stock' => 50,
            'type' => 'Nikotínové vrecká',
            'brand' => 'Killa',
            'nicotine_strength' => 16,
            'description' => 'Killa Cola od značky Killa ponúka klasickú chuť koly s výrazným sladkým a korenistým profilom. Chuť je sladká, jemne karamelizovaná a delikátne korenistá, s typickou kolovou príchuťou.',
            'image' => 'KillaCola.png',
            'flavors' => ['Cola'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Killa Cold Mint X',
            'price' => 5.5,
            'stock' => 50,
            'type' => 'Nikotínové vrecká',
            'brand' => 'Killa',
            'nicotine_strength' => 16,
            'description' => 'KILLA COLD X MINT Nikotínové sáčky s veľmi zaujímavou príchuťou mentolu v spojení s aromatickým a štipľavým zázvorom.',
            'image' => 'KillaColdMintX.png',
            'flavors' => ['Mint'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Killa Mini Mango Ice',
            'price' => 5.5,
            'stock' => 50,
            'type' => 'Nikotínové vrecká',
            'brand' => 'Killa',
            'nicotine_strength' => 16,
            'description' => 'Killa Mini Mango Ice sú nikotínové vrecúška, ktoré sa môžu pochváliť aj napriek svojej veľkosti silnou mangovou príchuťou. Prinášajú osviežujúcu vôňu a tropické pocity.',
            'image' => 'KillaMiniMangoIce.webp',
            'flavors' => ['Mango'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Kurwa Grape',
            'price' => 6,
            'stock' => 50,
            'type' => 'Nikotínové vrecká',
            'brand' => 'Kurwa',
            'nicotine_strength' => 12,
            'description' => 'Kurwa lahodné hroznové víno plné sladké a šťavnaté chuti.V balení je 20 vreciek.Obsah nikotinu 12 mg/vrecko.',
            'image' => 'KurwaGrape.png',
            'flavors' => ['Grape'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Kurwa Kiwi Apple',
            'price' => 6,
            'stock' => 50,
            'type' => 'Nikotínové vrecká',
            'brand' => 'Kurwa',
            'nicotine_strength' => 12,
            'description' => 'Kiwi Apple - intenzívna, šťavnatá a sladko-kyslá ovocná bomba. Chuť je veľmi sýta, verná a dopĺňa ju len jemný náznak chladivého efektu pre maximálnu sviežosť, bez prehnaného pálenia mentolu.',
            'image' => 'KurwaKiwiApple.png',
            'flavors' => ['Kiwi'], ['Apple'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Kurwa Mango Rassberry',
            'price' => 6,
            'stock' => 50,
            'type' => 'Nikotínové vrecká',
            'brand' => 'Kurwa',
            'nicotine_strength' => 12,
            'description' => 'Užite si nikotín bez fajčenia s nikotínovými vrecúškami Kurwa Collection. Výber unikátnych príchutí a rôznych úrovní intenzity vám umožní prispôsobiť zážitok podľa vašich preferencií. ',
            'image' => 'KurwaMangoRassbery.png',
            'flavors' => ['Mango'], ['Raspberry'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Pablo Ice Cold',
            'price' => 6.5,
            'stock' => 50,
            'type' => 'Nikotínové vrecká',
            'brand' => 'Pablo',
            'nicotine_strength' => 20,
            'description' => 'KILLA  Pablo je značka nikotínových vrecúšok, ktorá je známa svojimi veľmi silnými a intenzívnymi produktmi.',
            'image' => 'PabloIceCold.png',
            'flavors' => ['Ice'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Pablo Mini Ice Cold',
            'price' => 6,
            'stock' => 50,
            'type' => 'Nikotínové vrecká',
            'brand' => 'Pablo',
            'nicotine_strength' => 12,
            'description' => 'Lahodná chuť čerstvej mäty a neuveriteľná sila nikotínu! ',
            'image' => 'PabloMiniIceCold.png',
            'flavors' => ['Ice'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Pablo Peach Ice',
            'price' => 6.5,
            'stock' => 50,
            'type' => 'Nikotínové vrecká',
            'brand' => 'Pablo',
            'nicotine_strength' => 10,
            'description' => 'Pablo nikotínové vrecúška ponúkajú vyvážený zážitok pre tých, ktorí preferujú tradičný štýl nikotínu. Diskrétne a bez dymu, ideálne na každodenné použitie.',
            'image' => 'PabloPeachIce.png',
            'flavors' => ['Ice'], ['Peach'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Velo Citrus',
            'price' => 5.5,
            'stock' => 50,
            'type' => 'Nikotínové vrecká',
            'brand' => 'Velo',
            'nicotine_strength' => 1,
            'description' => 'Vyskúšajte nikotínové vrecúška s príchuťou citrus',
            'image' => 'VeloCitrus.png',
            'flavors' => ['Citrus'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Velo Crispy Pepermint',
            'price' => 6,
            'stock' => 50,
            'type' => 'Nikotínové vrecká',
            'brand' => 'Velo',
            'nicotine_strength' => 10,
            'description' => 'Objavte moderný spôsob, ako si vychutnať nikotín s VELO nikotínovými vrecúškami. Diskrétne, bez dymu a zápachu, ponúkajú čistý zážitok s pestrou škálou osviežujúcich príchutí. Ideálne pre tých, ktorí hľadajú pohodlie a štýl v každom momente.',
            'image' => 'VeloCrispyPepermint.png',
            'flavors' => ['Pepermint'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Velo Pepermint Storm',
            'price' => 6,
            'stock' => 50,
            'type' => 'Nikotínové vrecká',
            'brand' => 'Velo',
            'nicotine_strength' => 24,
            'description' => 'VELO 6 - Peppermint Storm X-Intense Slim ponúka sviežu chuť mentolu a krehkej mäty priepornej, čo vytvára nezabudnuteľný zážitok pre vaše chuťové poháriky.',
            'image' => 'VeloPepermintStorm.png',
            'flavors' => ['Pepermint'],
            'categories' => ['Novinky'],

        ],
        [
            'name' => 'Velo Purple Grape',
            'price' => 5.5,
            'stock' => 50,
            'type' => 'Nikotínové vrecká',
            'brand' => 'Velo',
            'nicotine_strength' => 12,
            'description' => 'VELO Purple Grape prináša svieže a živé chute šťavnatého červeného hrozna.',
            'image' => 'VeloPurpleGrape.png',
            'flavors' => ['Grape'],
            'categories' => ['Novinky'],

        ],
    ];




    public function run(): void
    {
        foreach ($this->products as $data) {
            // Upozornenie, ak obrázok v public/img/products neexistuje
            // (produkt sa aj tak vytvorí, len bez viditeľného obrázka).
            $image = $data['image'] ?? null;
            if ($image && ! file_exists(public_path('img/products/'.$image))) {
                $this->command?->warn("Obrázok '{$image}' pre produkt '{$data['name']}' neexistuje v public/img/products.");
            }

            // firstOrCreate: ak produkt s týmto názvom už je v DB, nechá ho tak,
            // inak ho vytvorí so zadanými hodnotami.
            $product = Product::firstOrCreate(
                ['name' => $data['name']],
                [
                    'price' => $data['price'],
                    'stock' => $data['stock'],
                    'description' => $data['description'] ?? null,
                    'image' => $image,
                    'nicotine_strength' => $data['nicotine_strength'] ?? null,
                    'product_type_id' => $this->lookup(ProductType::class, $data['type'])->id,
                    'brand_id' => isset($data['brand']) ? $this->lookup(Brand::class, $data['brand'])->id : null,
                ],
            );

            // M:N väzby – syncWithoutDetaching len pridá chýbajúce riadky do pivot tabuľky,
            // existujúce väzby (napr. pridané adminom vo Filamente) neodoberie.
            $product->flavors()->syncWithoutDetaching(
                collect($data['flavors'] ?? [])->map(fn (string $name) => $this->lookup(Flavor::class, $name)->id)
            );
            $product->categories()->syncWithoutDetaching(
                collect($data['categories'] ?? [])->map(fn (string $name) => $this->lookup(Category::class, $name)->id)
            );
        }
    }

    /**
     * Nájde záznam číselníka (typ, značka, príchuť, kategória) podľa slugu z názvu,
     * prípadne ho vytvorí. Napr. 'Nikotínové vrecká' -> slug 'nikotinove-vrecka'.
     *
     * @param  class-string<Model>  $model
     */
    private function lookup(string $model, string $name): Model
    {
        return $model::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
    }
}
