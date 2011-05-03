<?php
/**
 * @package project
 * @version 0.4.0.0
 * @author Roman Konertz
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
 * 
 */
if (constant("UNIT_TEST") == false or !defined("UNIT_TEST"))
{
	require_once("events/project_folder_create_event.class.php");
	
	require_once("access/project_has_folder.access.php");
}

/**
 * Project Folder Class
 * @package project
 */
class ProjectFolder extends Folder implements ConcreteFolderCaseInterface
{
  	private $project_folder;
	private $project_id;
  	
  	/**
  	 * @param integer $folder_id
  	 */
	function __construct($folder_id)
	{
		if (is_numeric($folder_id))
  		{
  			parent::__construct($folder_id);
  			$this->project_folder = new ProjectHasFolder_Access($folder_id);
  			$this->project_id = $this->project_folder->get_project_id();
  			
  			if ($this->project_id)
  			{
  				$project_security = new ProjectSecurity($this->project_id);
  				
  				if ($this->get_automatic == false)
  				{
  					$permission_bin = decbin($this->get_permission());
					$permission_bin = str_pad($permission_bin, 16, "0", STR_PAD_LEFT);
					$permission_bin = strrev($permission_bin);		
  				}
  				
  				if ($this->read_access == false)
  				{
  					if ($this->get_automatic() == true)
  					{
  						if ($project_security->is_access(1, false) or $project_security->is_access(2, false))
						{
							$this->read_access = true;
						}
  					}
  					else
  					{
	  					if ($permission_bin{8} == "1" and ($project_security->is_access(1, false) or $project_security->is_access(2, false)))
						{
							$this->read_access = true;
						}
  					}
  				}
  				
  				if ($this->write_access == false)
  				{
  					if ($this->get_automatic() == true)
  					{
  						if ($project_security->is_access(3, false) or $project_security->is_access(4, false))
						{
							$this->write_access = true;
						}
  					}
  					else
  					{
	  					if ($permission_bin{9} == "1" and ($project_security->is_access(3, false) or $project_security->is_access(4, false)))
						{
							$this->write_access = true;
						}
  					}
  				}
  				
  				if ($this->delete_access == false)
  				{
  					if ($this->get_automatic() == true)
  					{
  						if ($project_security->is_access(5, false))
						{
							$this->delete_access = true;
						}
  					}
  					else
  					{
	  					if ($permission_bin{10} == "1" and $project_security->is_access(5, false))
						{
							$this->delete_access = true;
						}
  					}
  				}
  				
  				if ($this->control_access == false)
  				{
  					if ($this->get_automatic() == true)
  					{
  						if ($project_security->is_access(7, false))
						{
							$this->control_access = true;
						}
  					}
  					else
  					{
	  					if ($permission_bin{11} == "1" and $project_security->is_access(7, false))
						{
							$this->control_access = true;
						}
  					}
  				}
  			}
  		}
  		else
  		{
  			parent::__construct(null);
  			$this->project_folder = null;
  			$this->project_id = null;
  		}
  	}
  	
	function __destruct()
	{
		unset($this->project_folder);
		unset($this->project_id);
		parent::__destruct();
	}
	
	/**
	 * Creates a new Project Folder including Folder
	 * @param integer $project_id
	 * @return integer
	 * @todo: remove v-folder
	 */
	public function create($project_id, $base_folder_id)
	{
		if (is_numeric($project_id))
		{
			$project = new Project($project_id);
			
			// Folder
			if ($base_folder_id == null)
			{
				$project_folder_id = $GLOBALS[project_folder_id];
			}
			else
			{
				$project_folder_id = $base_folder_id;
			}
			
			$folder = new Folder($project_folder_id);

			$path = new Path($folder->get_path());
			$path->add_element($project_id);
			
			if (($folder_id = parent::create($project->get_name(), $project_folder_id, $path->get_path_string(), $project->get_owner_id(), null)) != null)
			{
				$project_has_folder_access = new ProjectHasFolder_Access(null);
				if ($project_has_folder_access->create($project_id, $folder_id) == null)
				{
					return null;
				}
				if ($this->set_flag(16) == false)
				{
					$this->delete(true, true);
					return null;
				}
				
				// Virtual Folder				
				$project_folder_create_event = new ProjectFolderCreateEvent($folder_id);
				$event_handler = new EventHandler($project_folder_create_event);
				
				if ($event_handler->get_success() == false)
				{
					$this->delete();
					return false;
				}
				else
				{
					return $folder_id;
				}
			}
			else
			{
				return null;
			}
		}
		else
		{
			return null;
		}
	}
	
	// Wird �ber konkretisierung automatisch �ber Folder ausgef�hrt,
	// kann aber auch direkt ausgef�hrt werden (wenn Klasse bekannt)
	/**
	 * @param bool $recursive
	 * @param bool $content
	 * @return bool
	 */
	public function delete($recursive, $content)
	{
		global $transaction;
		
		if ($this->project_id)
		{
			$transaction_id = $transaction->begin();
			
			if ($this->project_folder->delete() == true)
			{
				if (parent::delete($recursive, $content) == true)
				{
					if ($transaction_id != null)
					{
						$transaction->commit($transaction_id);
					}
					return true;
				}
				else
				{
					if ($transaction_id != null)
					{
						$transaction->rollback($transaction_id);
					}
					return false;
				}
			}
			else
			{
				if ($transaction_id != null)
				{
					$transaction->rollback($transaction_id);
				}
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function get_quota_access($user_id, $filesize)
	{
		if (parent::get_quota_access($user_id, $filesize) == true)
		{
			$project = new Project($project_id);
			$project_quota = $project->get_quota();
			$project_filesize = $project->get_filesize();
											
			$new_project_filesize = $project_filesize + $filesize;
			
			if (($project_quota > $new_project_filesize or $project_quota == 0))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function increase_filesize($user_id, $filesize)
	{
		if (parent::increase_filesize($user_id, $filesize) == true)
		{
			$project = new Project($project_id);
			$project_filesize = $project->get_filesize();
											
			$new_project_filesize = $project_filesize + $filesize;
			
			return $project->set_filesize($new_project_filesize);
		}
		else
		{
			return false;
		}
	}
	
	
	/**
	 * Checks if $folder_id is a case of Project Folder
	 * @param integer $folder_id
	 * @return bool
	 */
	public static function is_case($folder_id)
	{
		if (is_numeric($folder_id))
		{
			$project_has_folder_access = new ProjectHasFolder_Access($folder_id);
			if ($project_has_folder_access->get_project_id())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public static function get_folder_by_project_id($project_id)
	{
		return ProjectHasFolder_Access::get_entry_by_project_id($project_id);
	}
	
	/**
	 * @param integer $project_id
	 * @return integer
	 */
	public static function get_supplementary_folder($project_id)
	{
		if ($project_id)
		{
			$project_folder_id = self::get_folder_by_project_id($project_id);
			$folder_array = Folder_Access::list_entries_by_toid($project_folder_id);
			
			foreach($folder_array as $key => $value)
			{
				$folder_access = new Folder_Access($value);
				
				$path = new Path($folder_access->get_path());
				$path_array = $path->get_path_elements();
				
				if ($path_array[$path->get_path_length()] == "supplementary")
				{   // If supplement-folder is found
					return $value;	
				}	
			}
			return null;	
		}
		else
		{
			return null;
		}
	}
}
?>