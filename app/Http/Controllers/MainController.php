<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\DomCrawler\Crawler;

class MainController extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function getAvailable()
    {
        return view('get-available');
    }
    public function getAvailableUpload(Request $request)
    {
        $providerPath = $request->file('provider')->store('getAvailableUploads', 'public');
        $tildaPath = $request->file('tilda')->store('getAvailableUploads', 'public');

        // $providerProdcuts = Excel::import(new ProductImport, $providerPath);
        // $tildaProducts = Excel::toArray(new ProductImport, $tildaPath)[0];
        // $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        // $reader->setReadDataOnly(true);
        // $spreadsheet = $reader->load(public_path(Storage::url($providerPath)));

        // $sheet = $spreadsheet->getActiveSheet();
        // $data = $sheet->toArray();
        // for ($i=1; $i < $sheet->getHighestDataRow(); $i++) {
        //     $data = [
        //         $sheet->getCell("A$i")->getValue(),
        //         $sheet->getCell("B$i")->getValue(),
        //         $sheet->getCell("C$i")->getValue(),
        //         $sheet->getCell("D$i")->getValue(),
        //         $sheet->getCell("E$i")->getValue(),
        //     ];

        //     // dump($data);
        // }
        // $spreadsheet->getActiveSheet()->getStyle('B2')
        // ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
        // $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        // $writer->save("05featuredemo.xlsx");
        // $data = $sheet->getCell('B8')->getValue();

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load(public_path(Storage::url($providerPath)));
        // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path(Storage::url($providerPath)));

        //change it
        $sheet = $spreadsheet->getActiveSheet();
        for ($i = 1; $i < $sheet->getHighestDataRow(); $i++) {
            // $data = [
            //     $sheet->getCell("A$i")->getValue(),
            //     $sheet->getCell("B$i")->getValue(),
            //     $sheet->getCell("C$i")->getValue(),
            //     $sheet->getCell("D$i")->getValue(),
            //     $sheet->getCell("E$i")->getValue(),
            // ];
            if ($i % 5 == 0) {
                $sheet->getStyle("A$i")
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_YELLOW);
            }
        }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save(public_path(Storage::url('yourspreadsheet.xlsx')));
        // return Storage::download('yourspreadsheet.xlsx');
        dd(storage_path());
        $tildaData = [];
        $providerData = [];

        // dd($data);
        // dd($tilda_products);
        foreach ($tilda_products as $product) {
            $code = (int) $product[2];
            $lastHash = $code;
            $tildaData[$lastHash] = $product;
            // dump($product[0]);
        }


        foreach ($provider_products as $product) {
            $code = (int) $product[4];
            $lastHash = $code;
            $providerData[$lastHash] = $product;
        }

        // dd($providerData);
        // $collection = Excel::toCollection(new ProductImport, 'provider_price2.xlsx');
        dd(array_intersect_key($tildaData, $providerData));
        // Excel::import(new ProductImport, 'provider+price.xlsx');
        dd($providerPath2);
    }
}
