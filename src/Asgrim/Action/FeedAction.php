<?php
declare(strict_types=1);

namespace Asgrim\Action;

use Asgrim\Service\FeedService;
use Asgrim\Service\PostService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response as DiactorosResponse;

class FeedAction
{
    /**
     * @var FeedService
     */
    private $feedService;

    /**
     * @var PostService
     */
    private $postService;

    /**
     * @param FeedService $feedService
     * @param PostService $postService
     */
    public function __construct(FeedService $feedService, PostService $postService)
    {
        $this->feedService = $feedService;
        $this->postService = $postService;
    }

    /**
     * @param string $type
     * @return string
     */
    private function getContentType(string $type) : string
    {
        if ($type === 'atom') {
            return 'application/atom+xml';
        }

        return 'application/xml';
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable|null $next
     * @return DiactorosResponse
     * @throws \Zend\Feed\Writer\Exception\InvalidArgumentException
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function __invoke(Request $request, Response $response, callable $next = null) : DiactorosResponse
    {
        $outputFormat = $request->getAttribute('format', 'rss');

        if ($outputFormat !== 'rss') {
            throw new \InvalidArgumentException('Invalid output format.');
        }

        $feed = $this->feedService->createFeed(
            $this->postService->fetchRecentPosts(10)
        );

        $response = new DiactorosResponse('php://temp', 200, ['Content-Type' => $this->getContentType($outputFormat)]);
        $response->getBody()->write($feed->export($outputFormat));
        return $response;
    }
}
