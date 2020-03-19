<?php

namespace Wtf\HttpController;

use Wtf\HttpMessage\HttpException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;

/**
 * Class Controller
 *
 * Abstract class which all WTF Controllers will extend. Handles an invokation and call the correct method.
 * @todo: move away from Zend Dioactros
 * @package Wtf\HttpController
 */
abstract class Controller
{
    /**
     * @var array
     */
    protected $_enabledMethods = [];

    /**
     * Invoked by the middleware router. Checks the request method and routes to the appropriate method. Throws an
     * exception if the method does not exist, and if the child class does not override the method, an exception
     * is thrown.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws HttpException
     */
    public function __invoke(ServerRequestInterface $request) : ResponseInterface {
        $method =  $request->getMethod();
        if(method_exists($this, $method)) {
            return $this->$method($request);
        } else {
            throw new HttpException("Invalid method", 405);
        }
    }

    /**
     * Base GET method. Throws exception unless child class overrides
     *
     * @param ServerRequestInterface $request
     * @throws HttpException
     */
    public function GET(ServerRequestInterface $request) {
        throw new HttpException('Get method not allowed or not implemented', 405);
    }

    /**
     * Base GET method. Throws exception unless child class overrides
     *
     * @param ServerRequestInterface $request
     * @throws HttpException
     */
    public function POST(ServerRequestInterface $request) {
        throw new HttpException('Post method not allowed or not implemented', 405);
    }

    /**
     * Base GET method. Throws exception unless child class overrides
     *
     * @param ServerRequestInterface $request
     * @throws HttpException
     */
    public function PATCH(ServerRequestInterface $request) {
        throw new HttpException('Patch method not allowed or not implemented', 405);
    }

    /**
     * Base GET method. Throws exception unless child class overrides
     *
     * @param ServerRequestInterface $request
     * @throws HttpException
     */
    public function DELETE(ServerRequestInterface $request) {
        throw new HttpException('Delete method not allowed or not implemented', 405);
    }

    /**
     * Base GET method. Throws exception unless child class overrides
     *
     * @param ServerRequestInterface $request
     * @throws HttpException
     */
    public function PUT(ServerRequestInterface $request) {
        throw new HttpException('Put method not allowed or not implemented', 405);
    }

    /**
     * Base OPTIONS method. Returns a 200 success, and is used by many front end api calls.
     *
     * @param ServerRequestInterface $request
     * @return Response\JsonResponse
     * @throws HttpException
     */
    public function OPTIONS(ServerRequestInterface $request) {
        // TODO: implement method to return correctly formatted response for options. Necessary for some browsers and a good idea
        return $this->json("success", 200);
    }

    /**
     * This method will return a string of all allowed methods on a controller.
     *
     * @return string
     */
    protected function getOptionsList() {
        return implode(',', $this->_enabledMethods);
    }

    /**
     * This method is the function that will return the data from the controller in a specific JSON format.
     *
     * @todo: finish this basically
     * @param $data
     * @param int $code
     * @return Response\JsonResponse
     */
    protected function json($data, int $code = 200) {
        $rc = [];
        $rc['meta']['ServiceName'] = 'Service Name Goes Here';
        $rc['payload'] = $data;
        return new Response\JsonResponse($rc, $code);
    }
}