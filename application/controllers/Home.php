<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model("plugin_data_scraper_model");
	}
	
	public function index()
	{
		echo "<h1 style='text-align: center;'>Plugin Data Scraper (Demo)</h1>";
		echo "<p style='text-align: center; width: 700px; margin: 0 auto;'>You just need to provide the plugin URLs. The data will be scraped automatically. For now, these URL are hard-coded, in real project these URLs will be retrieved from database and then used in the code.</p>";

		echo "<hr />";

		// Visual Studio Code Plugin
		$marketplace_url = "https://marketplace.visualstudio.com/items?itemName=Bito.Bito";
		$this->plugin_data_scraper_model->scrape_vscode_plugin_data($marketplace_url);

		echo "<hr />";

		// JetBrains Plugin
		$marketplace_url = "https://plugins.jetbrains.com/plugin/18289-chatgpt-gpt-4";
		$this->plugin_data_scraper_model->scrape_jetbrains_plugin_data($marketplace_url);

		echo "<hr />";

		// Chrome Plugin
		$marketplace_url = "https://chrome.google.com/webstore/detail/bito-ai-use-chatgpt-to-10/afchmofckbnlkpnjkdikdkgnjelhlbkg";
		$this->plugin_data_scraper_model->scrape_chrome_plugin_data($marketplace_url);
	}
}