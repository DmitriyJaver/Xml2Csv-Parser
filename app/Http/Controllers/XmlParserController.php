<?php

namespace App\Http\Controllers;

use App\Services\XmlToCsvParserService;
use Illuminate\Http\Request;



class XmlParserController extends Controller
{
    public function index()
    {
        $url = 'http://webtest.d0.acom.cloud/test/xml-examples/example-footwearnews.xml';
        return view('welcome')->with([
            'url' => $url,
        ]);
    }

    public function getCsv(Request $request)
    {
        $newXml = new XmlToCsvParserService($request->get('source_url'));
        $fileName = $newXml->handle();

        if (!$fileName) {
            return redirect('/')->withErrors('XML not found');
        }
        return view('csv', compact('fileName'));
    }
}
