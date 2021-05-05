<?php

class SitemapProvider extends WP_Sitemaps_Provider
{

    /**
     * @var int
     */
    private $id_object_type;

    public function __construct($name, $id_object_type)
    {
        $this->object_type = $this->name = $name;
        $this->id_object_type = $id_object_type;
    }


    public function get_url_list($page, $post_type = '')
    {
        $page_size = 1000;
        $Search = new Pressmind\Search(
            [
               \Pressmind\Search\Condition\ObjectType::create($this->id_object_type)
            ], [
            'start' => 0,
            'length' => 1000
        ]);

        $Search->setPaginator(Pressmind\Search\Paginator::create($page_size, $page));

        $mediaObjects = $Search->getResults();

        /*
        $total_result = $Search->getTotalResultCount();
        $current_page = $Search->getPaginator()->getCurrentPage();
        $pages = $Search->getPaginator()->getTotalPages();
        */

        $urlList = array();
        foreach ($mediaObjects as $mediaObject) {
            $urlList[] = ['loc' => SITE_URL . $mediaObject->getPrettyUrl()];
        }

        return $urlList;

    }


    public function get_max_num_pages($post_type = '')
    {
        return 1;
    }


}