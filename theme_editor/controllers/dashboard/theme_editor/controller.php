<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

class DashboardThemeEditorController extends Controller {

	public function __construct() {
		$this->redirect('/dashboard/theme_editor/themes');
		$this->set('subnav', array(array(View::url('/dashboard/theme_editor/themes'), t('Theme Setup'), $globalSelected),array(View::url('/dashboard/theme_editor/help'), t('Help'))));
	}

}

?>