<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use ZipArchive;

class VinylmarktController extends Controller
{
    public static $domen = 'vinylmarkt.ru';

    public function show()
    {
        // phpinfo();die();
        $products = Product::where('website', self::$domen)->get();
        return view('vinylmarkt.show', compact('products'));
    }

    public function export(Request $request)
    {
        header_remove();
        $getFields = $request->fields;

        $products = Product::selectRaw($getFields ? implode(',', $getFields) : '*')
            ->where('website', '=', self::$domen)
            ->where('tilda_uid', '!=', 0)
            ->whereNotNull('photo')
            ->orderBy('updated_at', 'desc')
            ->get();

        $products = collect($products->toArray());

        $date = Carbon::now()->toDateString();
        $publicDisk = Storage::disk('public');
        $filesDirectory = self::$domen . '/' . $date;
        $archivePath = self::$domen . '/' . $date . '.zip';
        $filesCounter = 0;

        if (Storage::exists($archivePath)) {
            Storage::delete($archivePath);
        }

        $zip = new ZipArchive();
        $zip->open(public_path('storage/' . $archivePath), ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->close();

        foreach ($products->chunk(400) as $chunk) {
            $filesCounter++;

            $theads = array_keys($products[0]);

            $filepath = $filesDirectory . '/' . $filesCounter . '.csv';

            $publicDisk->put($filepath, implode(';', $theads), 'public');

            foreach ($chunk as $product) {
                if (isset($product['category'])) {
                    $product['category'] = '"' .  $product['category'] . '"';
                }
                $product['text'] = '"' . $product['text'] . '"';
                $publicDisk->append($filepath, implode(';', $product));
            }

            $zip = new ZipArchive();
            $zip->open(public_path('storage/' . $archivePath), ZipArchive::CREATE);
            $zip->addFile('storage/' . $filepath);
            $zip->close();
        }

        Storage::deleteDirectory($filesDirectory);

        unset($date);

        return Storage::download($archivePath);
    }

    public function fillLinks(Request $request)
    {
        $mainLink = 'https://vinylmarkt.ru/catalog/vinilovye_plastinki/';
        $html = file_get_contents($mainLink);

        $crawler = new Crawler(null, $mainLink);
        $crawler->addHtmlContent($html, 'UTF-8');

        $currentPage = (int) $request->fill_from ? $request->fill_from : 1;
        if ($request->fill_to) {
            $lastPage = (int) $request->fill_to;
        } else {
            $lastPage = (int) $crawler->filter('div.module-pagination > div > a')->last()->text();
        }


        unset($crawler, $html);

        $counter = 0;

        for (; $currentPage <= $lastPage; $currentPage++) {
            $PaginationPage = $mainLink . '?PAGEN_1=' . $currentPage;
            if ($html = file_get_contents($PaginationPage)) {
                $crawler = new Crawler(null, $PaginationPage);
                $crawler->addHtmlContent($html, 'UTF-8');

                $catalogBlockAtPage = $crawler->filter('div.ajax_load.block > div.top_wrapper.row.margin0.show_un_props > div.catalog_block .item_block')->each(function ($node, $i) {

                    $ProductRelativeLink = $node->filter('div.item_info.N > div.item_info--top_block > div.item-title > a')->attr('href');

                    Product::updateOrCreate([
                        'website' => self::$domen,
                        'product_url' => $ProductRelativeLink
                    ]);

                    return $ProductRelativeLink;
                });
                unset($crawler, $html, $PaginationPage, $catalogBlockAtPage);

                $counter++;
                if ($counter % 100 == 0) {
                    sleep(100);
                }
            } else {
                dd('Появилась ошибка на странице ' . $currentPage);
            }
        }

        return redirect()->route('vinylmarkt.show')->with('successMsg', 'Идентификаторы обновлены');
    }

    public function updateProducts()
    {
        $products = Product::where('website', '=', self::$domen)
            ->where('tilda_uid', '=', 0)
            ->orderBy('updated_at', 'desc')->get();
        $counter = 0;
        foreach ($products as $product) {
            if ($productHtml = file_get_contents('http://' . $product->website . $product->product_url)) {
                $crawler = new Crawler(null, $productHtml);
                $crawler->addHtmlContent($productHtml, 'UTF-8');

                /* brand */
                if ($crawler->filter('meta[itemprop=brand]')->count()) {
                    $product->brand = ucwords($crawler->filter('meta[itemprop=brand]')->attr('content'));
                } else {
                    continue;
                }

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
                    if ($property[0] == 'Баркод' && is_numeric($property[1])) {
                        $product->tilda_uid = $property[1];
                    }
                }

                /* photo */
                $photoArr = [];
                if ($crawler->filter('div.slides ul li')->count()) {
                    $photoArr = $crawler->filter('div.slides ul li')->each(function (Crawler $node, $i) {
                        if ($node->filter('a')->count()) {
                            return 'https://vinylmarkt.ru' . $node->filter('a')->attr('href');
                        }
                        return '';
                    });
                    $product->photo = implode(' ', $photoArr);
                } else {
                    continue;
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

                $product->update();
                unset($productHtml, $crawler, $_category, $titleArr, $propertyArr, $photoArr, $videoArr);
                $counter++;
            }
        }
        return redirect()->route('vinylmarkt.show')->with('successMsg', 'Обновлено: ' . $counter . ' записей');
    }
}
