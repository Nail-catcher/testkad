<?php 
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Currencies;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
class MyCommand extends Command
{
    protected $name        = 'mycommand:replacebd';
    protected $description = 'Приветствет вас';
    public function fire()
    {
        $this->info( 'Подключаюсь к xml' );
        $xmld = @simplexml_load_file('http://www.cbr.ru/scripts/XML_daily.asp');
        $xml2 = @simplexml_load_file('http://www.cbr.ru/scripts/XML_valFull.asp');
    
        

        function ToArr($result)
        {         
        
        $xml = (array) $result;

        if(empty($xml)) {
        return null;
        }

        foreach ($xml as $key=>$val) {
            if ($val instanceof SimpleXMLElement) {
                $xml[$key] = self::xmlToArray($val);
            } elseif (empty($val)) {
                $xml[$key] = null;
            }
        }  
        return $xml;
        } 

        $results = $xml2->xpath('Item');
        foreach ($results as $result) {  
        $xml=ToArr($result);
        $idd=$xml['ParentCode'];
        $idd=trim($idd," ");
        
        $resultds = $xmld->xpath('Valute');      
        foreach ($resultds as $resultd){
            $idd = $xml['ParentCode'];

            $cost=ToArr($resultd);            
            if ($cost['@attributes'] == ($xml['@attributes'])) { 
                print_r(gettype($cost['Value']));
            Currencies::firstOrCreate(['id' => $xml['ParentCode']], [
            'id' => $xml['ParentCode'],
            'name' => $xml['Name'],
            'english_name' => $xml['EngName'],
            'alphabetic_code' => $xml['ISO_Char_Code'],
            'digit_code' => $xml['ISO_Num_Code'],
            'rate' => $cost['Value'],
        ]); 
        }
            
             
          }
         
         
        
          }
    }
// ОБЪЯВЛЯЕМ АРГУМЕНТЫ, иначе пошлёт при указании неизвестного аргумента
    // array($name, $mode, $description, $defaultValue)
   
      public function handle()
    {
        $this->fire();
    }
}