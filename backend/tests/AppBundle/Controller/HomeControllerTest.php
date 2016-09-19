<?php

namespace tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHomeActionRenders5ActivitiesForStaticHtmlExamplePlan()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/?id=3-87-113-13-16');

        $jsPlan = $crawler->filter('.js_plan');
        $activityBlocks = $jsPlan->filter('.js_activity_block');
        $this->assertEquals(5, $activityBlocks->count());
    }

    public function testHomeActionRendersSingleActivityBlock()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/?id=32');

        $jsPlan = $crawler->filter('.js_plan');
        $activityBlocks = $jsPlan->filter('.js_activity_block');
        $this->assertEquals(1, $activityBlocks->count());
    }

    public function testHomeActionRendersActivityNameRawHtml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/?id=32');
        $this->assertEquals(
            'Emoticon Project Gauge',
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_name')->html()
        );

        $crawler = $client->request('GET', '/?id=59');
        $this->assertEquals(
            'Happiness Histogram',
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_name')->html()
        );

        $client = static::createClient();

        $crawler = $client->request('GET', '/?id=80');
        $this->assertEquals(
            'Repeat &amp; Avoid', // raw HTML imported to DB from lang/activities_en.php
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_name')->html()
        );
    }

    public function testHomeActionRendersActivitySummaries()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/?id=76');
        $this->assertEquals(
            'Participants express what they admire about one another',
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_summary')->text()
        );

        $crawler = $client->request('GET', '/?id=81');
        $this->assertEquals(
            'Everyone states what they want out of the retrospective',
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_summary')->text()
        );
    }


    public function testHomeActionRendersActivityDescriptionsRawHtml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/?id=22');
        $this->assertEquals(
            'Prepare a flipchart with a drawing of a thermometer from freezing to body temperature to hot. Each participant marks their mood on the sheet.',
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_description')->html()
        );

        $crawler = $client->request('GET', '/?id=81');

        // Copied from FireBug as generated by JS version of retromat
        // $expected = 'Everyone in the team states their goal for the retrospective, i.e. what they want out of the meeting. Examples of what participants might say: <ul>     <li>I\'m happy if we get 1 good action item</li>     <li>I want to talk about our argument about unit tests and agree on how we\'ll do it in the future</li>     <li>I\'ll consider this retro a success, if we come up with a plan to tidy up $obscureModule</li> </ul> [You can check if these goals were met if you close with activity #14.] <br><br> [The <a href="http://liveingreatness.com/additional-protocols/meet/">Meet - Core Protocol</a>, which inspired this activity, also describes \'Alignment Checks\': Whenever someone thinks the retrospective is not meeting people\'s needs they can ask for an Alignment Check. Then everyone says a number from 0 to 10 which reflects how much they are getting what they want. The person with the lowest number takes over to get nearer to what they want.]';

        // This is identical except for some whitespace.
        // Normalizing this turned out to be anoying, so for now:
        // As long as this comes out, I'll be happy:
        $expected = 'Everyone in the team states their goal for the retrospective, i.e. what they want out of the meeting. Examples of what participants might say: <ul>
<li>I\'m happy if we get 1 good action item</li>     <li>I want to talk about our argument about unit tests and agree on how we\'ll do it in the future</li>     <li>I\'ll consider this retro a success, if we come up with a plan to tidy up $obscureModule</li> </ul> [You can check if these goals were met if you close with activity #14.] <br><br> [The <a href="http://liveingreatness.com/additional-protocols/meet/">Meet - Core Protocol</a>, which inspired this activity, also describes \'Alignment Checks\': Whenever someone thinks the retrospective is not meeting people\'s needs they can ask for an Alignment Check. Then everyone says a number from 0 to 10 which reflects how much they are getting what they want. The person with the lowest number takes over to get nearer to what they want.]';

        $this->assertEquals(
            $expected,
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_description')->html()
        );
    }

    public function testHomeActionRendersActivityLinksText()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/?id=1');
        $this->assertEquals(
            '1',
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_id')->text()
        );

        $crawler = $client->request('GET', '/?id=2');
        $this->assertEquals(
            '2',
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_id')->text()
        );
    }

    public function testHomeActionRendersActivityLinksHref()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/?id=1');
        $this->assertEquals(
            '?id=1',
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_activity_link')->attr('href')
        );

        $crawler = $client->request('GET', '/?id=2');
        $this->assertEquals(
            '?id=2',
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_activity_link')->attr('href')
        );
    }

    public function testHomeActionRendersActivityPhaseText()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/?id=3');
        $this->assertEquals(
            'Set the stage',
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_phase_title')->text()
        );

        $crawler = $client->request('GET', '/?id=4');
        $this->assertEquals(
            'Gather data',
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_phase_title')->text()
        );
    }

    public function testHomeActionRendersActivitySourceSimpleStringRawHtml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/?id=17');
        $this->assertEquals(
            '<a href="http://fairlygoodpractices.com/samolo.htm">Fairly good practices</a>',
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_source')->html()
        );

        $crawler = $client->request('GET', '/?id=80');
        $this->assertEquals(
            '<a href="http://www.infoq.com/minibooks/agile-retrospectives-value">Luis Goncalves</a>',
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_source')->html()
        );
    }

    public function testHomeActionRendersActivitySourcePlaceholderRawHtml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/?id=77');
        $this->assertEquals(
            '<a href="https://leanpub.com/ErfolgreicheRetrospektiven">Judith Andresen</a>',
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_source')->html()
        );

        $crawler = $client->request('GET', '/?id=5');
        $this->assertEquals(
            '<a href="http://www.finding-marbles.com/">Corinna Baldauf</a>',
            $crawler->filter('.js_activity_block')->eq(0)->filter('.js_fill_source')->html()
        );
    }
}