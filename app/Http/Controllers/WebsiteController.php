<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class WebsiteController extends Controller
{
    public function index()
    {
        return view('index');
    }
}
