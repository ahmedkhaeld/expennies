<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Contracts\RequestValidatorFactoryInterface;
use App\RequestValidators\CreateCategoryRequestValidator;
use App\RequestValidators\UpdateCategoryRequestValidator;
use App\ResponseFormatter;
use App\Services\CategoryService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class CategoriesController
{
    public function __construct(private readonly Twig $twig,
        private readonly RequestValidatorFactoryInterface $requestValidatorFactory,
        private readonly CategoryService $categoryService,
        private readonly ResponseFormatter $responseFormatter
    )
    {
    }

    public function index(Request $request, Response $response): Response
    {
        $categories=$this->categoryService->getAll();

        return $this->twig->render(
            $response,
            'categories/index.twig',
            [
                'categories' => $categories,
            ]
        );
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $this->requestValidatorFactory->make(CreateCategoryRequestValidator::class)->validate(
            $request->getParsedBody()
        );

        $this->categoryService->create($data['name'], $request->getAttribute('user'));

        return $response->withHeader('Location', '/categories')->withStatus(302);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $this->categoryService->delete((int) $args['id']);

        return $response->withHeader('Location', '/categories')->withStatus(302);
    }

    //get handler for the route /categories/{id} from AJAX get request
    public function get(Request $request, Response $response, array $args): Response
    {
        $category=$this->categoryService->getByID((int) $args['id']);
        if(!$category){
            return $response->withStatus(404);
        }

        $data=['id'=>$category->getId(), 'name'=>$category->getName()];

        //write the data to the response as json
        return $this->responseFormatter->asJSON($response, $data);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $data = $this->requestValidatorFactory->make(UpdateCategoryRequestValidator::class)->validate(
            $request->getParsedBody()
        );

        $category=$this->categoryService->getByID((int) $args['id']);
        if(!$category){
            return $response->withStatus(404);
        }

        $data=['status'=>'success'];

        //write the data to the response as json
        return $this->responseFormatter->asJSON($response, $data);
    }

}