<?php

namespace Drupal\Tests\dtt_demo\ExistingSiteJavascript;

use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Vocabulary;
use weitzman\DrupalTestTraits\ExistingSiteSelenium2DriverTestBase;
use weitzman\DrupalTestTraits\ScreenShotTrait;

/**
 * Example Existing Site Javascript Test.
 */
class ExampleExistingSiteJavascriptTest extends ExistingSiteSelenium2DriverTestBase {

  use ScreenShotTrait;

  /**
   * Test a user can create a new article.
   *
   * @test
   */
  public function AUserCanCreateANewArticle(): void {
    // Create a taxonomy term. Will be automatically cleaned up at the end of the test.
    $assert = $this->assertSession();
    $vocab = Vocabulary::load('tags');
    $this->createTerm($vocab, ['name' => 'Term 1']);
    $this->createTerm($vocab, ['name' => 'Term 2']);

    $author = $this->createUser([], NULL, TRUE);
    $this->drupalLogin($author);

    // @codingStandardsIgnoreStart
    // These lines are left here as examples of how to debug requests.
    // \weitzman\DrupalTestTraits\ScreenShotTrait::captureScreenshot();
    // $this->capturePageContent();
    // @codingStandardsIgnoreStop

    // Test autocomplete on article creation.
    $this->drupalGet('/node/add/article');
    $page = $this->getCurrentPage();
    $page->fillField('title[0][value]', 'Article Title');
    $tags = $page->findField('field_tags[target_id]');
    $tags->setValue('Term');
    $tags->keyDown(' ');
    $result = $assert->waitForElementVisible('css', '.ui-autocomplete li');
    $this->assertNotNull($result);
    // Click the autocomplete option
    $result->click();
    // Verify that correct the input is selected.
    $this->assertStringContainsString('Term 1', $tags->getValue());
    $submit_button = $page->findButton('Save');
    $submit_button->press();
    // Verify the URL and get the nid.
    $this->assertTrue((bool) preg_match('/.+node\/(?P<nid>\d+)/', $this->getUrl(), $matches));
    $node = Node::load($matches['nid']);
    $this->markEntityForCleanup($node);
    // Verify the text on the page.
    $assert->pageTextContains('Article Title');
    $assert->pageTextContains('Term 1');
}

}
