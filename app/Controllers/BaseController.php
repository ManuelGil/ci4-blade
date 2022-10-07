<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use eftec\bladeone\BladeOne;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    private $templateEngine;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        $views = APPPATH . 'Views';
        $cache = WRITEPATH . 'cache' . DIRECTORY_SEPARATOR . 'blade';

        if (ENVIRONMENT === 'production') {
            $this->templateEngine = new BladeOne(
                $views,
                $cache,
                BladeOne::MODE_AUTO
            );
        } else {
            $this->templateEngine = new BladeOne(
                $views,
                $cache,
                BladeOne::MODE_DEBUG
            );
        }

        $this->templateEngine->pipeEnable = true;
        $this->templateEngine->setBaseUrl(base_url());
    }

    /**
     * This method render the template.
     *
     * @param string $filename - the filename of template.
     * @param array $params - the data with context of the template.
     * @return void
     */
    public function render(string $filename, array $params = [])
    {
        try {
            // Render the template.
            return $this->templateEngine->run($filename, $params);
        } catch (\Throwable $e) {
            if (ENVIRONMENT === 'production') {
                // Save error in file log
                log_message('error', $e->getTraceAsString());
            } else {
                // Show error in the current page
                header_remove();
                http_response_code(500);
                header('HTTP/1.1 500 Internal Server Error');
                echo '<pre>' . $e->getTraceAsString() . '</pre>';
                echo PHP_EOL;
                echo $e->getMessage();
                exit;
            }
        }
    }
}
