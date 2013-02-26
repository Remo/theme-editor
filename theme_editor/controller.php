<?php

class ThemeEditorPackage extends Package {

    protected $pkgName = "Theme Editor";
    protected $pkgDescription  = "Edit your sites theme files from the dashboard.";
    protected $pkgHandle =  "theme_editor";
	protected $appVersionRequired = '5.3.2';
	protected $pkgVersion = '2.0';


	public function install()
	{
		$pkg = parent::install();
		$fh = Loader::helper('file');

		Loader::model('single_page');
		$p = SinglePage::add('dashboard/theme_editor',$pkg);
		if (is_object($p)) {
			$p->update(array('cName'=>'Theme Editor', 'cDescription'=>'Edit your theme files.'));
		}
		$p = SinglePage::add('dashboard/theme_editor/themes',$pkg);
		if (is_object($p)) {
			$p->update(array('cName'=>'Theme Setup'));
		}
		$p = SinglePage::add('dashboard/theme_editor/help',$pkg);
		if (is_object($p)) {
			$p->update(array('cName'=>'Help'));
		}
		SinglePage::add('dashboard/theme_editor/edit_theme',$pkg);

		//copy themes from PageThemes to ThemeEditorSetup
		$db = Loader::db();
		$db_sql = 'INSERT INTO ThemeEditorSetup(ptID,ptHandle,ptName,ptDescription,pkgID) SELECT ptID,ptHandle,ptName,ptDescription,pkgID FROM PageThemes';
		$db->Execute($db_sql);
	}

	public function uninstall() {
		$pkg = parent::uninstall();
	}

}
?>