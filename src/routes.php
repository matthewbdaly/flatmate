<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Exception\NotFoundException;

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Does that page exist?
	$name = isset($args['name']) ? $args['name'] : 'index';
    $filename = BASE_DIR.CONTENT_PATH. $name . '.md';
    if (file_exists($filename)) {
        // Get content
        $rawcontent = file_get_contents($filename);
        $document = $this->parser->parse($rawcontent);

        // Get title
        $data = $document->getYAML();
        $data['content'] = $document->getContent();
        $title = $data['title'];
        $layout = isset($data['layout']) ? $data['layout'].'.phtml' : 'default.phtml';

        return $this->view->render($response, $layout, $data);
    } else {
        throw new NotFoundException($request, $response);
    }
});
