<?php 

defined('C5_EXECUTE') or die(_("Access Denied."));
class DashboardThemeEditorThemesController extends Controller {

	protected $helpers = array('html');

	public function view() {

		$tArray = array();
		$tArray2 = array();

		$tArray = PageTheme::getList();
		$tArray2 = PageTheme::getAvailableThemes();

		$this->set('tArray', $tArray);
		$this->set('tArray2', $tArray2);
		$siteThemeID = 0;
		$obj = PageTheme::getSiteTheme();
		if (is_object($obj)) {
			$siteThemeID = $obj->getThemeID();
		}

		$this->set('siteThemeID', $siteThemeID);
		$this->set('subnav', array(array(View::url('/dashboard/theme_editor/themes'), t('Theme Setup'), $globalSelected),array(View::url('/dashboard/theme_editor/help'), t('Help'))));
	}

	public function on_view() {

		$tArray = array();
		$tArray2 = array();

		$tArray = PageTheme::getList();
		$tArray2 = PageTheme::getAvailableThemes();

		$this->set('tArray', $tArray);
		$this->set('tArray2', $tArray2);
		$siteThemeID = 0;
		$obj = PageTheme::getSiteTheme();
		if (is_object($obj)) {
			$siteThemeID = $obj->getThemeID();
		}

		$this->set('siteThemeID', $siteThemeID);
		$this->set('subnav', array(array(View::url('/dashboard/theme_editor/themes'), t('Theme Setup'), $globalSelected),array(View::url('/dashboard/theme_editor/help'), t('Help'))));
	}

	public function on_start() {
		$this->set('subnav', array(array(View::url('/dashboard/theme_editor/themes'), t('Theme Setup'), $globalSelected),array(View::url('/dashboard/theme_editor/help'), t('Help'))));
	}

	public function isPrepared($themeHandle) {
		if (is_dir(DIR_FILES_THEMES.'/'.$themeHandle) ) {
			$isInThemes = 1;
		}
		else {
			$isInThemes = 0;
		}
		$db = Loader::db();
		$sql = "SELECT isPrepared FROM ThemeEditorSetup WHERE ptHandle=?";
		$result = $db->Execute($sql,array($themeHandle));
		$row =  $result->FetchRow();
		if ($row['isPrepared'] == 1 && $isInThemes == 1) { return $themePrepared = true;};

	}

	public function prepare($themeHandle) {
		$theme = PageTheme::getByHandle($themeHandle);
		if (!is_object($theme)) {
			echo "Invalid theme.";
			die();
		}
		$themeDirectory = $theme->getThemeDirectory();

		$this->recurse_copy($themeDirectory,DIR_FILES_THEMES.'/'.$themeHandle);

		$db = Loader::db();

		$db_sql = "SELECT ptID FROM ThemeEditorSetup WHERE ptHandle=?";
		$rows = $db->Execute($db_sql,$themeHandle);
		$rowCount = $rows->numRows();

		if ($rowCount == 0) {
			$sql = "INSERT INTO ThemeEditorSetup(ptID,ptHandle,ptName,ptDescription,pkgID) SELECT * FROM PageThemes WHERE ptHandle=?";
			$db->Execute($sql,array($themeHandle));
		}

			$sql = "UPDATE ThemeEditorSetup SET isPrepared=1 WHERE ptHandle=?";
			$db->Execute($sql,array($themeHandle));

			$sql = "UPDATE PageThemes SET pkgID=0 WHERE ptHandle=?";
			$db->Execute($sql,array($themeHandle));

		$tArray = array();
		$tArray2 = array();
		$tArray = PageTheme::getList();
		$tArray2 = PageTheme::getAvailableThemes();
		$this->set('tArray', $tArray);
		$this->set('tArray2', $tArray2);
		$this->set('subnav', array(array(View::url('/dashboard/theme_editor/themes'), t('Theme Setup'), $globalSelected),array(View::url('/dashboard/theme_editor/help'), t('Help'))));
	}

	public function restore($themeHandle) {
		$theme = PageTheme::getByHandle($themeHandle);
		if (!is_object($theme)) {
			echo "Invalid theme.";
			die();
		}
		$themeDirectory = $theme->getThemeDirectory();
		$this->recurse_delete(DIR_FILES_THEMES.'/'.$themeHandle);
		$db = Loader::db();
		$sql = "UPDATE ThemeEditorSetup SET isPrepared=0 WHERE ptHandle=?";
		$db->Execute($sql,array($themeHandle));

		$db_sql = "SELECT pkgID FROM ThemeEditorSetup WHERE ptHandle=?";
		$result = $db->Execute($db_sql,$themeHandle);
		$row =  $result->FetchRow();
		$packID = $row['pkgID'];

		if ($packID != 0) {
			$sql = "UPDATE PageThemes SET pkgID = '$packID' WHERE ptHandle = ?";
			$db->Execute($sql,array($themeHandle));
		}

		$tArray = array();
		$tArray2 = array();
		$tArray = PageTheme::getList();
		$tArray2 = PageTheme::getAvailableThemes();
		$this->set('tArray', $tArray);
		$this->set('tArray2', $tArray2);
		$this->set('subnav', array(array(View::url('/dashboard/theme_editor/themes'), t('Theme Setup'), $globalSelected),array(View::url('/dashboard/theme_editor/help'), t('Help'))));
	}

	public function recurse_delete($dir) {
		   if (is_dir($dir)) {
			 $objects = scandir($dir);
			 foreach ($objects as $object) {
			   if ($object != "." && $object != "..") {
				 if (filetype($dir."/".$object) == "dir") $this->recurse_delete($dir."/".$object); else unlink($dir."/".$object);
			   }
			 }
			 reset($objects);
			 rmdir($dir);
		   }
	 }


	public function recurse_copy($src,$dst) {
		$dir = opendir($src);
		@mkdir($dst);
		while(false !== ( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' )) {
				if ( is_dir($src . '/' . $file) ) {
					$this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
				}
				else {
					copy($src . '/' . $file,$dst . '/' . $file);
				}
			}
		}
		closedir($dir);
	}

}

?>