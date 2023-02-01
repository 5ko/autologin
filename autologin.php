<?php if (!defined('PmWiki')) exit();
/**
  Autologin: PmWiki module for automatic login from a special URL.
  Written by (c) Petko Yotov 2022-2023   www.pmwiki.org/support

  This text is written for PmWiki; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published
  by the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version. See pmwiki.php for full details
  and lack of warranty.
  
  This can be configured in .htaccess:
  
  RewriteEngine On
  RewriteBase /
  RewriteRule ^your-custom-URL$ index.php?action=autologin&rq=$0  [L]
  
  Then your contacts can be automatically signed in, by visiting:
    https://your-wiki.org/your-custom-URL
  
*/
$RecipeInfo['AutoLogin']['Version'] = '20230131';

$HandleActions['autologin'] = 'HandleAutologin';
function HandleAutologin($pagename) {
  global $AuthList, $Modules;

  if(isset($_GET['rq'])) {
    
    pm_session_start();
    
    foreach($Modules['autologin']['rq'] as $path=>$x) {
      if($_GET['rq'] === $path) {
        $_SESSION['authlist'][$x] = $AuthList[$x] = 1;
        $_SESSION['authlist']["-$x"] = $AuthList["-$x"] = -1;
      }
    }
  }
  Redirect($pagename);
}

