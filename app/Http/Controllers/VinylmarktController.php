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
    public static $filesCounter = 0;

    public function show()
    {
        $products = Product::where('website', self::$domen)->get();
        return view('vinylmarkt.show', compact('products'));
    }

    public function export(Request $request)
    {
        $getFields = $request->fields;

        Product::selectRaw($getFields ? implode(',', $getFields) : '*')
            ->where('website', '=', self::$domen)
            ->where('tilda_uid', '!=', 0)
            ->orderBy('updated_at', 'desc')
            ->chunk(100, function ($products) {
                global $timestampMs;
                self::$filesCounter++;

                $products = $products->toArray();
                $theads = array_keys($products[0]);

                $date = Carbon::now()->toDateString();
                $filepath = 'temp_csv/' . self::$domen . '/' . self::$domen . '_' . $date . '_' . self::$filesCounter . '.csv';
                $publicDisk = Storage::disk('public');
                $archivePath = self::$domen . '/' . $date . '.zip';
                // dd(public_path('storage/' . $archivePath));
                $publicDisk->put($filepath, implode(';', $theads), 'public');
                foreach ($products as $product) {
                    $product['category'] = '"' .  $product['category'] . '"';
                    $publicDisk->append($filepath, implode(';', $product));
                }

                $zip = new ZipArchive();
                $zip->open($archivePath);
                $zip->open(public_path($archivePath), ZipArchive::CREATE);
                $zip->addFile(public_path('storage/' . $filepath), 'part_' . self::$filesCounter . '.csv');
                $zip->close();
                if ($publicDisk->exists($filepath)) {
                    $publicDisk->delete($filepath);
                }
                unset($date);

                // $handle = fopen(public_path($path . '/' . $filename), 'w+');
                // fputcsv($handle, $theads, ';');

                // foreach ($products as $product) {
                //     fputcsv($handle, $product, ';');
                // }

                // fclose($handle);
            });
        $date = Carbon::now()->toDateString();
        $archivePath = self::$domen . '/' . $date . '.zip';
        header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=$archivePath");
        header("Content-length: " . filesize($archivePath));
        header("Pragma: no-cache");
        header("Expires: 0");
        unset($date);
        readfile("$archivePath");
        return redirect()->route('vinylmarkt.show');
        dd('success');
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
                dd('?????????????????? ???????????? ???? ???????????????? ' . $currentPage);
            }
        }

        return redirect()->route('vinylmarkt.show')->with('successMsg', '???????????????????????????? ??????????????????');
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
                    if ($property[0] == '????????????' && is_numeric($property[1])) {
                        $product->tilda_uid = $property[1];
                    }
                }

                $photoArr = [];
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
                $product->seo_title = '?????????????????? ?????????????????? ' . $product->brand . ' - ???????????? ' . $product->title . ' | ????????????????-?????????????? NAVINILE.RU';
                $product->seo_descr = $product->title . ' - ???????????? ???????????? ' . $product->brand . ' ???? ????????????' . ' | ????????????????-?????????????? NAVINILE.RU | ?????????? ???? ??????.: +7 499 677-23-27';
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
        return redirect()->route('vinylmarkt.show')->with('successMsg', '??????????????????: ' . $counter . ' ??????????????');
    }
}
