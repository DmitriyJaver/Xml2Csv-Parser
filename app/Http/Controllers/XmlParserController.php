<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use SimpleXMLElement;

class XmlParserController extends Controller
{
    const EMPTY_XML = ['empty'];

    const TABLE_HEADER = ["ASIN", "URL", "Amazon URL", "Product name", "Amazon Introtext",
        "Amazon Introtext COUNT", "Amazon ProductSummary", "Amazon Product Summary COUNT",
        "Amazon Award", "Amazon Award COUNT"];

    const FILE_EXT = 'csv';

    public function index()
    {
        $url = 'http://webtest.d0.acom.cloud/test/xml-examples/example-footwearnews.xml';
        return view('welcome')->with([
            'url' => $url,
        ]);
    }

    public function handleXml(Request $request)
    {
        $xml = simplexml_load_file($request->get('source_url'));
        $fileName = self::generateCsvFileName($xml->channel->link);
        $filePath = public_path($fileName);
        $file = fopen($filePath, 'w');

        fputcsv($file, self::TABLE_HEADER, ';', '"');

        foreach ($xml->children() as $key => $child) {
            foreach ($child->item as $childKey => $childValue) {
                foreach ($childValue->children('amzn', true)->products->children('amzn', true)->product as $productKey => $productValue) {

                    $asin = [self::getAsin(get_object_vars($productValue->children('amzn', true)->productURL))];
                    $url = get_object_vars($childValue->link) ?: self::EMPTY_XML;
                    $productName = get_object_vars($productValue->children('amzn', true)->productHeadline) ?: self::EMPTY_XML;
                    $amazonUrl = get_object_vars($productValue->children('amzn', true)->productURL) ?: self::EMPTY_XML;
                    $amazonIntroText = get_object_vars($productValue->children('amzn', true)->introText) ?: self::EMPTY_XML;
                    $amazonIntroTextCount = [self::countStrInArray(get_object_vars($productValue->children('amzn', true)->introText))];
                    $amazonProductSummary = get_object_vars($productValue->children('amzn', true)->productSummary) ?: self::EMPTY_XML;
                    $amazonProductSummaryCount = [self::countStrInArray(get_object_vars($productValue->children('amzn', true)->productSummary))];
                    $amazonAward = get_object_vars($productValue->children('amzn', true)->award) ?: self::EMPTY_XML;
                    $amazonAwardCount = [self::countStrInArray(get_object_vars($productValue->children('amzn', true)->award))];

                    $arrAll = array_merge($asin, $url, $amazonUrl, $productName, $amazonIntroText, $amazonIntroTextCount, $amazonProductSummary, $amazonProductSummaryCount, $amazonAward, $amazonAwardCount);
                    fputcsv($file, $arrAll, ';', '"');
                }
            }
        }
        fclose($file);
        return back();
    }

    public static function countStrInArray(Array $arr): int
    {
        if (!isset($arr)) {
            return (int)$count = 0;
        }
        return (int)$count = strlen(implode($arr));
    }

    public static function getAsin(Array $url): string
    {
        if (!isset($url)){
            return 'empty';
        }
        $asinCut = parse_url(implode($url), PHP_URL_PATH);
         return  substr($asinCut, -11, 10);
    }

    public static function generateCsvFileName($url): string
    {
        $cutUrl = parse_url($url, PHP_URL_HOST);
        $CurrentDate = Carbon::now()->format('Y-m-d');

        return (string)$fileName = $cutUrl . '_' . $CurrentDate . '.' . self::FILE_EXT ;
    }
}
