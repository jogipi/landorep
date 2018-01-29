<?php
/**
 * Created by PhpStorm.
 * User: jorgi
 * Date: 11/27/17
 * Time: 2:47 PM
 */

namespace Drupal\casestudies\Controller;

use Drupal\Core\Controller\ControllerResolverInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CaseStudiesController implements  ContainerInjectionInterface {

    public static function create(ContainerInterface $container) {
        return new static($container->get('module_handler'));
    }

    public function caseStudy() {
        $build = array(
            '#type' => 'markup',
            '#markup' => t('Hello'),
        );
        return $build;
    }
}