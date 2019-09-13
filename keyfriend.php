<?php 

class Keyfriend{
	private $result;

	/**
	 * @param  [str] $q 	[Enter the search word]
	 * @param  [str] $lang  [Choose language default:Turkish]
	 */
	
	public function amazon($q,$lang = "tr")
	{
		$q = $this->control($q);
		$ch = curl_init($lang == "tr" ? "https://completion.amazon.co.uk/api/2017/suggestions?mid=A33AVAJ2PDY3EV&alias=aps&prefix=$q":"https://completion.amazon.com/api/2017/suggestions?mid=ATVPDKIKX0DER&alias=aps&prefix=$q");
		curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => True,CURLOPT_SSL_VERIFYPEER => False]);
		$output = curl_exec($ch);
		curl_close($ch);
		$output = json_decode($output,True);
		$count = count($output["suggestions"]);
		$results = [[]];
		for ($i = 0; $i < $count; $i++) {
			array_push($results[0], $output["suggestions"][$i]["value"]);
		}
		array_unshift($results, $output["prefix"]);
		$this->result = ["search" => $results[0],"suggest" => $results[1]];
		return $this;
	}
	/**
	 * @param  [str] $q [Enter the search word]
	 * @param  [int] $limit [Determine limit. Default&Max = 20]
	 */
	
	public function ask($q,$limit=20)
	{
		$q = $this->control($q);
		$ch = curl_init("https://amg-ss.ask.com/query?limit=$limit&q=$q");
		curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER => True,CURLOPT_SSL_VERIFYPEER => False]);
		$results = curl_exec($ch);
		curl_close($ch);
		$results = json_decode($results,True);
		$this->result = ["search" => $results[0],"suggest" => $results[1]];
		return $this;
	}

	/**
	 * @param  [str] $q [Enter the search word]
	 */
	
	public function baidu($q)
	{
		$q = $this->control($q);
		$ch = curl_init("https://www.baidu.com/sugrec?prod=pc&wd=$q");
		curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER => True,CURLOPT_SSL_VERIFYPEER => False]);
		$output = curl_exec($ch);
		curl_close($ch);
		$output = json_decode($output,True);
		$count = count($output["g"]);
		$results = [[]];
		for ($i = 0; $i < $count; $i++) 
		{
			array_push($results[0], $output["g"][$i]["q"]);
		}
		array_unshift($results, $output["q"]);
		$this->result = ["search" => $results[0],"suggest" => $results[1]];
		return $this;
	}

	/**
	 * @param  [str] $q [Enter the search word]
	 */
	
	public function bing($q)
	{
		$s = $q;
		$q = $this->control($q);
		$ch = curl_init("https://www.bing.com/AS/Suggestions?qry=$q&cvid=41E8337FF8A5417CA0FDB8003FCEAD77");
		curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER => True,CURLOPT_SSL_VERIFYPEER => False]);
		$results = curl_exec($ch);
		curl_close($ch);
		$xmlDoc = new DOMDocument();
		$xmlDoc->loadHTML($results);
		$search = $xmlDoc->getElementsByTagName("li");
		$results = [[]];
		foreach ($search as $value) 
		{
			array_push($results[0],utf8_decode($value->getAttribute("query")));
		}
		array_unshift($results, $s);
		$results = str_replace("+", " ", $results);
		$this->result = ["search" => $results[0],"suggest" => $results[1]];
		return $this;
	}

	/**
	 * @param  [str] $q [Enter the search word]
	 */
	
	public function dduckgo($q){
		$s = $q;
		$q = $this->control($q);
		$ch = curl_init("https://duckduckgo.com/ac/?q=$q");
		curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER => True,CURLOPT_SSL_VERIFYPEER => False]);
		$output = curl_exec($ch);
		curl_close($ch);
		$output = json_decode($output,True);
		$count = count($output);
		$results = [[]];
		for ($i = 0; $i < $count; $i++)
		{
			array_push($results[0], $output[$i]["phrase"]);
		}
		array_unshift($results, $s);
		$this->result = ["search" => $results[0],"suggest"=> $results[1]];
		return $this;
	}

	/**
	 * @param  [str] $q [Enter the search word]
	 */
	
	public function dogpile($q){
		$s = $q;
		$q = $this->control($q);
		$ch = curl_init("https://www.dogpile.com/suggestions?q=$q");
		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER => True,
			CURLOPT_SSL_VERIFYPEER => False,
			CURLOPT_USERAGENT => "Googlebot/2.1 (+http://www.googlebot.com/bot.html)"
		]);
		$output = curl_exec($ch);
		curl_close($ch);
		$output = json_decode($output,true);
		array_shift($output);
		$count = count($output["suggestions"]);
		$results = [[]];
		for ($i = 0; $i < $count; $i++)
		{
			array_push($results[0], $output["suggestions"][$i]["text"]);
		}
		array_unshift($results, $s);
		$this->result = ["search" => $results[0],"suggest"=> $results[1]];
		return $this;
	}

	/**
	 * @param  [str] $q 	[Enter the search word]
	 * @param  [str] $lang  [Choose language default:Turkish]
	 */

	public function google($q,$lang="tr")
	{
		$s = $q;
		$q = $this->control($q);
		$ch = curl_init("https://clients1.google.com/complete/search?hl=$lang&output=toolbar&q=$q");
		curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER => True,CURLOPT_SSL_VERIFYPEER => False]);
		$results = curl_exec($ch);
		curl_close($ch);
		$results = mb_convert_encoding($results, "UTF-8", "ISO-8859-9");
		preg_match_all('@<suggestion data="(.*?)"/>@', $results,$results);
		array_shift($results);
		array_unshift($results, $s);
		$this->result = ["search" => $results[0],"suggest"=> $results[1]];
		return $this;
	}

	/**
	 * @param  [str] $q 	[Enter the search word]
	 * @param  [str] $lang  [Choose language default:Turkish]
	 */

	public function gtrends($q,$lang = "tr"){
		$s = $q;
		$q = $this->control($q);

		$ch = curl_init("https://trends.google.com/trends/api/autocomplete/$q?hl=$lang");
		curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => True,CURLOPT_SSL_VERIFYPEER => False]);
		$output = curl_exec($ch);
		curl_close($ch);
		preg_match_all('/"title":"(.*?)"/m', $output, $output, PREG_SET_ORDER, 0);
		$count = count($output);
		$results = [[]];
		for ($i = 0; $i <$count; $i++) {
			$json = '{"convert":"'.$output[$i][1].'"}';
			$data = json_decode($json);
			array_push($results[0], $data->convert);
		}
		array_unshift($results, $s);

		$this->result = ["search" => $results[0],"suggest"=> $results[1]];
		return $this;
	}

	/**
	 * @param  [str] $q [Enter the search word]
	 * @param  [int] $limit [Determine limit. Default&Max = 20]
	 */
	
	public function startpage($q,$limit = 20)
	{
		$q = $this->control($q);
		$ch = curl_init("https://www.startpage.com/do/suggest?limit=$limit&format=json&query=$q");
		curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER => True,CURLOPT_SSL_VERIFYPEER => False]);
		$results = curl_exec($ch);
		curl_close($ch);
		$results = json_decode($results,True);
		$this->result = ["search" => $results[0],"suggest"=> $results[1]];
		return $this;
	}

	/**
	 * @param  [str] $q 	[Enter the search word]
	 * @param  [int]  $max  [Determine limit. Default&Max = 100]
	 * @param  [str]  $lang [Choose language default:Turkish]
	 */

	public function yaani($q,$limit = 100,$lang="tr-TR")
	{
		$q = $this->control($q);
		$ch = curl_init("https://asgs.yaani.com.tr/suggest?q=$q&lang=$lang&max=$limit");
		curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER => True,CURLOPT_SSL_VERIFYPEER => False]);
		$output = curl_exec($ch);
		curl_close($ch);
		$output = json_decode($output,true);
		$results = [[]];
		foreach ($output as $value) 
		{
			if (!is_array($value)) 
			{	
				array_unshift($results, $value);
			}else
			{
				array_push($results[1], $value[0]);
			}
		}
		$this->result = ["search" => $results[0],"suggest" => $results[1]];
		return $this;
	}

	/**
	 * @param  [str] $q [Enter the search word]
	 */
	
	public function yahoo($q)
	{
		$s = $q;
		$q = $this->control($q);
		$ch = curl_init("https://search.yahoo.com/sugg/gossip/gossip-us-ura/?command=$q");
		curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER => True,CURLOPT_SSL_VERIFYPEER => False]);
		$results = curl_exec($ch);
		curl_close($ch);
		$xmlDoc = new DOMDocument();
		$xmlDoc->loadXML($results);
		$search = $xmlDoc->getElementsByTagName("s");
		$results = [[]];
		foreach ($search as $value)
		{
			array_push($results[0], $value->getAttribute('k'));
		}
		array_unshift($results, $s);
		$this->result = ["search" => $results[0],"suggest" => $results[1]];
		return $this;
	}

	/**
	 * @param  [str] $q    [Enter the search word]
	 * @param  [str] $lang [Choose language default:Turkish]
	 */

	public function yandex($q,$lang = "tr"){
		$s = $q;
		$q = $this->control($q);
		$ch = curl_init("https://yandex.com.tr/suggest/suggest-ya.cgi?part=$q&uil=$lang");
		curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER => True,CURLOPT_SSL_VERIFYPEER => False]);
		$results = curl_exec($ch);
		curl_close($ch);
		preg_match_all('/(".*?")/m', $results, $matches, PREG_SET_ORDER, 0);
		$results = [[]];
		foreach ($matches as $value)
		{
			array_push($results[0],trim($value[0],'"'));
		}
		array_unshift($results,$s);
		$this->result = ["search" => $results[0],"suggest" => $results[1]];
		return $this;
	}

	/**
	 * @param  [str] $q 	[Enter the search word]
	 * @param  [str] $lang  [Choose language default:Turkish]
	 */
	
	public function youtube($q,$lang = "tr")
	{
		$q = $this->control($q);
		$ch = curl_init("https://clients1.google.com/complete/search?client=youtube&hl=$lang&gs_ri=youtube&ds=yt&q=$q");
		curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => True,CURLOPT_SSL_VERIFYPEER => False]);
		$output = curl_exec($ch);
		curl_close($ch);
		$output = mb_convert_encoding($output, "UTF-8", "ISO-8859-9");
		preg_match_all('/"(.*?)"/m', $output, $output, PREG_SET_ORDER, 0);
		$count = count($output);
		$results = [[]];
		for ($i = 1; $i <$count; $i++) 
		{
			if ($output[$i][1] != "k") 
			{
				array_push($results[0], $output[$i][1]);
			}
			else
			{
				array_unshift($results, $output[0][1]);
				break;
			}
		}
		$this->result = ["search" => $results[0],"suggest" => $results[1]];
		return $this;
	}

	private function control($c)
	{
		$c = empty($c) ? "???":$c;
		$c = explode(" ", $c);
		$c = implode("+", $c);
		return $c;
	}

	/**
	 * @param  [boolean] $w [Select whether to show the searched word. Default:True]
	 * @return [Array]
	 */

	public function ARR($w = True)
	{
		return $w ? $this->result:$this->result["suggest"];
	}

	/**
	 * @param  [boolean] $w [Select whether to show the searched word. Default:True]
	 * @return [XML]
	 */
	
	public function XML($w = True) 
	{ 
		$xml = new SimpleXMLElement('<search/>'); 
		$w == True ? $xml->addAttribute('word', $this->result["search"]):Null;
		foreach ($this->result["suggest"] as $k => $v) 
		{ 
			$a = $xml->addChild("prop", $v); 
			$a->addAttribute('id', $k);
		} 
		return $xml->asXML(); 
	}

	/**
	 * @param  [boolean] $w [Select whether to show the searched word. Default:True]
	 * @return [JSON]
	 */
	public function JSON($w = True)
	{
		return $w ? json_encode($this->result):json_encode($this->result["suggest"]);
	}

	/**
	 * @param  [boolean] $w [Select whether to show the searched word. Default:True]
	 * @return [str]
	 */

	public function STR($w = True)
	{
		return $w ? $this->result["search"].":".implode(",", $this->result["suggest"]):
		implode(",", $this->result["suggest"]);
	}
}

#EXAMPLE
$kf = new Keyfriend;
$query = $kf->yaani("Github")->ARR();
print_r($query);
?>
