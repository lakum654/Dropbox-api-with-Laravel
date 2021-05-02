<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_encode;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
class DropboxController extends Controller
{
    public $apiKey = '2afqnbp4jd93h5n';
    public $appSecret = 'osdarkrp2k6gi0h';
    public $authToken = 'sl.Av06gJDA5BVUc1r3mB3SMSSntwh3ZSHZhya5k7trGYjOgwPoiE0DveldWLrdSe5Zu_ysj7Z_Mjdvlk3803mLmktXPgphkwf9WSVayuHMxxO-c_Uzd9GIIskXeYis3JHJL1sZXp8AOSI';

   public function index(){
    $parameters = array('path' => '','include_deleted' => false,'recursive' => false);

    $headers = array('Authorization: Bearer '.$this->authToken,
                     'Content-Type: application/json');
    
    $curlOptions = array(
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($parameters),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_VERBOSE => true);
    
    $ch = curl_init('https://api.dropboxapi.com/2/files/list_folder');
    
    curl_setopt_array($ch, $curlOptions);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    
    $result = curl_exec($ch);
    
    $files = json_decode($result, true);    
    curl_close($ch);
    return view('dropbox.index',compact('files'));
   }

   public function download(Request $request)
   {
     $out_filepath = $request->file;
     $in_filepath = $request->file;   
    $out_fp = fopen($out_filepath, 'w+');
    if ($out_fp === FALSE)
        {
        echo "fopen error; can't open $out_filepath\n";
        return (NULL);
        }

    $url = 'https://content.dropboxapi.com/2/files/download';

    $header_array = array(
        'Authorization: Bearer ' . $this->authToken,
        'Content-Type:',
        'Dropbox-API-Arg: {"path":"' . $in_filepath . '"}'
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
    curl_setopt($ch, CURLOPT_FILE, $out_fp);

    $metadata = null;
    curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($ch, $header) use (&$metadata)
        {
        $prefix = 'dropbox-api-result:';
        if (strtolower(substr($header, 0, strlen($prefix))) === $prefix)
            {
            $metadata = json_decode(substr($header, strlen($prefix)), true);
            }
        return strlen($header);
        }
    );

    $output = curl_exec($ch);

    if ($output === FALSE)
        {
        echo "curl error: " . curl_error($ch);
        }

    curl_close($ch);
    fclose($out_fp);
    $request->session()->put('file',$request->file);
    return back();
   }

   public function read(Request $request)
   {
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
$reader->setReadDataOnly(TRUE);


$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();


$spreadsheet = $reader->load('hello.xlsx');

$sheetData = $spreadsheet->getActiveSheet()->toArray();

// if (!empty($sheetData)) {
//     for ($i=1; $i<count($sheetData); $i++) {
//         $name = $sheetData[$i][1];
//         $email = $sheetData[$i][2];
//     }
// }


   
    }

public function upload()
{
$path = public_path('sarthi.xlsx');    
$fp = fopen($path, 'rb');
$size = filesize($path);

$cheaders = array('Authorization: Bearer '.$this->authToken,
                  'Content-Type: application/octet-stream',
                  'Dropbox-API-Arg: {"path":"test'.$path.'", "mode":"add"}');

$ch = curl_init('https://content.dropboxapi.com/2/files/upload');
curl_setopt($ch, CURLOPT_HTTPHEADER, $cheaders);
curl_setopt($ch, CURLOPT_PUT, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_INFILE, $fp);
curl_setopt($ch, CURLOPT_INFILESIZE, $size);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$response = curl_exec($ch);

echo $response;
curl_close($ch);
fclose($fp);
}
   }
