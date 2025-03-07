    
<?php

use Apps\Template;
use Apps\Core;

define('DOT', '.');
require_once(DOT . "/bootstrap.php");

$Route = new Apps\Route;

//Home page//
$Route->add('/', function () {

    $Core = new Apps\Core;
    $Template = new Apps\Template;

    $Template->addheader("layouts.header");
    $Template->addfooter("layouts.footer");

    $Template->assign("title", "");
    $Template->assign("haspage", false);
    $Template->assign("menukey", "home");

    $Template->render("home");
}, 'GET');

//Other pages//
$Route->add("/{shortname}", function ($shortname) {

    $Core = new Apps\Core;
    $Template = new Apps\Template;

    $Template->addheader("layouts.header");
    $Template->addfooter("layouts.footer");

    $Template->assign("haspage", true);
    $Template->assign("menukey", $shortname);

    if ($shortname == "about-us") {
        $Template->assign("title", "Who we Are!");
    } elseif ($shortname == "contact-us") {
        $Template->assign("title", "Reach Us.");
    } else {
        $Template->assign("title", "");
    }
    $Template->render("pages.{$shortname}");
}, 'GET');

//Visitors' Contact Form Message
$Route->add("/contact_form", function () {
    $Core = new Apps\Core;
    $Template = new Apps\Template;

    $data = $Core->post($_POST);

    $fname = $data->fname;
    $email = $data->email;
    $subject = $data->subject;
    $msg = $data->msg;

    $messageSent = (int)$Core->ContactForm($fname, $email, $subject, $msg);

    if ($messageSent) {

        $subject = "{$fname} sent a new message for {$subject}";
        $body = "<h5>{$fname} just sent this message from contact form.</h5>
                    <p> Here are the details of the Message. <br />
                     Sender: {$fname} <br />
                     Email: {$email} <br />
                     <h5>Message Details</h5><br />
                     {$msg} <br />
                     </p>
                    ";
        $Core->sendMail("info@website.com", "Company", $subject, "New message from contact form", $body);

        $Template->setError("You message was sent successfully.", "success", "/");
        $Template->redirect("/");
    }

    $Template->setError("Oops! That didn't work. Want to try again?", "warning", "/pages/contact");
    $Template->redirect("/pages/contact");
}, 'POST');


//Logout session//
$Route->add("/admin/logout", function () {
    $Template = new Apps\Template;
    $Template->expire();
    $Template->redirect("/admin");
}, 'GET');
//Logout sessions ends//

$Route->run('/');
