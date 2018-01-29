<?php
/**
 * Created by PhpStorm.
 * User: jorgi
 * Date: 11/27/17
 * Time: 4:26 PM
 */

namespace Drupal\hello_world\Controller;

class HelloWorldController {
    public function hello() {
        return array(
            '#title' => 'Hello World!',
            '#markup' => 'Here is some content.',
        );
    }
}