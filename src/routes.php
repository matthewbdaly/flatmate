<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Exception\NotFoundException;

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Does that page exist?
	$name = isset($args['name']) ? $args['name'] : 'index';
    $filename = getcwd() . '/../content/' . $name . '.md';
    if (file_exists($filename)) {
        // Get content
        $rawcontent = file_get_contents($filename);
        $document = $this->parser->parse($rawcontent);
        $content = $document->getContent();

        // Get title
        $yaml = $document->getYAML();
        $title = $yaml['title'];
        $layout = isset($yaml['layout']) ? $yaml['layout'].'.phtml' : 'default.phtml';

        // Render it with the template
        $data = array(
            'title' => $title,
            'content' => $content
        );
        return $this->view->render($response, $layout, $data);
    } else {
        throw new NotFoundException($request, $response);
    }
});
