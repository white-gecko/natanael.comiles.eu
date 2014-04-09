<?php
/**
 * This file is part of the {@link http://ontowiki.net OntoWiki} project.
 *
 * @copyright Copyright (c) 2014, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * OntoWiki module – tagcloud
 *
 * @category   OntoWiki
 * @package    Extensions_Community
 * @author     Natanael Arndt <arndtn@gmail.com>
 */
class TagcloudModule extends OntoWiki_Module
{
    public function init()
    {
    }

    public function getTitle()
    {
        return 'Tagcloud';
    }

    public function getContents()
    {
        $content = '';

        // comment form part
        if (isset($this->_owApp->selectedModel)) {
            $model = $this->_owApp->selectedModel;
            $query = 'prefix ctag: <http://commontag.org/ns#> ' . PHP_EOL;
            $query.= 'prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> ' . PHP_EOL;
            $query.= 'select distinct ?tag ?label count(?tag) as ?weight  {' . PHP_EOL;
            $query.= '  ?resource ctag:tagged ?tag . ' . PHP_EOL;
            $query.= '  optional { { ?tag ctag:label ?label } union { ?tag rdfs:label ?label } } ' . PHP_EOL;
            $query.= '} order by ?label';
            $result = $model->sparqlQuery($query);
            $this->view->result = $result;
            if (isset($this->_options->selected)) {
                $this->view->selected = $this->_options->selected->toArray();
            } else {
                $this->view->selected = array();
            }
            $content = $this->render('templates/tagcloud');
        }

        return $content;
    }
}
