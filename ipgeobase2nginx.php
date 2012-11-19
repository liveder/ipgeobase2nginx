<?php
function encodestring($string) {
    $replace=array(
	"'"=>"",
	"`"=>"",
	"а"=>"a","А"=>"A",
	"б"=>"b","Б"=>"B",
	"в"=>"v","В"=>"V",
	"г"=>"g","Г"=>"G",
	"д"=>"d","Д"=>"D",
	"е"=>"e","Е"=>"E",
	"ж"=>"zh","Ж"=>"Zh",
	"з"=>"z","З"=>"Z",
	"и"=>"i","И"=>"I",
	"й"=>"y","Й"=>"Y",
	"к"=>"k","К"=>"K",
	"л"=>"l","Л"=>"L",
	"м"=>"m","М"=>"M",
	"н"=>"n","Н"=>"N",
	"о"=>"o","О"=>"O",
	"п"=>"p","П"=>"P",
	"р"=>"r","Р"=>"R",
	"с"=>"s","С"=>"S",
	"т"=>"t","Т"=>"T",
	"у"=>"u","У"=>"U",
	"ф"=>"f","Ф"=>"F",
	"х"=>"h","Х"=>"H",
	"ц"=>"c","Ц"=>"C",
	"ч"=>"ch","Ч"=>"Ch",
	"ш"=>"sh","Ш"=>"Sh",
	"щ"=>"sch","Щ"=>"Sch",
	"ъ"=>"","Ъ"=>"",
	"ы"=>"y","Ы"=>"Y",
	"ь"=>"","Ь"=>"",
	"э"=>"e","Э"=>"E",
	"ю"=>"yu","Ю"=>"Yu",
	"я"=>"ya","Я"=>"Ya",
	"і"=>"i","І"=>"I",
	"ї"=>"yi","Ї"=>"Yi",
	"є"=>"e","Є"=>"e"
    );
    $str=iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
    $str=str_replace("\"","",$str);
    return $str;
}


    $file_to_update = './geo_ipgeobase.cfg';

    $cities = file_get_contents('cities.txt');
    $cities = mb_convert_encoding($cities, 'utf8', 'cp1251');
    $cities = explode("\n", $cities);
    $count_cities = count($cities);

    $addrs = file_get_contents('cidr_optim.txt');
    $addrs = mb_convert_encoding($addrs, 'utf8', 'cp1251');
    $addrs = explode("\n", $addrs);

    $count = count($addrs);
    $data = "";
    $fp = fopen($file_to_update, "w");
    for ($i = 0; $i < $count; $i++) {
        $addrs_row = explode("\t",$addrs[$i]);
        if ($addrs_row[4] and $addrs_row[4]!="-")
            for ($j = 0; $j < $count_cities; $j++) {
                $cities_row = explode("\t",$cities[$j]);
                if ($addrs_row[4] == $cities_row[0]) {
                $data = str_replace(" ","",$addrs_row[2])."\t"."\"".$cities_row[0]."|".encodestring(@$cities_row[1])."|".encodestring(@$cities_row[2])."|".encodestring(@$cities_row[3])."|".$addrs_row[3]."\";"."\n";
                fwrite($fp, $data);
                }
            }
            elseif ($addrs_row[0]) {
                $data = str_replace(" ","",$addrs_row[2])."\t"."\""."|"."|"."|"."|".$addrs_row[3]."\";"."\n";
                fwrite($fp, $data);
            }
    }

//    if (strlen($file_to_update)){
//        file_put_contents($file_to_update, $data);
//    }
?>