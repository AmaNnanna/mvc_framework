<?

/*
 * Copyright (C) 2014-2023 Golojan IBS Corp.
 * Distributed under the terms of the license described in COPYING
 */
// constants
define("appname","");
define('app_title','');
define('appid','1');
define("version","2.0.0");
define("debug",true);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('DIR', __DIR__);
define("display_error",true);
define("language","en_US");
define("url",__DIR__);
define("baseurl",__DIR__);
define("apps_dir","./_apps/");
define("templates_dir","./templates/");
define("templates_default","404");
define("templates_default_route","/error/404/");
define("vendor_dir","./vendor/");
define("assets_dir","./templates/assets");
define("admin_assets_dir","./templates/admin/assets");
define("visitors_assets_dir","./templates/visitors/assets");
define("layouts_dir","./templates/layouts/");
define("template_file_extension","php");
define("store_dir","./_store/");
define("public_dir","./_public/");
define("plugins_dir","./templates/_plugins/");
define("server","remote");
define("use_token_security",true);
define("encrypt_salt","7WAO342QFANYJJ534D569WL3VMT920VB5NQMW");
define("default_timezone","Africa/Lagos");
define("offset_timezone",true);
define("session_path","./_sessions/");
define("session_timout",20);
define("session_delete_timout",30);
define("auth_session_key","logged_in");
define("auth_url","/admin");
define("domain", "");
define("enable_DKIM_keys", false);

define("db_host","localhost");

define("db_user","");
define("db_password","");
define("db","");
define("db_port",null);
define("db_charset","utf8");
define("db_socket",null);
