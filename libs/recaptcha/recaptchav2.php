<?php

class recaptchav2{
	public  static $public_key = '6LfedCATAAAAAM5ZR_FkFNU_tI6Kqt6v3nCZtf6d';
	public  static $secret_key = '6LfedCATAAAAAMumowaJbQrg64VG2-Rfuetm_NK4';
	public  static $status;
	
	private static $url = 'https://www.google.com/recaptcha/api/siteverify';
	
	public static function recaptcha_check_answer($answer){
		$postdata = http_build_query(
			array(
				'secret' => self::$secret_key,
				'response' => $answer
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$result = file_get_contents(self::$url, false, $context);
		return json_decode($result);
	}
}