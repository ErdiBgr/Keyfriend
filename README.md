# Keyfriend
[TR] Arama motorları aracılığıyla keyword listenizi oluşturun. <br>
[EN] Create a keyword list through search engines.

# Keyfriend sınıfının kullanımı
><b>Öncellikle Keyfriend sınıfımızı başlatıyoruz</b><br>
```
$kf = new Keyfriend;
```
><b>Daha sonra keyword listesi oluşturacağımız arama motorunu ve bize hangi formatta döneceğini seçiyoruz.</b><br>
```
$sorgu = $kf->yaani("Github")->ARR();
print_r($sorgu);
```
><b>Çıktı aşağıdaki gibi olacaktır.</b><br>
```
Array
(
    [search] => github
    [suggest] => Array
        (
            [0] => github
            [1] => github nedir
            [2] => github kullanımı
            [3] => github desktop
            [4] => github student pack
            [5] => github education
            [6] => github pages
            [7] => github api
            [8] => github wiki
            [9] => github tutorial
            [10] => github pricing
            [11] => github ekşi
            [12] => github a proje yükleme
            [13] => github io
        )

)
```
# Use of the Keyfriend class
><b>We're starting Keyfriend class first.</b><br>
```
$kf = new Keyfriend;
```
><b>Then select the search engine to create a keyword list and we choose the return format.</b><br>
```
$query = $kf->google("Github","en")->ARR();
print_r($query);
```
><b>The output will be as follows.</b><br>
```

Array
(
    [search] => Github
    [suggest] => Array
        (
            [0] => github
            [1] => github desktop
            [2] => github stackoverflow
            [3] => github student pack
            [4] => github login
            [5] => github pages
            [6] => github api
            [7] => github gist
            [8] => github pro
            [9] => github actions
        )

)

```
# Arama motorları ve aldığı parametreler.
<table style="width:100%">
	<tr>
		<th>Arama Motoru</th>
		<th>Method Adı</th>
		<th>Aldığı Parametreler</th>
	</tr>
  <tr>
		<td>AMAZON</td>
		<td>->amazon<b>( )</b>
		<td>("Aranacak kelime","Dil")</td>
	</tr>
	<tr>
	<tr>
		<td>ASK</td>
		<td>->ask<b>( )</b>
		<td>("Aranacak kelime")</td>
	</tr>
	<tr>
		<td>BAIDU</td>
		<td>->baidu<b>( )</b></td>
		<td>("Aranacak kelime")</td>
	</tr>
	<tr>
		<td>BING</td>
		<td>->bing<b>( )</b></td>
		<td>("Aranacak kelime)</td>
	</tr>
	<tr>
		<td>DUCKDUCKGO</td>
		<td>->dduckgo<b>( )</b></td>
		<td>("Aranacak kelime")</td>
	</tr>
	<tr>
		<td>DOGPILE</td>
		<td>->dogpile<b>( )</b></td>
		<td>("Aranacak kelime")</td>
	</tr>
	<tr>
		<td>GOOGLE</td>
		<td>->google<b>( )</b></td>
		<td>("Aranacak kelime","Dil")</td>
	</tr>
	<tr>
  <tr>
		<td>GOOGLE TRENDS</td>
		<td>->gtrends<b>( )</b></td>
		<td>("Aranacak kelime","Dil")</td>
	</tr>
	<tr>
		<td>STARTPAGE</td>
		<td>->startpage<b>( )</b></td>
		<td>("Aranacak kelime","Listeleme limiti")</td>
	</tr>
	<tr>
		<td>YAANI</td>
		<td>->yaani<b>( )</b></td>
		<td>("Aranacak kelime","Listeleme limiti","Dil")</td>
	</tr>
	<tr>
		<td>YAHOO</td>
		<td>->yahoo<b>( )</b></td>
		<td>("Aranacak kelime")</td>
	</tr>
	<tr>
		<td>YANDEX</td>
		<td>->yandex<b>( )</b></td>
		<td>("Aranacak kelime","Dil")</td>
	</tr>
  <tr>
		<td>YOUTUBE</td>
		<td>->youtube<b>( )</b></td>
		<td>("Aranacak kelime","Dil")</td>
	</tr>
</table>
<table>
	<tr>
		<th>Formatın Adı</th>
		<th>Method Adı</th>
		<th>Aldığı Parametreler</th>
	</tr>
	<tr>
		<td>ARRAY</td>
		<td>->ARR</td>
		<td>Tek bir <b>boolean</b> tipine sahip parametre alır.Varsılayan değeri <b>True</b>'dur. Eğer biz bunu <b>False</b>'a çekersek aradığımız kelimeyi geri döndürmez</td>
	</tr>
	<tr>
		<td>JSON</td>
		<td>->JSON</td>
		<td>Tek bir <b>boolean</b> tipine sahip parametre alır.Varsılayan değeri <b>True</b>'dur. Eğer biz bunu <b>False</b>'a çekersek aradığımız kelimeyi geri döndürmez</td>
	</tr>
		<tr>
		<td>XML</td>
		<td>->XML</td>
		<td>Tek bir <b>boolean</b> tipine sahip parametre alır.Varsılayan değeri <b>True</b>'dur. Eğer biz bunu <b>False</b>'a çekersek aradığımız kelimeyi geri döndürmez</td>
	</tr>
	<tr>
		<td>STRING</td>
		<td>->STR</td>
		<td>Tek bir <b>boolean</b> tipine sahip parametre alır.Varsılayan değeri <b>True</b>'dur. Eğer biz bunu <b>False</b>'a çekersek aradığımız kelimeyi geri döndürmez</td>
	</tr>
</table>


