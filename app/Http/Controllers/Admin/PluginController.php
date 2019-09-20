<?php


namespace App\Http\Controllers\Admin;

use App\Helpers\Arr;
use Icetea\Admin\app\Http\Controllers\Controller;
use Prologue\Alerts\Facades\Alert;

class PluginController extends Controller
{
	public $data = [];
	
	public function __construct()
	{
		parent::__construct();
		$this->data['plugins'] = [];
	}
	
	public function index()
	{
		// Load all Plugins Services Provider
		$plugins = plugin_list();
		
		// Append the Plugin Options
		$plugins = collect($plugins)->map(function ($item, $key) {
			if (is_object($item)) {
				$item = Arr::fromObject($item);
			}
			
			if (isset($item['item_id']) && !empty($item['item_id'])) {
				$item['installed'] = plugin_check_purchase_code($item);
			}
			
			// Append the Options
			$pluginClass = plugin_namespace($item['name'], ucfirst($item['name']));
			$item['options'] = (method_exists($pluginClass, 'getOptions')) ? (array)call_user_func($pluginClass . '::getOptions') : null;
			$item = Arr::toObject($item);
			
			return $item;
		})->toArray();
		
		$this->data['plugins'] = $plugins;
		$this->data['title'] = 'Plugins';
		
		return view('admin::plugin', $this->data);
	}
	
	public function install($name)
	{
		// Get plugin details
		$plugin = load_plugin($name);
		
		// Install the plugin
		if (!empty($plugin)) {
				$res = call_user_func($plugin->class . '::install');
				
				// Result Notification
				if ($res) {
					Alert::success(trans('admin::messages.The plugin :plugin_name has been successfully installed', ['plugin_name' => $plugin->display_name]))->flash();
				} else {
					Alert::error(trans('admin::messages.Failed to install the plugin ":plugin_name"', ['plugin_name' => $plugin->display_name]))->flash();
				}

		}
		
		return redirect(admin_uri('plugins'));
	}
	
	public function uninstall($name)
	{
		// Get plugin details
		$plugin = load_plugin($name);
		
		// Uninstall the plugin
		if (!empty($plugin)) {
			$res = call_user_func($plugin->class . '::uninstall');
			
			// Result Notification
			if ($res) {
				plugin_clear_uninstall($name);
				
				Alert::success(trans('admin::messages.The plugin :plugin_name has been uninstalled', ['plugin_name' => $plugin->display_name]))->flash();
			} else {
				Alert::error(trans('admin::messages.Failed to Uninstall the plugin ":plugin_name"', ['plugin_name' => $plugin->display_name]))->flash();
			}
		}
		
		return redirect(admin_uri('plugins'));
	}
	
	public function delete($plugin)
	{
		return redirect(admin_uri('plugins'));
	}
}
