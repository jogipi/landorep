<?php
/**
 * Created by PhpStorm.
 * User: jorgi
 * Date: 11/27/17
 * Time: 2:10 PM
 */
namespace Drupal\casestudies\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

class CaseStudiesForm extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'casestudies';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $header = [
            'title' => $this->t('Title'),
            'body' => $this->t('Body'),
            'success' => $this->t('Success'),
        ];

        $htmlLinks = array("https://www.achieveinternet.com/portfolio/ubm-fashion-built-drupal-8",
            "https://www.achieveinternet.com/portfolio/childrens-hospital-deploys-drupal-open-source-cms-solution",
            "https://www.achieveinternet.com/portfolio/drupal-integration-powers-grammy-amplifier",
            "https://www.achieveinternet.com/portfolio/eversporttv-deploys-custom-drupal-solution",
            "https://www.achieveinternet.com/portfolio/dexcom",
            "https://www.achieveinternet.com/portfolio/scripps-translational",
            "https://www.achieveinternet.com/portfolio/amerigroup",
            "https://www.achieveinternet.com/portfolio/trailer-park-partners-achieve",
            "https://www.achieveinternet.com/portfolio/universal-music-group",
            "https://www.achieveinternet.com/portfolio/magic-online",
            "https://www.achieveinternet.com/portfolio/guardion-health-sciences");

        $i = 0;
        $options = [];
        while ($i < sizeof($htmlLinks)) {

            $htmlFile = file_get_html("$htmlLinks[$i]");

            foreach ($htmlFile->find('h1') as $element) {
                $title = $element->innertext;
            }

            foreach ($htmlFile->find('#md2') as $element) // 'div.field__item even'
            {
                $body = trim($element->find('p', 0)->plaintext);
            }

            foreach ($htmlFile->find('#md2') as $element) // 'div.field__item even'
            {
                $success = trim($element->find('p', -2)->plaintext);
            }

            $val = array('title' => "$title",
                'body' => "$body",
                'success' => "$success"
            );
            array_push($options, $val);

            $_POST["casecontent"] = $options;
            $i++;
            $htmlFile->clear();
        }

        $form['table'] = array(
            '#type' => 'tableselect',
            '#header' => $header,
            '#options' => $options,
            '#empty' => $this->t('No cases found'),
        );

        unset($htmlFile);

        $form['submit'] = array(
            '#value' => t('Create Content'),
            '#type' => 'submit',
        );

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        // Find out what was submitted.
        //$element = $form['title'];
        //dpm($form_state);
        //kint ($form_state->getValues());
        $content = $_POST["casecontent"];
        $value = $form_state->getValues();
        foreach ($value as $selected) {
            foreach ($selected as $curr) {
                if ($curr != 0) {
                    $indexHold = (int)$curr;// Index where value is set
                    $a = $content[$indexHold]; // The array holding the selected's content
                    $title = $a['title'];  // Extract title from the content
                    $body = $a['body'];     // Extract the body from the content
                    $success = $a['success'];  // Extract the success paragraph from the content
                    $node = Node::create(array( // Create the content node of type outputform, and set vars
                        'type' => 'outputform',
                        'title' => "$title",
                        'langcode' => 'en',
                        'uid' => '1',
                        'status' => 1,
                        'body' => "$body",
                        'field_success' => "$success",
                    ));
                    $node->save();
                }
            }
        }
    }
}