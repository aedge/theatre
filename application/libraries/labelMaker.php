<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class labelMaker {
	
	private function mailMerge($templateFile, $newFile, $row)
	{
		if (!copy($templateFile, $newFile))  // make a duplicate so we dont overwrite the template
		return false; // could not duplicate template
		$zip = new ZipArchive();
		if ($zip->open($newFile, ZIPARCHIVE::CHECKCONS) !== TRUE)
		return false; // probably not a docx file
		$file = substr($templateFile, -4) == '.odt' ? 'content.xml' : 'word/document.xml';
		$data = $zip->getFromName($file);
		foreach ($row as $key => $value)
		$data = str_replace($key, $value, $data);
		$zip->deleteName($file);
		$zip->addFromString($file, $data);
		$zip->close();
		return true;
	}
}

?>