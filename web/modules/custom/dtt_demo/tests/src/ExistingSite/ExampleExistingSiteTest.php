<?php

namespace Drupal\Tests\dtt_demo\ExistingSite;

use Drupal\taxonomy\Entity\Vocabulary;
use weitzman\DrupalTestTraits\ExistingSiteBase;

/**
 * A model test case using traits from Drupal Test Traits.
 */
class ExampleExistingSiteTest extends ExistingSiteBase {

  /**
   *
   */
  protected function setUp(): void {
    parent::setUp();

    // Cause tests to fail if an error is sent to Drupal logs.
    $this->failOnLoggedErrors();
  }

  /**
   * An example test method; note that Drupal API's and Mink are available.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Drupal\Core\Entity\EntityMalformedException
   * @throws \Behat\Mink\Exception\ExpectationException
   */
  public function testLlama(): void {
    // Creates a user. Will be automatically cleaned up at the end of the test.
    $author = $this->createUser([], NULL, TRUE);

    // Create a taxonomy term. Will be automatically cleaned up at the end of the test.
    $vocab = Vocabulary::load('tags');
    $term = $this->createTerm($vocab);

    // Create a "Llama" article. Will be automatically cleaned up at end of test.
    $node = $this->createNode([
      'title' => 'Llama',
      'type' => 'article',
      'field_tags' => [
        'target_id' => $term->id(),
      ],
      'uid' => $author->id(),
    ]);
    $node->setPublished()->save();
    $this->assertEquals($author->id(), $node->getOwnerId());

    // We can browse pages.
    $this->drupalLogin($author);
    $this->drupalGet($node->toUrl());
    $this->assertSession()->statusCodeEquals(200);
  }

}
