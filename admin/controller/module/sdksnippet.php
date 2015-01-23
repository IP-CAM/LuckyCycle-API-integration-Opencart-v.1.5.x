<?php
class ControllerModuleSdksnippet extends Controller {
	private $error = array(); // This is used to set the errors, if any.

    public function install() {
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "luckycycle_sdksnippet` (
		  `id_poke` int(11) NOT NULL auto_increment,
          `hash` varchar(255) COLLATE utf8_bin,
          `banner_url` varchar(255) COLLATE utf8_bin,
          `type` varchar(255) COLLATE utf8_bin,
          `id_customer` varchar(255) COLLATE utf8_bin,
          `id_order` varchar(255) COLLATE utf8_bin,
          `create_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
          `operation_id` varchar(255) COLLATE utf8_bin,
          `total_played` float,
          PRIMARY KEY  (`id_poke`)
		)ENGINE=MyISAM DEFAULT CHARSET=utf8");
    }
 
	public function index() {   // Default function 
		$this->language->load('module/sdksnippet'); // Loading the language file of sdksnippet
	 
		$this->document->setTitle($this->language->get('heading_title')); // Set the title of the page to the heading title in the Language file i.e., Hello World
	 
		$this->load->model('setting/setting'); // Load the Setting Model  (All of the OpenCart Module & General Settings are saved using this Model )
	 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) { // Start If: Validates and check if data is coming by save (POST) method
			if (isset($this->request->post['sdkextension'])) {
				$this->request->post['sdkextension'] = serialize($this->request->post['sdkextension']);
			} else {
				$this->request->post['sdkextension'] = '';
			}
            
			$this->model_setting_setting->editSetting('sdksnippet', $this->request->post);      // Parse all the coming data to Setting Model to save it in database.
	 
			$this->session->data['success'] = $this->language->get('text_success'); // To display the success text on data save
	 
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')); // Redirect to the Module Listing
		} // End If
	 
		/*Assign the language data for parsing it to view*/
		$this->data['heading_title'] = $this->language->get('heading_title');
	 
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');      
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
	 
		$this->data['api_id'] = $this->language->get('api_id');
		$this->data['operation_id'] = $this->language->get('operation_id');
		$this->data['use_mode'] = $this->language->get('use_mode');
		$this->data['iframe_width'] = $this->language->get('iframe_width');
		$this->data['iframe_height'] = $this->language->get('iframe_height');
        $this->data['upload_banner'] = $this->language->get('upload_banner');
        $this->data['text_image_manager'] = $this->language->get('text_image_manager');
        $this->data['text_browse'] = $this->language->get('text_browse');
        $this->data['text_clear'] = $this->language->get('text_clear');
        $this->data['other_information_label'] = $this->language->get('other_information_label');
        $this->data['after_information_label'] = $this->language->get('after_information_label');
        //$this->data['position_information_label'] = $this->language->get('position_information_label');
        $this->data['entry_payment_method'] = $this->language->get('entry_payment_method');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
	 
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
        $this->data['token'] = $this->session->data['token'];
	 
		/*This Block returns the warning if any*/
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		/*End Block*/
	 
		/*This Block returns the error code if any*/
		if (isset($this->error['code'])) {
			$this->data['error_api_id'] = $this->error['code'];
		} else {
			$this->data['error_api_id'] = '';
		}
        if (isset($this->error['code_operation_id'])) {
            $this->data['error_operation_id'] = $this->error['code_operation_id'];
        } else {
            $this->data['error_operation_id'] = '';
        }
		/*End Block*/
	 
	 
		/* Making of Breadcrumbs to be displayed on site*/
		$this->data['breadcrumbs'] = array();
	 
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
	 
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
	 
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/sdksnippet', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
	 
		/* End Breadcrumb Block*/

		$this->data['action'] = $this->url->link('module/sdksnippet', 'token=' . $this->session->data['token'], 'SSL'); // URL to be directed when the save button is pressed
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'); // URL to be redirected when cancel button is pressed
		 
		/* This block checks, if the hello world text field is set it parses it to view otherwise get the default hello world text field from the database and parse it*/
	 
		if (isset($this->request->post['sdksnippet_text_field'])) {
			$this->data['sdksnippet_text_field'] = $this->request->post['sdksnippet_text_field'];
		} else {
			$this->data['sdksnippet_text_field'] = $this->config->get('sdksnippet_text_field');
		}

        if (isset($this->request->post['sdksnippet_operation_id'])) {
            $this->data['sdksnippet_operation_id'] = $this->request->post['sdksnippet_operation_id'];
        } else {
            $this->data['sdksnippet_operation_id'] = $this->config->get('sdksnippet_operation_id');
        }
        if (isset($this->request->post['sdksnippet_use_mode'])) {
            $this->data['sdksnippet_use_mode'] = $this->request->post['sdksnippet_use_mode'];
        } else {
            $this->data['sdksnippet_use_mode'] = $this->config->get('sdksnippet_use_mode');
        }

        $this->load->model('luckycycle/api_mode');

        $this->data['use_mode_datas'] = $this->model_luckycycle_api_mode->getModeData();
		
		if (isset($this->request->post['sdkextension'])) {
			$this->data['sdkextension'] = $this->request->post['sdkextension'];
		} else {
			$this->data['sdkextension'] = unserialize($this->config->get('sdkextension'));
		}

        if (isset($this->request->post['sdksnippet_iframe_width'])) {
            $this->data['sdksnippet_iframe_width'] = $this->request->post['sdksnippet_iframe_width'];
        } else {
            $this->data['sdksnippet_iframe_width'] = $this->config->get('sdksnippet_iframe_width');
        }

        if (isset($this->request->post['sdksnippet_iframe_height'])) {
            $this->data['sdksnippet_iframe_height'] = $this->request->post['sdksnippet_iframe_height'];
        } else {
            $this->data['sdksnippet_iframe_height'] = $this->config->get('sdksnippet_iframe_height');
        }
        $this->load->model('tool/image');

        if (isset($this->request->post['luckycycle_banner'])) {
            $this->data['luckycycle_banner'] = $this->request->post['luckycycle_banner'];
        } else {
            $this->data['luckycycle_banner'] = $this->config->get('luckycycle_banner');
        }

        if ($this->config->get('luckycycle_banner') && file_exists(DIR_IMAGE . $this->config->get('luckycycle_banner')) && is_file(DIR_IMAGE . $this->config->get('luckycycle_banner'))) {
            $this->data['banner'] = $this->model_tool_image->resize($this->config->get('luckycycle_banner'), 100, 100);
        } else {
            $this->data['banner'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
        }
        $this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

        if (isset($this->request->post['sdksnippet_other_information'])) {
            $this->data['sdksnippet_other_information'] = $this->request->post['sdksnippet_other_information'];
        } else {
            $this->data['sdksnippet_other_information'] = $this->config->get('sdksnippet_other_information');
        }
        if (isset($this->request->post['sdksnippet_after_information'])) {
            $this->data['sdksnippet_after_information'] = $this->request->post['sdksnippet_after_information'];
        } else {
            $this->data['sdksnippet_after_information'] = $this->config->get('sdksnippet_after_information');
        }
//        if (isset($this->request->post['sdksnippet_position_information'])) {
//            $this->data['sdksnippet_position_information'] = $this->request->post['sdksnippet_position_information'];
//        } else {
//            $this->data['sdksnippet_position_information'] = $this->config->get('sdksnippet_position_information');
//        }

        $this->load->model('luckycycle/position_information');

        //$this->data['position_information_datas'] = $this->model_luckycycle_position_information->getPositionData();
		/* End Block*/
	 
		$this->data['modules'] = array();
	 
		/* This block parses the Module Settings such as Layout, Position,Status & Order Status to the view*/
		if (isset($this->request->post['sdksnippet_module'])) {
			$this->data['modules'] = $this->request->post['sdksnippet_module'];
		} elseif ($this->config->get('sdksnippet_module')) {
			$this->data['modules'] = $this->config->get('sdksnippet_module');
		}
		/* End Block*/         
		
		/*$this->load->model('setting/extension');
		$extensions_installed = $this->model_setting_extension->getInstalled('payment');
		foreach ($extensions_installed as $key => $value) {
			if (!file_exists(DIR_APPLICATION . 'controller/payment/' . $value . '.php')) {
				$this->model_setting_extension->uninstall('payment', $value);

				unset($extensions_installed[$key]);
			}
		}*/
		$this->data['extensions'] = array();
		$files = glob(DIR_APPLICATION . 'controller/payment/*.php');
		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');
				$status = $this->config->get($extension . '_status');
				//if (in_array($extension, $extensions_installed) && $status) {
				if ($status) {
					$this->language->load('payment/' . $extension);
					$this->data['extensions'][] = array(
						'name'      => $this->language->get('heading_title'),
						'alias' 	=> $extension
					);
				}
			}
		}
	 
		$this->load->model('design/layout'); // Loading the Design Layout Models
	 
		$this->data['layouts'] = $this->model_design_layout->getLayouts(); // Getting all the Layouts available on system
	 
		//$this->template = 'module/<span class="skimlinks-unlinked">sdksnippet.tpl</span>'; // Loading the <span class="skimlinks-unlinked">sdksnippet.tpl</span> template
		$this->template = 'module/sdksnippet.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);  // Adding children to our default template i.e., <span class="skimlinks-unlinked">sdksnippet.tpl</span>
	 
		$this->response->setOutput($this->render()); // Rendering the Output
	}
	
	/* Function that validates the data when Save Button is pressed */
    protected function validate() {
 
        /* Block to check the user permission to manipulate the module*/
        if (!$this->user->hasPermission('modify', 'module/sdksnippet')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        /* End Block*/
 
        /* Block to check if the sdksnippet_text_field is properly set to save into database, otherwise the error is returned*/
        if (!$this->request->post['sdksnippet_text_field']) {
            $this->error['code'] = $this->language->get('error_api_id');
        }
        if (!$this->request->post['sdksnippet_operation_id']) {
            $this->error['code_operation_id'] = $this->language->get('error_operation_id');
        }
        /* End Block*/
 
        /*Block returns true if no error is found, else false if any error detected*/
        if (!$this->error) {
            return true;
        } else {
            return false;
        }   
        /* End Block*/
    }
    /* End Validation Function*/
}
?>