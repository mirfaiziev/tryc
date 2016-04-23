<?php

namespace My\HttpFramework\Router;

use My\HttpFramework\Request;
use My\HttpFramework\Router;
use My\HttpFramework\UriParser\UriParserInterface;

/**
 * Class DefaultRouter - default router does not support custom routes, just return what we get from uri parser
 * @package My\HttpFramework\Router
 */
class DefaultRouter implements RouterInterface
{
    /**
     * @var Request $request
     */
    protected $request;

    /**
     * @var UriParserInterface $uriParser
     */
    protected $uriParser;

    /**
     * DefaultRouter constructor.
     * @param Request $request
     * @param UriParserInterface $uriParser
     */
    public function __construct(Request $request, UriParserInterface $uriParser)
    {
        $this->request = $request;

        $uriParser->setMethod($request->getMethod());
        $uriParser->setUri($request->getUri());

        $this->uriParser = $uriParser;
    }

    /**
     * @return array<Routes>
     */
    public function getRoutes()
    {
        return $this->uriParser->getRoutes();
    }
}