<?php

namespace Watson\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Watson\Domain\Link;

class RssController
{
    /**
     * API links controller.
     *
     * @param Application $app Silex application
     *
     * @return All links in JSON format
     */
    public function getRss($limit, Application $app)
    {
        $links = $app['dao.link']->findByLimit();
        // Convert an array of objects ($links) into an array of associative arrays ($responseData)
        $_links = [];
        foreach ($links as $link) {
            $_links[] = $this->buildLinkArray($link);
        }

        return $app['twig']->render('rss_link.html.twig', ['links' => $links]);
    }

    /**
     * Converts an Link object into an associative array for JSON encoding
     *
     * @param Link $link Link object
     *
     * @return array Associative array whose fields are the link properties.
     */
    private function buildLinkArray(Link $link)
    {
        $data = [
            'id' => $link->getId(),
            'lien_titre' => $link->getTitle(),
            'lien_url' => $link->getUrl(),
            'lien_desc' => $link->getDesc(),
        ];

        return $data;
    }
}