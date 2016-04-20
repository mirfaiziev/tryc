<?php

namespace My\Lib\Router;

use My\Lib\Request;
use My\Lib\Router;
use My\Lib\UriParser\UriParserInterface;

/**
 * Class DefaultRouter - default router doesn't support custom routes, just return what we get from uri parser
 * @package My\Lib\Router
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