<?php
/**
 * @package manufacturer
 * @version 0.4.0.0
 * @author Roman Konertz <konertz@open-lims.org>
 * @copyright (c) 2008-2011 by Roman Konertz
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
 * Manufacturer IO Class
 * @package manufacturer
 */
class ManufacturerIO
{
	public static function dialog()
	{
		if ($GLOBALS['autoload_prefix'])
		{
			$path_prefix = $GLOBALS['autoload_prefix'];
		}
		else
		{
			$path_prefix = "";
		}
		$template = new Template($GLOBALS['autoload_prefix']."template/manufacturer/dialog.html");
		return $template->get_string();
	}
	
	public static function add()
	{
		$template = new Template("template/manufacturer/add.html");
		return $template->get_string();
	}
	
	public static function list_manufacturers()
	{
		$template = new Template("template/manufacturer/list.html");
		$template->set_var("ADD_DIALOG", self::add());
		$template->output();
	}
}
?>