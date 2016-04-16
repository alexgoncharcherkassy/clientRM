<?php
/**
 * Created by PhpStorm.
 * User: device
 * Date: 16.04.16
 * Time: 16:43
 */

namespace AppBundle\Services;


class Pagination
{
    const LIMIT_PAGINATION = 25;

    private $redmineManager;

    public function __construct(ManagerClient $managerClient)
    {
        $this->redmineManager = $managerClient;
    }

    public function pagination($page = 1, $param, $id = null)
    {
        $offset = ($page - 1) * self::LIMIT_PAGINATION;
        switch ($param) {
            case 'ALL' :
                $response = $this->redmineManager->get('issues', '?offset='.$offset);
                break;
            case 'ISSUE' :
                $response = $this->redmineManager->get('issues', '?project_id='.$id.'&offset='.$offset);
                break;
        }
        $responseBody = json_decode($response->getBody(), true);
        $limit = $responseBody['limit'];
        $allPage = $responseBody['total_count'];
        $countPage = ceil($allPage / $limit);

        return [
            'offset' => $offset,
            'countPage' => $countPage,
            'response' => $responseBody
        ];
    }
}