<?php
	require_once 'classFile.php';
	
	switch ($a)
	{
		case '1':
			// load class
			$btClass = new bitcoins($start_time, $loadHtml = 0);
			
			// get sources from class
			$btc = $btClass->getFirstSourceData();
			$btc2 = $btClass->getFirstSourceData(); 
			$btc3 = $btClass->getThirdSourceData();
			
			//
			$allUsdActiveArray = $btClass->allUsd;
			$allEurActiveArray = $btClass->allEur;
			
			$avarageSumUsd = round($btc[0], 2) + round($btc2[0], 2) + round($btc3[0], 2);
			$avarageSumEur = round($btc[1], 2) + round($btc2[1], 2) + round($btc3[1], 2);
			
			$btcUsd = round($avarageSumUsd / $btClass -> activeUSD, 2);
			$btcEur = round($avarageSumEur / $btClass -> activeEUR, 2);
			?>
				<b>Current currency:</b><br/>
				BTC/USD: <?= $btcUsd; // count from active for correct results ?><br/>
				BTC/EUR:  <?= $btcEur; // count from active for correct results  ?><br/>
				EUR/USD: <?= round(abs($btcUsd/$btcEur),2);?><br/>
				<br/>
				<b>Active sources:</b><br/>
				BTC/USD (<?= $btClass -> activeEUR; ?> of <?= $btClass -> totalEUR; ?>)<br/>
				EUR/USD (<?= $btClass -> activeUSD; ?> of <?= $btClass -> totalUSD; ?>)<br/>
				Last update: <?= time(); ?><br/>
			<?php
		break;
		
		case '':
			// load class
			$btClass = new bitcoins($start_time, $loadHtml = 1);
			
			// get sources from class
			$btc = $btClass->getFirstSourceData();
			$btc2 = $btClass->getFirstSourceData(); 
			$btc3 = $btClass->getThirdSourceData();
			
			$avarageSumUsd = round($btc[0], 2) + round($btc2[0], 2) + round($btc3[0], 2);
			$avarageSumEur = round($btc[1], 2) + round($btc2[1], 2) + round($btc3[1], 2);
			
			$btcUsd = round($avarageSumUsd / $btClass -> activeUSD, 2);
			$btcEur = round($avarageSumEur / $btClass -> activeEUR, 2);
			
			// Load jquery ?>
			<script type='text/javascript'>	
				$(document).ready(function(){get_test();});
				
				var test_interval = 0;
				function get_test()
				{
					$.get('index.php?a=1', {}, function(results)
					{
						if (results)
						{
							$('#div').html('');
							$('#div').html(results);
						}
						else
						{
							$('#div').html('<b>Current currency:</b><br/>BTC/USD: <?= $btcUsd;?><br/>BTC/EUR:  <?= $btcEur;?><br/>EUR/USD: <?= round(abs($btcUsd/$btcEur),2);?><br/><br/><b>Active sources:</b><br/>BTC/USD (<?= $btClass -> activeEUR; ?> of <?= $btClass -> totalEUR; ?>)<br/>EUR/USD (<?= $btClass -> activeUSD; ?> of <?= $btClass -> totalUSD; ?>)<br/>');
						}
					});
				}
				test_interval = setInterval(get_test, 5000, true);
			</script>
			
			<div id="div"></div>
		<?php
		break;
	}
?>