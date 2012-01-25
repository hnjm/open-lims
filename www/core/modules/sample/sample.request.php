<?php
/**
 * @package sample
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
 * Sample Request Class
 * @package sample
 */
class SampleRequest
{
	public static function ajax_handler()
	{
		global $sample_security;
		
		if ($_POST['get_array'])
		{
			$get_array = unserialize($_POST['get_array']);	
					
			if ($get_array['sample_id'])
			{
				$sample_security = new SampleSecurity($get_array['sample_id']);
			}
			else
			{
				$sample_security = new SampleSecurity(null);
			}
		}
		else
		{
			$sample_security = new SampleSecurity(null);
		}

		switch($_GET[run]):
	
			case "list_user_related_samples":
				require_once("ajax/sample.ajax.php");
				echo SampleAjax::list_user_related_samples($_POST[column_array], $_POST[css_page_id],  $_POST[css_row_sort_id], $_POST[entries_per_page], $_GET[page], $_GET[sortvalue], $_GET[sortmethod]);
			break;
			
			case "count_user_related_samples":
				require_once("ajax/sample.ajax.php");
				echo SampleAjax::count_user_related_samples();
			break;
			
			case "list_organisation_unit_related_samples":
				require_once("ajax/sample.ajax.php");
				echo SampleAjax::list_organisation_unit_related_samples($_POST[column_array], $_POST[argument_array], $_POST[css_page_id],  $_POST[css_row_sort_id], $_POST[entries_per_page], $_GET[page], $_GET[sortvalue], $_GET[sortmethod]);
			break;
			
			case "count_organisation_unit_related_samples":
				require_once("ajax/sample.ajax.php");
				echo SampleAjax::count_organisation_unit_related_samples($_POST[argument_array]);
			break;
			
			case "list_sample_items":
				require_once("ajax/sample.ajax.php");
				echo SampleAjax::list_sample_items($_POST[column_array], $_POST[argument_array], $_POST[css_page_id],  $_POST[css_row_sort_id], $_POST[entries_per_page], $_GET[page], $_GET[sortvalue], $_GET[sortmethod]);
			break;
			
			case "count_sample_items":
				require_once("ajax/sample.ajax.php");
				echo SampleAjax::count_sample_items($_POST[argument_array]);
			break;
			
			case "list_samples_by_item_id":
				require_once("ajax/sample.ajax.php");
				echo SampleAjax::list_samples_by_item_id($_POST[column_array], $_POST[argument_array], $_POST[css_page_id],  $_POST[css_row_sort_id], $_POST[entries_per_page], $_GET[page], $_GET[sortvalue], $_GET[sortmethod]);
			break;
			
			case "count_samples_by_item_id":
				require_once("ajax/sample.ajax.php");
				echo SampleAjax::count_samples_by_item_id($_POST[argument_array]);
			break;
			
			case "list_location_history":
				require_once("ajax/sample.ajax.php");
				echo SampleAjax::list_location_history($_POST[column_array], $_POST[argument_array], $_POST[css_page_id],  $_POST[css_row_sort_id], $_POST[entries_per_page], $_GET[page], $_GET[sortvalue], $_GET[sortmethod]);
			break;
			
			case "count_location_history":
				require_once("ajax/sample.ajax.php");
				echo SampleAjax::count_location_history($_POST[argument_array]);
			break;
			
			case "get_sample_menu":
				require_once("ajax/sample.ajax.php");
				echo SampleAjax::get_sample_menu($_POST[get_array]);
			break;
			
			case "get_sample_information":
				require_once("ajax/sample.ajax.php");
				echo SampleAjax::get_sample_information($_POST[get_array]);
			break;
			
			case "delete":
				require_once("ajax/sample.ajax.php");
				echo SampleAjax::delete($_POST[get_array]);
			break;
			
			case "delete_handler":
				require_once("ajax/sample.ajax.php");
				echo SampleAjax::delete_handler($_POST[get_array]);
			break;
			
			
			// Search
			
			case "search_sample_list_samples":
				require_once("ajax/sample_search.ajax.php");
				echo SampleSearchAjax::list_samples($_POST[column_array], $_POST[argument_array], $_POST[css_page_id],  $_POST[css_row_sort_id], $_POST[entries_per_page], $_GET[page], $_GET[sortvalue], $_GET[sortmethod]);
			break;
			
			case "search_sample_count_samples":
				require_once("ajax/sample_search.ajax.php");
				echo SampleSearchAjax::count_samples($_POST[argument_array]);
			break;
			
			case "search_sample_data_list_samples":
				require_once("ajax/sample_data_search.ajax.php");
				echo SampleDataSearchAjax::list_samples($_POST[column_array], $_POST[argument_array], $_POST[css_page_id],  $_POST[css_row_sort_id], $_POST[entries_per_page], $_GET[page], $_GET[sortvalue], $_GET[sortmethod]);
			break;
			
			case "search_sample_data_count_samples":
				require_once("ajax/sample_data_search.ajax.php");
				echo SampleDataSearchAjax::count_samples($_POST[argument_array]);
			break;
			
			
			// Admin
			
			case "admin_list_user_permissions":
				require_once("ajax/sample_admin.ajax.php");
				echo SampleAdminAjax::list_user_permissions($_POST[column_array], $_POST[argument_array], $_POST[get_array], $_POST[css_page_id],  $_POST[css_row_sort_id], $_POST[entries_per_page], $_GET[page], $_GET[sortvalue], $_GET[sortmethod]);
			break;
			
			case "admin_count_user_permissions":
				require_once("ajax/sample_admin.ajax.php");
				echo SampleAdminAjax::count_user_permissions($_POST[argument_array]);
			break;
			
			case "admin_list_organisation_unit_permissions":
				require_once("ajax/sample_admin.ajax.php");
				echo SampleAdminAjax::list_organisation_unit_permissions($_POST[column_array], $_POST[argument_array], $_POST[get_array], $_POST[css_page_id],  $_POST[css_row_sort_id], $_POST[entries_per_page], $_GET[page], $_GET[sortvalue], $_GET[sortmethod]);
			break;
			
			case "admin_count_organisation_unit_permissions":
				require_once("ajax/sample_admin.ajax.php");
				echo SampleAdminAjax::count_organisation_unit_permissions($_POST[argument_array]);
			break;
			
		
		endswitch;
	}
	
	/**
	 * @throws SampletSecurityAccessDeniedException
	 */
	public static function io_handler()
	{
		global $sample_security, $session, $transaction;
		
		if ($_GET[sample_id])
		{
			$sample_security = new SampleSecurity($_GET[sample_id]);
					
			require_once("io/sample_common.io.php");
 			SampleCommon_IO::tab_header();
		}
		else
		{
			$sample_security = new SampleSecurity(null);
		}
			
		switch($_GET[run]):
		
			case ("new"):
			case ("new_subsample"):
				require_once("io/sample.io.php");
				SampleIO::create(null,null,null);
			break;
			
			case ("clone"):
				require_once("io/sample.io.php");
				SampleIO::clone_sample(null, null);
			break;
			
			case ("organ_unit"):
				require_once("io/sample.io.php");
				SampleIO::list_organisation_unit_related_samples();
			break;
			
			case("detail"):
				require_once("io/sample.io.php");
				SampleIO::detail();
			break;
			
			case("move"):
				require_once("io/sample.io.php");
				SampleIO::move();
			break;
			
			case("set_availability"):
				require_once("io/sample.io.php");
				SampleIO::set_availability();
			break;
			
			case("location_history"):
				require_once("io/sample.io.php");
				SampleIO::location_history();
			break;

			// Administration
			
			case ("delete"):
				require_once("io/sample_admin.io.php");
				SampleAdminIO::delete();
			break;
							
			case ("rename"):
				require_once("io/sample_admin.io.php");
				SampleAdminIO::rename();
			break;
			
			case("admin_permission_user"):
				require_once("io/sample_admin.io.php");
				SampleAdminIO::user_permission();
			break;
			
			case("admin_permission_user_add"):
				require_once("io/sample_admin.io.php");
				SampleAdminIO::user_permission_add();
			break;
			
			case("admin_permission_user_delete"):
				require_once("io/sample_admin.io.php");
				SampleAdminIO::user_permission_delete();
			break;
			
			case("admin_permission_ou"):
				require_once("io/sample_admin.io.php");
				SampleAdminIO::ou_permission();
			break;
			
			case("admin_permission_ou_add"):
				require_once("io/sample_admin.io.php");
				SampleAdminIO::ou_permission_add();
			break;
			
			case("admin_permission_ou_delete"):
				require_once("io/sample_admin.io.php");
				SampleAdminIO::ou_permission_delete();
			break;
				
			
			// Item Lister
			/**
			 * @todo errors
			 */
			case("item_list"):
				if ($sample_security->is_access(1, false) == true)
				{
					if ($_GET[dialog])
					{
						if ($_GET[dialog] == "data")
						{
							$path_stack_array = array();
							
					    	$folder_id = SampleFolder::get_folder_by_sample_id($_GET[sample_id]);
					    	$folder = Folder::get_instance($folder_id);
					    	$init_array = $folder->get_object_id_path();
					    	
					    	foreach($init_array as $key => $value)
					    	{
					    		$temp_array = array();
					    		$temp_array[virtual] = false;
					    		$temp_array[id] = $value;
					    		array_unshift($path_stack_array, $temp_array);
					    	}
							
					    	if (!$_GET[folder_id])
					    	{
					    		$session->write_value("stack_array", $path_stack_array, true);
					    	}
						}
						
						$module_dialog = ModuleDialog::get_by_type_and_internal_name("item_list", $_GET[dialog]);
						
						if (file_exists($module_dialog[class_path]))
						{
							require_once($module_dialog[class_path]);
							
							if (class_exists($module_dialog['class']) and method_exists($module_dialog['class'], $module_dialog[method]))
							{
								$module_dialog['class']::$module_dialog[method]("sample", $_GET[sample_id], true, false);
							}
							else
							{
								// Error
							}
						}
						else
						{
							// Error
						}
					}
					else
					{
						// error
					}
				}
				else
				{
					throw new SampleSecurityAccessDeniedException();
				}
			break;
			
			case("item_add"):
				if ($sample_security->is_access(2, false) == true)
				{
					if ($_GET[dialog])
					{
						$module_dialog = ModuleDialog::get_by_type_and_internal_name("item_add", $_GET[dialog]);

						if (is_array($module_dialog) and $module_dialog[class_path])
						{
							if (file_exists($module_dialog[class_path]))
							{
								require_once($module_dialog[class_path]);
								
								if (class_exists($module_dialog['class']) and method_exists($module_dialog['class'], $module_dialog[method]))
								{
									$sample_item = new SampleItem($_GET[sample_id]);
									$sample_item->set_gid($_GET[key]);
									
									$description_required = $sample_item->is_description_required();
									$keywords_required = $sample_item->is_keywords_required();
									
									if (($description_required and !$_POST[description] and !$_GET[idk_unique_id]) or ($keywords_required and !$_POST[keywords] and !$_GET[idk_unique_id]))
									{
										require_once("core/modules/item/io/item.io.php");
										ItemIO::information(http_build_query($_GET), $description_required, $keywords_required);
									}
									else
									{
										$transaction_id = $transaction->begin();
										
										$sample = new Sample($_GET[sample_id]);
										$current_requirements = $sample->get_requirements();
										
										$folder_id = SampleFolder::get_folder_by_sample_id($_GET[sample_id]);
										
										$sub_folder_id = $sample->get_sub_folder($folder_id, $_GET[key]);				
						
										if (is_numeric($sub_folder_id))
										{
											$folder_id = $sub_folder_id;
										}
										
										$return_value = $module_dialog['class']::$module_dialog[method]($current_requirements[$_GET[key]][type_id], $current_requirements[$_GET[key]][category_id], null, $folder_id);
										
										/**
										 * @todo remove after rebuild all item add dialogs (including "associate sample")
										 */
										if (is_numeric($return_value))
										{
											if ($_GET[retrace])
											{
												$params = http_build_query(Retrace::resovle_retrace_string($_GET[retrace]),'','&#38;');
											}
											else
											{
												$paramquery[username] = $_GET[username];
												$paramquery[session_id] = $_GET[session_id];
												$paramquery[nav] = "home";
												$params = http_build_query($paramquery,'','&#38;');
											}
											
											// EVIL !!
											if ($_GET[dialog] == "parentsample")
											{
												$parent_sample_id = Sample::get_entry_by_item_id($return_value);
												if ($parent_sample_id)
												{
													if (SampleItemFactory::create($parent_sample_id, $sample->get_item_id() , $_GET[key], $_POST[keywords], $_POST[description], true) == true)
													{
														if ($transaction_id != null)
														{
															$transaction->commit($transaction_id);
														}
														Common_IO::step_proceed($params, "Add Item", "Successful." ,null);
													}
													else
													{
														if ($transaction_id != null)
														{
															$transaction->rollback($transaction_id);
														}
														Common_IO::step_proceed($params, "Add Item", "Failed." ,null);	
													}
												}
												else
												{
													if ($transaction_id != null)
													{
														$transaction->rollback($transaction_id);
													}
													Common_IO::step_proceed($params, "Add Item", "Failed." ,null);	
												}
											}
											else
											{
												if (SampleItemFactory::create($_GET[sample_id], $return_value, $_GET[key], $_POST[keywords], $_POST[description]) == true)
												{
													if ($transaction_id != null)
													{
														$transaction->commit($transaction_id);
													}
													Common_IO::step_proceed($params, "Add Item", "Successful." ,null);
												}
												else
												{
													if ($transaction_id != null)
													{
														$transaction->rollback($transaction_id);
													}
													Common_IO::step_proceed($params, "Add Item", "Failed." ,null);	
												}
											}
										}
										else
										{
											if ($return_value === false)
											{
												if ($transaction_id != null)
												{
													$transaction->rollback($transaction_id);
												}
												throw new ModuleDialogFailedException("",1);
											}
											else
											{
												if ($transaction_id != null)
												{
													$transaction->commit($transaction_id);
												}
											}
										}
									}
								}
								else
								{
									throw new ModuleDialogCorruptException(null, null);
								}
							}
							else
							{
								throw new ModuleDialogCorruptException(null, null);
							}
						}
						else
						{
							throw new ModuleDialogNotFoundException(null, null);
						}
					}
					else
					{
						throw new ModuleDialogMissingException(null, null);
					}
				}
				else
				{
					throw new SampleSecurityAccessDeniedException();
				}
			break;
				
			// Parent Item Lister
			case("parent_item_list"):
				if ($sample_security->is_access(1, false) == true)
				{
					if ($_GET[dialog])
					{
						$sample = new Sample($_GET[sample_id]);
						$item_id = $sample->get_item_id();
						$module_dialog = ModuleDialog::get_by_type_and_internal_name("parent_item_list", $_GET[dialog]);
						
						if (file_exists($module_dialog[class_path]))
						{
							require_once($module_dialog[class_path]);
							
							if (class_exists($module_dialog['class']) and method_exists($module_dialog['class'], $module_dialog[method]))
							{
								$module_dialog['class']::$module_dialog[method]($item_id);
							}
							else
							{
								// Error
							}
						}
						else
						{
							// Error
						}
					}
					else
					{
						// error
					}
				}
				else
				{
					throw new SampleSecurityAccessDeniedException();
				}
			break;
			
			// Common Dialogs
			/**
			 * @todo errors, exceptions
			 */
			case("common_dialog"):
				if ($_GET[dialog])
				{
					$module_dialog = ModuleDialog::get_by_type_and_internal_name("common_dialog", $_GET[dialog]);
					
					if (file_exists($module_dialog[class_path]))
					{
						require_once($module_dialog[class_path]);
						
						if (class_exists($module_dialog['class']) and method_exists($module_dialog['class'], $module_dialog[method]))
						{
							$module_dialog['class']::$module_dialog[method]();
						}
						else
						{
							// Error
						}
					}
					else
					{
						// Error
					}
				}
				else
				{
					// error
				}
			break;
				
			// Search
			/**
			 * @todo errors, exceptions
			 */
			case("search"):
				if ($_GET[dialog])
				{
					$module_dialog = ModuleDialog::get_by_type_and_internal_name("search", $_GET[dialog]);
					
					if (file_exists($module_dialog[class_path]))
					{
						require_once($module_dialog[class_path]);
						
						if (class_exists($module_dialog['class']) and method_exists($module_dialog['class'], $module_dialog[method]))
						{
							$module_dialog['class']::$module_dialog[method]();
						}
						else
						{
							// Error
						}
					}
					else
					{
						// Error
					}
				}
				else
				{
					// error
				}
			break;
			
			default:
				require_once("io/sample.io.php");
				SampleIO::list_user_related_samples(null);
			break;
		
		endswitch;
	}
}
?>