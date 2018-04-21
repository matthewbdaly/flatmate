<?php

namespace Tests\Functional;

class HomepageTest extends BaseTestCase
{
    /**
     * Test that the index route returns a rendered response when the index.md file is present
     */
    public function testGetIndex()
    {
        $response = $this->runApp('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Welcome to my website', (string)$response->getBody());
    }

    /**
     * Test that the about route returns a render response when the about.md file is present
     */
    public function testGetAbout()
    {
        $response = $this->runApp('GET', '/about');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('I\'m a web and mobile app developer based in Norfolk in the UK', (string)$response->getBody());
    }

    /**
     * Test that the index route won't accept a post request
     */
    public function testPostHomepageNotAllowed()
    {
        $response = $this->runApp('POST', '/', ['test']);

        $this->assertEquals(405, $response->getStatusCode());
        $this->assertContains('Method not allowed', (string)$response->getBody());
    }
}
