<?php
/**
 * @author     Приходько Олег <shurup@e-mind.ru>
 * @package    Расширения для работы с файлами
 * @subpackage Контроллер для API работы с изображениями.
 * @version    Version 0.1
 */

class FileImagesUtil {
	/**
	 * Делает изобращение размером $height и шириной, высчитанной пропорционально и сохраняет файл в папку $desctination
	 * с именем $filename
	 *
	 * @access   public
	 * @since    0.1
	 *
	 * @param string $source
	 * @param string $destination
	 * @param string $filename
	 * @param int    $height
	 */
	public static function resizeImage ($source, $destination, $filename, $height = 128) {
		$f        = $source;
		$src      = imagecreatefromjpeg($f);
		$w_src    = imagesx($src);
		$h_src    = imagesy($src);
		$ratio    = $h_src/$height;
		$w_dest   = round($w_src/$ratio);
		$h_dest   = round($h_src/$ratio);
		$dest     = imagecreatetruecolor($w_dest, $h_dest);
		$img_mini = $destination.DIRECTORY_SEPARATOR.$filename;
		imagecopyresized($dest, $src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);
		imageJpeg($dest, $img_mini);
	}
} 