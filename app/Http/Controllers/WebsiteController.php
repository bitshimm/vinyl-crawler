<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class WebsiteController extends Controller
{
    public function index()
    {
        return view('index');
        $this->fillLinks();
    }

    public function show()
    {
        return view('show');
    }
    public function export(Request $request)
    {
        // dump();
        dump($request->all());
        // return view('show');
    }

    public function fillLinks()
    {
        $link = 'https://vinylmarkt.ru/catalog/vinilovye_plastinki/';
        $html = file_get_contents($link);

        $crawler = new Crawler(null, $link);
        $crawler->addHtmlContent($html, 'UTF-8');

        $startPage = 1;
        $lastPage = (int) $crawler->filter('div.ajax_load.block > div.bottom_nav.block > div.module-pagination > div > a')->last()->text();

        unset($crawler, $html);

        $linksArr = [];

        for ($startPage = 1; $startPage <= 10; $startPage++) {
            $linkPage = $link . '?PAGEN_1=' . $startPage;
            $html = file_get_contents($linkPage);
            // Create new instance for parser.
            $crawler = new Crawler(null, $linkPage);
            $crawler->addHtmlContent($html, 'UTF-8');

            $catalogBlockAtPage = $crawler->filter('div.ajax_load.block > div.top_wrapper.row.margin0.show_un_props > div.catalog_block .item_block')->each(function ($node, $i) {
                $linkToItem = $node->filter('div.item_info.N > div.item_info--top_block > div.item-title > a')->attr('href');
                dump($linkToItem);
                return $linkToItem;
            });

            $linksArr = array_merge($linksArr, $catalogBlockAtPage);

            unset($crawler, $html, $linkPage, $catalogBlockAtPage);
        }

        // dd($linksArr);
    }
}
