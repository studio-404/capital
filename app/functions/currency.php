<?php 
class currency
{
	public function index()
	{
		$out = array();
		$out["usd"] = "";
		$out["eur"] = "";
		try
		{
			$client = new SoapClient('http://nbg.gov.ge/currency.wsdl');
			$out["usd"] = $client->GetCurrency('USD').'<br>';
			$out["eur"] = $client->GetCurrency('EUR').'<br>';
		}catch(Exception $e){

		}		
		return $out;
	}
}