<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// https://github.com/php-webdriver/php-webdriver
// https://github.com/php-webdriver/php-webdriver/wiki/Example-command-reference
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Remote\DesiredCapabilities;

class Plugin_data_scraper_model extends CI_Model
{
    public function __construct()
	{
		parent::__construct();

		// Enter your chromedriver.exe path here
		putenv('WEBDRIVER_CHROME_DRIVER=E:\softwares\installed\chromedriver_win32\chromedriver.exe');
    }

	public function scrape_vscode_plugin_data($marketplace_url)
	{
		echo "<h2>Visual Studio Code Plugin</h2>";

		### scrape data - start
		try
		{
			// Create an instance of ChromeOptions:
			$chromeOptions = new ChromeOptions();
			
			// Configure $chromeOptions, see examples bellow:
			$chromeOptions->addArguments(['--headless']);
			
			// Create $capabilities and add configuration from ChromeOptions
			$capabilities = DesiredCapabilities::chrome();
			$capabilities->setCapability(ChromeOptions::CAPABILITY_W3C, $chromeOptions);
			
			$driver = ChromeDriver::start($capabilities);
			
			// navigate to plugin page on marketplace
			// Example URL: https://marketplace.visualstudio.com/items?itemName=Bito.Bito
			$driver->get($marketplace_url);
			
			$driver->wait()->until(
				WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('.installs-text'))
			);
			$total_installs = $driver->findElements(
				WebDriverBy::cssSelector('.installs-text')
			);
			
			$driver->wait()->until(
				WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('.ux-item-rating-count'))
			);
			$total_reviews = $driver->findElements(
				WebDriverBy::cssSelector('.ux-item-rating-count')
			);
			
			$driver->wait()->until(
				WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('.ux-item-review-rating'))
			);
			$rating = $driver->findElements(
				WebDriverBy::cssSelector('.ux-item-review-rating')
			);
			
			if (count($total_installs) > 0 && count($total_reviews) > 0 && count($rating) > 0) 
			{
				echo "<b>Plugin URL (Will be Provided by Admin): </b>" . $marketplace_url;

				echo "<br />";

				$str = $total_installs[0]->getText();
				$str = str_replace(array('+','-'), '', $str);
				$total_installs_int = (int) filter_var($str, FILTER_SANITIZE_NUMBER_INT);
				echo "<b>Total Installs: </b>" . $total_installs_int;

				echo "<br />";

				$str = $total_reviews[0]->getText();
				$str = str_replace(array('+','-'), '', $str);
				$total_reviews_int = (int) filter_var($str, FILTER_SANITIZE_NUMBER_INT);
				echo "<b>Total Reviews: </b>" . $total_reviews_int;

				echo "<br />";

				
				//echo "<b>Rating: </b>" . $rating[0]->getAttribute("title");

				// Define the regular expression pattern to match the first number (float or integer)
				$pattern = '/\b\d+(\.\d+)?\b/';

				// Perform the regular expression match
				if (preg_match($pattern, $rating[0]->getAttribute("title"), $matches)) {
					$rating_number = (float) $matches[0]; // Convert the matched string to a float or integer and return
				} else {
					$rating_number = null; // Return null if no number is found
				}

				echo "<b>Rating: </b>" . $rating_number . " out of 5";
			}
			else
			{
				echo "An error occurred while scraping data";
			}
			
			// terminate the session and close the browser
			$driver->quit();
		}
		catch(Facebook\WebDriver\Exception\WebDriverException $e)
		{
			//var_dump($e->getMessage());
			//exit;
			
			$response = array(
				'status' => false,
				// https://stackoverflow.com/a/3760830
				'message' => preg_replace('/\s+/', ' ', $e->getMessage())
			);
			
			echo "<pre>";
			var_dump($response);
		}
		### scrape data - end
	}

	public function scrape_jetbrains_plugin_data($marketplace_url)
	{
		echo "<h2>JetBrains IDE Plugin</h2>";

		### scrape data - start
		try
		{
			// Create an instance of ChromeOptions:
			$chromeOptions = new ChromeOptions();
			
			// Configure $chromeOptions, see examples bellow:
			$chromeOptions->addArguments(['--headless']);
			
			// Create $capabilities and add configuration from ChromeOptions
			$capabilities = DesiredCapabilities::chrome();
			$capabilities->setCapability(ChromeOptions::CAPABILITY_W3C, $chromeOptions);
			
			$driver = ChromeDriver::start($capabilities);
			
			// navigate to plugin page on marketplace
			// Example URL: https://plugins.jetbrains.com/plugin/18289-chatgpt-gpt-4
			$driver->get($marketplace_url);

			$driver->wait()->until(
				WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath('//*[@data-testid="total-votes"]/parent::*/*[2]'))
			);
			$total_installs = $driver->findElements(
				WebDriverBy::xpath('//*[@data-testid="total-votes"]/parent::*/*[2]')
			);
			
			$driver->wait()->until(
				WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('.totalVotes--tQsoqcT[data-testid="total-votes"]'))
			);
			$total_reviews = $driver->findElements(
				WebDriverBy::cssSelector('.totalVotes--tQsoqcT[data-testid="total-votes"]')
			);
			
			$driver->wait()->until(
				WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('.wt-subtitle-1[data-testid="total-rating"]'))
			);
			$rating = $driver->findElements(
				WebDriverBy::cssSelector('.wt-subtitle-1[data-testid="total-rating"]')
			);
			
			if (count($total_installs) > 0 && count($total_reviews) > 0 && count($rating) > 0) 
			{
				echo "<b>Plugin URL (Will be Provided by Admin): </b>" . $marketplace_url;

				echo "<br />";

				$str = $total_installs[0]->getText();
				$str = str_replace(array('+','-'), '', $str);
				$total_installs_int = (int) filter_var($str, FILTER_SANITIZE_NUMBER_INT);
				echo "<b>Total Installs: </b>" . $total_installs_int;

				echo "<br />";

				$str = $total_reviews[0]->getText();
				$str = str_replace(array('+','-'), '', $str);
				$total_reviews_int = (int) filter_var($str, FILTER_SANITIZE_NUMBER_INT);
				echo "<b>Total Reviews: </b>" . $total_reviews_int;

				echo "<br />";

				
				echo "<b>Rating: </b>" . $rating[0]->getText() . " out of 5";
			}
			else
			{
				echo "An error occurred while scraping data";
			}
			
			// terminate the session and close the browser
			$driver->quit();
		}
		catch(Facebook\WebDriver\Exception\WebDriverException $e)
		{
			//var_dump($e->getMessage());
			//exit;

			$response = array(
				'status' => false,
				// https://stackoverflow.com/a/3760830
				'message' => preg_replace('/\s+/', ' ', $e->getMessage())
			);
			
			echo "<pre>";
			var_dump($response);
		}
		### scrape data - end
	}

	public function scrape_chrome_plugin_data($marketplace_url)
	{
		echo "<h2>Chrome Plugin</h2>";

		### scrape data - start
		try
		{
			// Create an instance of ChromeOptions:
			$chromeOptions = new ChromeOptions();
			
			// Configure $chromeOptions, see examples bellow:
			$chromeOptions->addArguments(['--headless']);
			
			// Create $capabilities and add configuration from ChromeOptions
			$capabilities = DesiredCapabilities::chrome();
			$capabilities->setCapability(ChromeOptions::CAPABILITY_W3C, $chromeOptions);
			
			$driver = ChromeDriver::start($capabilities);
			
			// navigate to plugin page on marketplace
			// Example URL: https://chrome.google.com/webstore/detail/bito-ai-use-chatgpt-to-10/afchmofckbnlkpnjkdikdkgnjelhlbkg
			$driver->get($marketplace_url);

			$driver->wait()->until(
				WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('.e-f-ih'))
			);
			$total_installs = $driver->findElements(
				//WebDriverBy::xpath('//.e-f-ih')

				WebDriverBy::cssSelector('.e-f-ih')
			);
			
			$driver->wait()->until(
				WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('.nAtiRe'))
			);
			$total_reviews = $driver->findElements(
				WebDriverBy::cssSelector('.nAtiRe')
			);
			
			$driver->wait()->until(
				WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath('//meta[@itemprop="ratingValue"]'))
			);
			$rating = $driver->findElements(
				WebDriverBy::xpath('//meta[@itemprop="ratingValue"]')
			);
			
			if (count($total_installs) > 0 && count($total_reviews) > 0 && count($rating) > 0) 
			{
				echo "<b>Plugin URL (Will be Provided by Admin): </b>" . $marketplace_url;

				echo "<br />";

				$str = $total_installs[0]->getText();
				$str = str_replace(array('+','-'), '', $str);
				$total_installs_int = (int) filter_var($str, FILTER_SANITIZE_NUMBER_INT);
				echo "<b>Total Installs: </b>" . $total_installs_int;

				echo "<br />";

				$str = $total_reviews[0]->getText();
				$str = str_replace(array('+','-'), '', $str);
				$total_reviews_int = (int) filter_var($str, FILTER_SANITIZE_NUMBER_INT);
				echo "<b>Total Reviews: </b>" . $total_reviews_int;

				echo "<br />";

				// https://stackoverflow.com/a/4622336
				echo "<b>Rating: </b>" . number_format($rating[0]->getAttribute("content"), 1) . " out of 5";
			}
			else
			{
				echo "An error occurred while scraping data";
			}
			
			// terminate the session and close the browser
			$driver->quit();
		}
		catch(Facebook\WebDriver\Exception\WebDriverException $e)
		{
			//var_dump($e->getMessage());
			//exit;

			$response = array(
				'status' => false,
				// https://stackoverflow.com/a/3760830
				'message' => preg_replace('/\s+/', ' ', $e->getMessage())
			);
			
			echo "<pre>";
			var_dump($response);
		}
		### scrape data - end
	}
}