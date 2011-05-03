<?php
/**
 * @package base
 * @version 0.4.0.0
 * @author Roman Konertz
 * @copyright (c) 2008-2010 by Roman Konertz
 * @license GPLv3
 * 
 * This file is part of Open-LIMS
 * Available at http://www.open-lims.org
 * 
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation;
 * version 3 of the License.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 * See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, see <http://www.gnu.org/licenses/>.
 */


/**
 * 
 */
require_once("interfaces/misc.interface.php");

/**
 * Misc Class
 * Contains misc. static methods
 * @package base
 */
class Misc implements MiscInterface
{

	/**
	 * Returns a byte-value in KiB/MiB etc.
	 * @param integer $byte
	 * @return string
	 */
	public static function calc_size($byte)
	{
		if ($byte == 0)
		{
		 	$act_filesize = "0&nbsp;Byte";
		}else
		{
		 	$tmp_filesize = floor($byte/1024);
		 	
		 	if ($tmp_filesize == 0)
		 	{
		 		$act_filesize = $byte."&nbsp;Byte";
		 	}
		 	else
		 	{
		 		$tmp_filesize = floor($tmp_filesize/1024);
		 		
		 		if ($tmp_filesize == 0)
		 		{
		 			$rounder = $byte/1024;
		 			$act_filesize = round($rounder,2)."&nbsp;KiB";
		 		}
		 		else
		 		{
		 			$tmp_filesize = floor($tmp_filesize/1024);
		 			if ($tmp_filesize == 0) 
		 			{
		 			
		 				$rounder = $byte/1048576;
		 				$act_filesize = round($rounder,2)."&nbsp;MiB";
		 			}
		 			else
		 			{
		 				$tmp_filesize = floor($tmp_filesize/1024);
		 				if ($tmp_filesize == 0)
		 				{
		 					$rounder = $byte/1073741824;
		 					$act_filesize = round($rounder,2)."&nbsp;GiB";
		 				}
		 				else
		 				{
		 					$tmp_filesize = floor($tmp_filesize/1024);
		 					$rounder = $byte/1099511627776;
		 					$act_filesize = round($rounder,2)."&nbsp;TiB";	
		 				}
		 			}
		 		}
		 	}
		 }
		 return $act_filesize;
	}
	
	/**
	 * @todo vars of different modules like project_id etc.
	 */
	public static function create_retrace_string()
	{
		$retrace_array = array();
		
		foreach ($_GET as $key => $value)
		{
			switch ($key):
				case "nav":
				case "run":
				case "dialog":
				case "action":
				case "id":
				case "project_id":
				case "sample_id":
				case "file_id":
					$retrace_array[$key] = $_GET[$key];
				break;
			endswitch;
		}
		
		return base64_encode(serialize($retrace_array));
	}
	
	public static function resovle_retrace_string($retrace_string)
	{
		if ($retrace_string)
		{
			$retrace_array = array();
			$retrace_array[username] = $_GET[username];
			$retrace_array[session_id] = $_GET[session_id];
			$retrace_array += unserialize(base64_decode($retrace_string));
			return $retrace_array;
		}
		else
		{
			return null;
		}
	}
}

?>