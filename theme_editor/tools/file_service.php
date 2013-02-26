<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

$page = Page::getByPath('/dashboard/theme_editor/');
$cp = new Permissions($page);
if (!$cp->canRead()) {
	die(t("Direct access is not allowed."));
}

if (strpos(trim($_REQUEST['file']), '..') !== false || strpos(trim($_REQUEST['file']), '~') !== false) {
    echo t('There was an error requesting that file.');
}
else {
if (isset($_REQUEST['method']) && trim($_REQUEST['method'] == "load"))
{
	if (isset($_REQUEST['file']) && trim($_REQUEST['file'] != "") && file_exists(DIR_FILES_THEMES.'/'.trim($_REQUEST['handle']).$filename))
	{
		$_SESSION['theme_editor']['file'] = trim($_REQUEST['file']);
		$file2open = fopen($_REQUEST['file'], "r");
		$current_data = @fread($file2open, filesize($_REQUEST['file']));
		echo htmlentities($current_data);
		fclose($file2open);
	}
	else {
		echo t('There was an error requesting that file.');
	}
}
if (isset($_POST['method']) && trim($_POST['method'] == "save"))
{
	if (isset($_REQUEST['file']) && trim($_REQUEST['file'] != "") && file_exists(DIR_FILES_THEMES.'/'.trim($_REQUEST['handle']).$filename))
	{
	 if (file_exists($_POST['file'])) {
		 $file2ed = fopen($_POST['file'], "w+");
		 $data_to_save = urldecode($_POST['contents']);
		 $data_to_save = stripslashes($data_to_save);
		 fwrite($file2ed,$data_to_save);
		 fclose($file2ed);
	 }
	 else {
	 	echo t('There was an error saving that file.');
	 }
	 }
	else {
		echo t('There was an error saving that file.');
	}
}
}
?>