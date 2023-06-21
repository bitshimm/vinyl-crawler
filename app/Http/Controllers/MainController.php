<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\DomCrawler\Crawler;

class MainController extends Controller
{
    public static $lettersHash = [
        0 => 'A',
        1 => 'B',
        2 => 'C',
        3 => 'D',
        4 => 'E',
        5 => 'F',
        6 => 'G',
        7 => 'H',
        8 => 'I',
        9 => 'J',
        10 => 'K',
        11 => 'L',
        12 => 'M',
        13 => 'N',
    ];

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
        header_remove();

        $date = Carbon::now()->toDateString();
        $marginPercent = 0.2;

        $providerFilename = 'provider-' . $date . '.xlsx';
        $tildaFilename = 'tilda-' . $date . '.csv';

        $providerPath = $request->file('provider')->storeAs('', $providerFilename, 'public');
        $providerReader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $providerSpreadsheet = $providerReader->load(public_path(Storage::url($providerPath)));
        $providerSheet = $providerSpreadsheet->getActiveSheet();

        $providerData = [];
        for ($i = 5; $i <= $providerSheet->getHighestDataRow(); $i++) {
            $providerData[$i] = (int) $providerSheet->getCell("E$i")->getValue();
        }

        $tildaPath = $request->file('tilda')->storeAs('', $tildaFilename, 'public');
        $tildaReader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        $tildaSpreadsheet = $tildaReader->load(public_path(Storage::url($tildaPath)));
        $tildaSheet = $tildaSpreadsheet->getActiveSheet();

        $tildaArray = $tildaSheet->toArray();
        $idxColumnPriceTilda = array_search('Price', $tildaArray[0]);
        $letterColumnPriceTilda = self::$lettersHash[$idxColumnPriceTilda];

        $tildaData = [];
        for ($i = 2; $i <= $tildaSheet->getHighestDataRow(); $i++) {
            $tildaData[$i] = (int) $tildaSheet->getCell("C$i")->getValue();
        }

        foreach ($tildaData as $tildaRowId => $tildaCode) {
            foreach ($providerData as $providerRowId => $providerCode) {
                if ($tildaCode == $providerCode) {
                    $providerPrice = $providerSheet->getCell("I$providerRowId",)->getValue();
                    $tildaPrice = $tildaSheet->getCell($letterColumnPriceTilda . $tildaRowId)->getValue();
                    $tildaSheet->setCellValue(
                        $letterColumnPriceTilda . $tildaRowId,
                        $providerPrice + ($providerPrice * $marginPercent)
                    );
                    $providerSheet->getStyle("A$providerRowId")
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_YELLOW);
                }
            }
        }

        $providerWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($providerSpreadsheet);
        $providerWriter->save(public_path(Storage::url($providerFilename)));
        $tildaWriter = new \PhpOffice\PhpSpreadsheet\Writer\Csv($tildaSpreadsheet);
        $tildaWriter->save(public_path(Storage::url($tildaFilename)));

        $links = [
            'provider' => Storage::url($providerFilename),
            'tilda' => Storage::url($tildaFilename),
        ];
        return view('get-available-download', compact('links')); 
        dd(Storage::url($providerFilename), Storage::url($tildaFilename));
        return Storage::download($providerFilename);
    }
}
