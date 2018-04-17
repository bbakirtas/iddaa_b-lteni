// Bir sayfada birden fazla tablo olduğu için arrayı bölmen gerekli
// $tarih[1][0] 13-04-2018 tarihini verir
// $matches[1][0] 13-04-2018 tarihli bülteni gösterir
// $tarih[1][1] 14-04-2018 tarihini verir
// $matches[1][1] 14-04-2018 tarihli bülteni gösterir
// $tarih[1][2] 15-04-2018 tarihini verir
// $matches[1][2] 15-04-2018 tarihli bülteni gösterir
// $tarih arrayının toplamını alarak döngüye sokulabilir.
// $aDataTableDetailHTML jsona dönüştürülüp kullanılabilir.


set_time_limit(0);
$site = "http://cdn2.iddaa.com/iddaa/bulten/next/13-16.04.2018v2.html";
$data = file_get_contents($site);
preg_match_all('/<tbody.*?>(.*?)<\/tbody>/si', $data, $matches); 
preg_match_all('/<th colspan="8" class="tablo_adi".*?>(.*?)<\/th>/si', $data, $tarih); 
print_r($tarih[1][0]);
$veri = '
<table class="oyun_programi"> <thead>  
 <tr> <th>S</th> 
 <th>Lig</th>
  <th>Saat</th> 
  <th>Kod</th> 
  <th>Mbs</th> 
  <th>İY / H1</th>
  <th>MS / H1</th> 
  <th>Ev Sahibi Takım</th> 
  <th>MAÇ SONUCU 1</th>
   <th>MAÇ SONUCU 0</th>
    <th>MAÇ SONUCU 2</th> 
    <th>Konuk Takım </th> 
    <th>İY / H2</th> 
    <th>MS / H2</th>
  <th>Çifte Şans 1veya0</th> <th>Çifte Şans 1veya2</th> <th>Çifte Şans 2veya0</th> <th>Handikaplı Maç Sonucu 1 </th> <th>Handikaplı Maç Sonucu 0 </th> <th>Handikaplı Maç Sonucu 2</th> <th>1,5 Gol Altı</th> <th>1,5 Gol Üstü</th> <th>2,5 Gol Altı </th> <th>2,5 Gol Üstü</th> 
  <th>3,5 Gol Altı</th> <th>3,5 Gol Üstü</th> <th>A / Ü Toplam Sayı</th> <th>Karşılıklı Gol	 Var </th> <th>Karşılıklı Gol	 Yok</th> <th>Toplam Gol Sayısı 0-1</th> <th>Toplam Gol Sayısı 2-3</th> <th>Toplam Gol Sayısı 4-6</th> <th>Toplam Gol Sayısı 7+</th> <th>İlk Yarı Sonucu 1</th> <th>İlk Yarı Sonucu 0 </th> <th>İlk Yarı Sonucu 2</th>
   <th>1,5 Gol (İlk Yarı Sonucu) Altı </th> <th>1,5 Gol (İlk Yarı Sonucu) Üstü</th> <th>İlk Yarı / Maç Sonucu 1/1</th> <th>İlk Yarı / Maç Sonucu 0/1</th> <th>İlk Yarı / Maç Sonucu 2/1</th> <th>İlk Yarı / Maç Sonucu 0/0</th> <th>İlk Yarı / Maç Sonucu 2/0</th> <th>İlk Yarı / Maç Sonucu 1/0</th><th>İlk Yarı / Maç Sonucu 1/2</th> <th>İlk Yarı / Maç Sonucu 0/2</th> <th>İlk Yarı / Maç Sonucu 2/2</th>   </tr>     
</thead><tbody>
'.$matches[1][0].' 
';

$htmlContent = $veri;
$DOM = new DOMDocument();
	$DOM->loadHTML($htmlContent);
	
	$Header = $DOM->getElementsByTagName('th');
	$Detail = $DOM->getElementsByTagName('td');

    //#Get header name of the table
	foreach($Header as $NodeHeader) 
	{
		$aDataTableHeaderHTML[] = trim($NodeHeader->textContent);
	}
	//print_r($aDataTableHeaderHTML); die();

	//#Get row data/detail table without header name as key
	$i = 0;
	$j = 0;
	foreach($Detail as $sNodeDetail) 
	{
		$aDataTableDetailHTML[$j][] = trim($sNodeDetail->textContent);
		$i = $i + 1;
		$j = $i % count($aDataTableHeaderHTML) == 0 ? $j + 1 : $j;
	}
	//print_r($aDataTableDetailHTML); die();
	
	//#Get row data/detail table with header name as key and outer array index as row number
	for($i = 0; $i < count($aDataTableDetailHTML); $i++)
	{
		for($j = 0; $j < count($aDataTableHeaderHTML); $j++)
		{
			$aTempData[$i][$aDataTableHeaderHTML[$j]] = $aDataTableDetailHTML[$i][$j];
		}
	}
	$aDataTableDetailHTML = $aTempData; unset($aTempData);
	print_r($aDataTableDetailHTML); die();
