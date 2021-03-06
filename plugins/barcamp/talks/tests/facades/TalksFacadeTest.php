<?php namespace Barcamp\Talks\Tests\Facades;

use App;
use Barcamp\Talks\Facades\TalksFacade;
use Barcamp\Talks\Models\Category;
use Barcamp\Talks\Models\Type;
use PluginTestCase;

class TalksFacadeTest extends PluginTestCase
{
    /**
     * Returns tested class.
     *
     * @return TalksFacade
     */
    public function getModel()
    {
        return App::make(TalksFacade::class);
    }

    public function testGetTalkType()
    {
        $model = $this->getModel();
        $type = $model->getTalkType('speaker');
        $this->assertInstanceOf(Type::class, $type);
    }

    public function testGetTalkCategory()
    {
        $model = $this->getModel();
        $type = $model->getTalkCategory('business');
        $this->assertInstanceOf(Category::class, $type);
    }

    public function testParseSocialNetworksFull()
    {
        $model = $this->getModel();
        $data = "https://www.facebook.com/testing" . "\n";
        $data .= "https://twitter.com/testing" . "\n";
        $data .= "https://www.instagram.com/testing" . "\n";
        $data .= "https://www.linkedin.com/testing" . "\n";
        $data .= "https://www.mysites.com/testing" . "\n";
        $result = $model->parseSocialNetworks($data);

        $this->assertEquals('https://www.facebook.com/testing', $result['link_facebook']);
        $this->assertEquals('https://twitter.com/testing', $result['link_twitter']);
        $this->assertEquals('https://www.instagram.com/testing', $result['link_instagram']);
        $this->assertEquals('https://www.linkedin.com/testing', $result['link_linkedin']);
        $this->assertEquals('https://www.mysites.com/testing', $result['link_web']);
    }

    public function testParseSocialNetworksPartial()
    {
        $model = $this->getModel();
        $data = "facebook.com/testing" . "\n";
        $data .= "mysites.com/testing" . "\n";
        $result = $model->parseSocialNetworks($data);

        $this->assertEquals('https://facebook.com/testing', $result['link_facebook']);
        $this->assertEquals('http://mysites.com/testing', $result['link_web']);
    }

    public function testParseSocialNetworksPartialWithWww()
    {
        $model = $this->getModel();
        $data = "www.facebook.com/testing" . "\n";
        $data .= "www.mysites.com/testing" . "\n";
        $result = $model->parseSocialNetworks($data);

        $this->assertEquals('https://www.facebook.com/testing', $result['link_facebook']);
        $this->assertEquals('http://www.mysites.com/testing', $result['link_web']);
    }

    public function testParseSocialNetworksEmpty()
    {
        $model = $this->getModel();
        $data = '';
        $result = $model->parseSocialNetworks($data);

        $this->assertEmpty($result);
    }
}
