<?php
class bitcoins
{
	// global variables
	var $activeUSD;
	var $activeEUR; // active sources
	
	var $totalUSD;
	var $totalEUR; // total sources
	
	// get start time
	private $sTime;
	private $sHtml;
	
	// html code
	function __construct($startTime, $loadHtml)
	{
		$this->sTime = $startTime;
		$this->htmlStarted = $loadHtml;
		if ( $loadHtml)
		{
			?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>BTC</title>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta name="author" content="katum"/>
		<meta name="referrer" content="no-referrer"/>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
	</head>
<body>
			<?php
		}
	}
	
	function __destruct()
	{	
		if ($this->htmlStarted)
		{
		?>
		<br/>
		<small style="color:#DEDEDE">Generated in: <?= round(microtime(true) - $this->sTime, 2); ?> sec.</small>
		</body>
		</html>
		<?php
		}
	}
	
	
	// first source (1)
	public function getFirstSourceData()
	{
		// First price get
		$url = 'https://blockchain.info/ticker'; 
		$data = file_get_contents($url); 
		$btcPrices = json_decode($data, true);
		
		$usdBtc = $btcPrices['USD']['last']; // (15 min delay)
		$eurBtc = $btcPrices['EUR']['last']; // (15 min delay)
		
		// handle with sources
		if ($usdBtc) $this->activeUSD++;
		if ($eurBtc) $this->activeEUR++;
		
		$this->totalUSD++;
		$this->totalEUR++;
		// return as array
		return [$usdBtc, $eurBtc];
	}
	
	// second source (2)
	public function getSecondSourceData()
	{
		// Second price get
		$url = 'https://bitpay.com/api/rates'; 
		$data = file_get_contents($url); 
		$btcPrices = json_decode($data, true);
		
		$usdBtc = $btcPrices[1]['rate']; // (1 min delay)
		$eurBtc = $btcPrices[2]['rate']; // (1 min delay)
		
		// handle with sources
		if ($usdBtc) $this->activeUSD++;
		if ($eurBtc) $this->activeEUR++;
		
		$this->totalUSD++;
		$this->totalEUR++;
		
		// return as array
		return [$usdBtc, $eurBtc];
	}
	
	// third source (3)
	public function getThirdSourceData()
	{
		// Third price get
		$url = 'https://api.coinmarketcap.com/v1/ticker/bitcoin/?convert=EUR'; 
		$data = file_get_contents($url); 
		$btcPrices = json_decode($data, true);
		
		$usdBtc = $btcPrices[0]['price_usd']; // (5 min delay - 10 per minute request)
		$eurBtc = $btcPrices[0]['price_eur']; // (5 min delay - 10 per minute request)
		
		// handle with sources
		if ($usdBtc) $this->activeUSD++;
		if ($eurBtc) $this->activeEUR++;
		
		$this->totalUSD++;
		$this->totalEUR++;
		
		// return as array
		return [$usdBtc, $eurBtc];
	}
	
	public function allUsd()
	{
		return [$this->activeUSD, $this->totalUSD];
	}
	
	public function allEur()
	{
		return [$this->activeUSD, $this->totalUSD];
	}
	
}