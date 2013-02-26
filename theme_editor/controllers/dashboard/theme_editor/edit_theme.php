<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

class DashboardThemeEditorEditThemeController extends Controller {

	public function view($themeHandle = "") {
			$this->set('disableThirdLevelNav', true);
			$_SESSION['theme_editor']['handle'] = $themeHandle;
			$this->set('subnav', array(array(View::url('/dashboard/theme_editor/themes'), t('Theme Setup'), $globalSelected),array(View::url('/dashboard/theme_editor/help'), t('Help'))));
	}

	public function directoryToArray($directory, $recursive) {
	$me = basename($_SERVER['PHP_SELF']);
	$array_items = array();

			if ($handle = opendir($directory)) {
					while (false !== ($file = readdir($handle))) {
						if ($file != "." && $file != ".." && $file != $me && substr($file,0,1) != '.') {
									if (is_dir($directory. "/" . $file)) {
											if($recursive) {
													$array_items = array_merge($array_items, $this->directoryToArray($directory. "/" . $file, $recursive));
											}
						} else {
											$file = $directory . "/" . $file;
											$array_items[] = preg_replace("/\/\//si", "/", $file);
									}
							}
					}
					closedir($handle);
			asort($array_items);
	   }
			return $array_items;
	}

}

?>