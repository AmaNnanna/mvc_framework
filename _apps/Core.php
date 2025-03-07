<?php

//Write your custome class/methods here
namespace Apps;

use \Apps\MysqliDb;
use \Apps\Session;
use mysqli;
use \Verot\UploadFiles;
use \Apps\EmailTemplate;

class Core extends Model
{

	public $token = NULL;
	public $accid = NULL;
	public $toast = false;

	public function __construct()
	{
		parent::__construct();
	}

	public function GenPassword($length = 6)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function Passwordify($password)
	{
		$Passwordify = md5($password);
		return $Passwordify;
	}

	public function ToMoney($amount)
	{
		$amount = number_format($amount, 2, ".", ",");
		return "₦ " . $amount;
	}


	public function cleanup($text)
	{
		$text = preg_replace('/[\t\n\r\0\x0B]/', '', $text);
		$text = preg_replace('/([\s])\1+/', ' ', $text);
		$text = trim($text);
		return strtolower($text);
	}

	public function PostType($haystack, $i = "i", $word = "W")
	{
		$needle_need = "i need";
		$needle_have = "i have";
		if (strtoupper($word) == "W") {   // if $word is "W" then word search instead of string in string search.
			if (preg_match("/\b{$needle_need}\b/{$i}", $haystack)) {
				return "buying";
			}
			if (preg_match("/\b{$needle_have}\b/{$i}", $haystack)) {
				return "selling";
			}
		} else {
			if (preg_match("/{$needle_need}/{$i}", $haystack)) {
				return "buying";
			}
			if (preg_match("/{$needle_have}/{$i}", $haystack)) {
				return "selling";
			}
		}
		return "others";
		// Put quotes around true and false above to return them as strings instead of as bools/ints.
	}

	public static function slugify($string)
	{
		$table = array(
			'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
			'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
			'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
			'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
			'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
			'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
			'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
			'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r', '/' => '-', ' ' => '-', ',' => '', '&' => 'and'
		);
		// -- Remove duplicated spaces
		$stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/', '/[^a-z0-9]/i'), ' ', $string);
		// -- Returns the slug

		return strtolower(strtr($string, $table));
	}

	// Registration Form
	public function registrationForm($surname, $last_name, $gender, $religion, $residence, $phone, $disabilities, $next_of_kin, $relationship, $nationality, $state_of_origin, $local_government, $home_town, $home_address, $email, $password)
	{

		$sql = "INSERT INTO registrations (surname, last_name, gender, religion, residence, phone, disabilities, next_of_kin, relationship, nationality, state_of_origin, local_government, home_town, home_address, email, password) VALUES ('$surname', '$last_name', '$gender', '$religion', '$residence', '$phone', '$disabilities', '$next_of_kin', '$relationship', '$nationality', '$state_of_origin', '$local_government', '$home_town', '$home_address', '$email', '$password')";

		$submitted = mysqli_query($this->dbCon, $sql);

		return $submitted;
	}

	//Collect Email for Newsletter
	public function NewsletterEmail($email)
	{
		$sql = "INSERT INTO `newsletter_emails`(`email`) VALUES ('{$email}')";
		$addEmail = mysqli_query($this->dbCon, $sql);

		return $addEmail;
	}

	// Visitors' Contact Form Message
	public function ContactForm($fname, $email, $subject, $msg)
	{

		$sql = "INSERT INTO contact_form (fname, email, subject, msg) VALUES ('$fname', '$email', '$subject', '$msg')";

		$submitted = mysqli_query($this->dbCon, $sql);

		return $submitted;
	}

	/**
	 * @param mixed $email
	 * @param mixed $fullname
	 * @param mixed $subject
	 * @param mixed $body
	 * @param string $type
	 * @return void
	 */
	public function sendMail($email, $fullname, $subject, $caption, $body, $template = 'mails.template')
	{
		$Mailer = new Emailer();
		$EmailTemplate = new EmailTemplate($template);

		$EmailTemplate->email = $email;
		$EmailTemplate->fullname = $fullname;
		$EmailTemplate->subject = $subject;
		$EmailTemplate->caption = $caption;
		$EmailTemplate->mailbody = $body;

		$Mailer->SetTemplate($EmailTemplate);
		$Mailer->toEmail = "$email";
		$Mailer->toName = "CONSNOHE Admin";
		$Mailer->subject = "$subject";
		$Mailer->fromEmail = "admin@consnohe.org.ng";
		$Mailer->fromName = "Webmaster";
		return $Mailer->send();
	}
}
