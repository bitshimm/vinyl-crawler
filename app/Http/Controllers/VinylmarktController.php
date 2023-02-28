<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class VinylmarktController extends Controller
{
    public function fillLinks()
    {
        // dd();
        $mainLink = 'https://vinylmarkt.ru/catalog/vinilovye_plastinki/';
        $html = file_get_contents($mainLink);

        $crawler = new Crawler(null, $mainLink);
        $crawler->addHtmlContent($html, 'UTF-8');

        $startPage = 1;
        $lastPage = (int) $crawler->filter('div.module-pagination > div > a')->last()->text();

        unset($crawler, $html);

        $counter = 0;
        for ($startPage = 15; $startPage <= $lastPage; $startPage++) {
            try {
                $PaginationPage = $mainLink . '?PAGEN_1=' . $startPage;
                $html = file_get_contents($PaginationPage);
                $crawler = new Crawler(null, $PaginationPage);
                $crawler->addHtmlContent($html, 'UTF-8');

                $catalogBlockAtPage = $crawler->filter('div.ajax_load.block > div.top_wrapper.row.margin0.show_un_props > div.catalog_block .item_block')->each(function ($node, $i) {

                    $ProductRelativeLink = $node->filter('div.item_info.N > div.item_info--top_block > div.item-title > a')->attr('href');

                    $website_domen = 'vinylmarkt.ru';

                    Product::updateOrCreate(
                        [
                            'website' => $website_domen,
                            'product_url' => $ProductRelativeLink
                        ],
                    );

                    return $ProductRelativeLink;
                });

                unset($crawler, $html, $PaginationPage, $catalogBlockAtPage);
                $counter++;
                if ($counter % 100 == 0) {
                    sleep(100);
                }
            } catch (InvalidArgumentException $e) { // I guess its InvalidArgumentException in this case
                // Node list is empty
            }
        }
        dd('success');
    }

    public function updateProducts()
    {
        $products = Product::where('website', 'vinylmarkt.ru')->orderBy('updated_at', 'desc')->get();

        foreach ($products as $product) {

            $productHtml = file_get_contents('http://' . $product->website . $product->product_url);

            $crawler = new Crawler(null, $productHtml);
            $crawler->addHtmlContent($productHtml, 'UTF-8');

            /* brand */
            $product->brand = ucwords($crawler->filter('meta[itemprop=brand]')->attr('content'));

            /* description */
            $product->description = ucwords($crawler->filter('meta[itemprop=brand]')->attr('content'));

            /* category */
            $_category = explode('/', $crawler->filter('meta[itemprop=category]')->attr('content'));
            unset($_category[0]);
            $product->category = implode(';', $_category);

            /* title */
            $titleArr = explode('/', $crawler->filter('meta[itemprop=name]')->attr('content'));
            if (array_key_exists(1, $titleArr)) {
                $product->title = $titleArr[1];
            }

            /* text */
            $propertyArr = $crawler->filter('table.props_list tr')->each(function (Crawler $node, $i) {
                return $node->filter('.char_name')->text() . ' => ' . $node->filter('.char_value')->text();
            });
            foreach ($propertyArr as $property) {
                $property = explode(' => ', $property);
                $product->text .= '<p style=""font-size: 20px;""><span style=""font-weight: 400;"">' . $property[0] . ':</span><span> ' . $property[1] . '</span></p>';
            }


            dump($product->product_url);
            /* photo */
            if ($crawler->filter('div.slides ul li')) {
                $photoArr = $crawler->filter('div.slides ul li')->each(function (Crawler $node, $i) {
                    if ($node->filter('a')->count() > 0) {
                        return 'https://vinylmarkt.ru' . $node->filter('a')->attr('href');
                    }
                    return 'https://via.placeholder.com/150/FFFFFF/808080/?text=no+photo';
                });
                $product->photo = implode(' ', $photoArr);
            }


            /* seo */
            $product->seo_title = 'Виниловая пластинка ' . $product->brand . ' - альбом ' . $product->title . ' | Интернет-магазин NAVINILE.RU';
            $product->seo_descr = $product->title . ' - альбом группы ' . $product->brand . ' на виниле' . ' | Интернет-магазин NAVINILE.RU | Заказ оп тел.: +7 499 677-23-27';
            $product->seo_keywords = $product->title . ', ' . $product->brand;

            /* price */
            $product->price = (float) $crawler->filter('meta[itemprop=price]')->attr('content');


            /* video */
            $videoArr = $crawler->filter('table.video_table tbody tr')->each(function (Crawler $node, $i) {
                return $node->filter('iframe')->attr('src');
            });
            $product->video = implode(' ', $videoArr);


            /* video */
            $videoArr = $crawler->filter('table.video_table tbody tr')->each(function (Crawler $node, $i) {
                return $node->filter('iframe')->attr('src');
            });
            $product->video = implode(' ', $videoArr);


            // dd($product);
            $product->update();
        }
        dd($products);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
