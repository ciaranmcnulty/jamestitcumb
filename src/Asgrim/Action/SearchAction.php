<?php
declare(strict_types=1);

namespace Asgrim\Action;

use Asgrim\Service\PostService;
use Asgrim\Service\SearchWrapper;
use Elasticsearch\Common\Exceptions\TransportException;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;
use Zend\View\Model\ViewModel;

final class SearchAction implements MiddlewareInterface
{
    /**
     * @var SearchWrapper
     */
    private $searchWrapper;

    /**
     * @var PostService
     */
    private $postService;

    /**
     * @var TemplateRenderer
     */
    private $template;

    /**
     * @param SearchWrapper $searchWrapper
     * @param PostService $postService
     * @param TemplateRenderer $template
     */
    public function __construct(SearchWrapper $searchWrapper, PostService $postService, TemplateRenderer $template)
    {
        $this->searchWrapper = $searchWrapper;
        $this->postService = $postService;
        $this->template = $template;
    }
    public function process(Request $request, DelegateInterface $delegate) : HtmlResponse
    {
        $queryParams = $request->getQueryParams();

        if (!array_key_exists('q', $queryParams) || '' === trim($queryParams['q'])) {
            return new HtmlResponse($this->template->render('app::search/no-query'));
        }

        try {
            $rawResults = $this->searchWrapper->search($queryParams['q']);
        } catch (TransportException $transportException) {
            return new HtmlResponse($this->template->render('app::search/unavailable'));
        }

        $posts = [];
        foreach ($rawResults as $rawResult) {
            $posts[] = $this->postService->fetchPostBySlug($rawResult['slug']);
        }

        $layoutModel = new ViewModel([
            'searchQuery' => $queryParams['q'],
        ]);
        $layoutModel->setTemplate('layout/default');

        return new HtmlResponse($this->template->render('app::search/results', [
            'layout' => $layoutModel,
            'query' => $queryParams['q'],
            'results' => $posts,
        ]));
    }
}
