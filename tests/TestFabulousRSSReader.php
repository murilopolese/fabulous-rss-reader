<?php
require_once './fabulous-rss-reader.php';
class FabulousRSSReader extends PHPUnit_Framework_TestCase 
{
    private $plugin;
    function __construct() {
        $this->plugin = new Fabulous_RSS_Reader();
    }
    // xml request without passing parameter
    public function testRequestXmlWhithEmpty() 
    {
        $response = $this->plugin->request_xml();
        $this->assertEquals('', $response);
    }
    // xml request without passing an empty string
    public function testRequestXmlWhithEmptyString() 
    {
        $response = $this->plugin->request_xml();
        $this->assertEquals('', $response);
    }
    public function testRequestXmlWithWrongUrl() 
    {
    // xml request without passing a wrong url
        $response = $this->plugin->request_xml('wrong url');
        $this->assertEquals('', $response);
    }
    // xml request without passing a correct url
    public function testRequestXmlWithCorrectUrl()
    {
        $response = $this->plugin->request_xml('http://www.creativeapplications.net/feed/');
        $this->assertNotEquals('', $response);
    }
    // get feeds passing no parameter
    public function testGetFeedsWithEmpty()
    {
        $response = $this->plugin->get_feed();
        $this->assertInternalType('array', $response);
        $this->assertCount(0, $response);
    }
    // get feeds passing empty string as parameter
    public function testGetFeedsWithEmptyString()
    {
        $response = $this->plugin->get_feed('');
        $this->assertInternalType('array', $response);
        $this->assertCount(0, $response);
    }
    // get feeds passing a wrong url as parameter
    public function testGetFeedsWithWrongUrl()
    {
        $response = $this->plugin->get_feed('wrong url');
        $this->assertInternalType('array', $response);
        $this->assertCount(0, $response);
    } 
    // get feeds passing a correct url as parameter 
    public function testGetFeedsWithCorrectUrl()
    {
        $response = $this->plugin->get_feed('http://www.creativeapplications.net/feed/');
        $this->assertInstanceOf('SimpleXMLElement', $response);
    }
}