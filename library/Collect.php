<?php
/**
 * Created by PhpStorm.
 * User: leetx
 * Date: 2019/4/11
 * Time: 14:54
 */

namespace app\library;


use App\Models\College;
use GuzzleHttp\Client;

class Collect
{
    const BASE_WEB_URL = "https://gkcx.eol.cn/";
    protected $client;

    protected $size = 20;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false
        ]);
    }

    /**
     * 获取院校列表
     */
    public function college_list()
    {
        $url = self::BASE_WEB_URL . "api";
        $size = $this->size;
        $page = 1;
        $params = [
            'uri' => 'gksjk/api/school/hotlists',
            'size' => $size,
            'page' => $page
        ];
        $data = $this->_getDataList($url, ['query' => $params]);
        $colleges = [];
        if ($data['rtn_code'] == 1) {
            //获取总数量
            $nums = $data['datas']['numFound'];
            $pages = ceil($nums / $size);
            $this->_createCollegeInfo($data['datas']['item']);
            if ($pages > 1) {
                for ($i = 2; $i <= $pages; $i++) {
                    $params['page'] = $i;
                    $data = $this->_getDataList($url, ['query' => $params]);
                    if ($data['rtn_code'] == 1) {
                       $this->_createCollegeInfo($data['datas']['item']);
                    }
                }
            }
            return ['code' => 1, 'message' => '完成'];
        } else {
            throw new \Exception($data['message']);
        }
    }

    /**
     * 生成院校信息
     *
     * @param $datas
     * @return array
     */
    private function _createCollegeInfo($datas)
    {
        $colleges = [];
        foreach ($datas as $data) {
            $school_id = $data['school_id'];
            $url = self::BASE_WEB_URL . 'www/school/' . $school_id . '/info.json';
            $result = $this->_getData($url);
            if ($result['rtn_code'] == 1) {
                $colleges[] = College::createData($result['data']);
            }
        }
        return $colleges;
    }

    /**
     * 采集数据
     *
     * @param $url
     * @param array $data
     * @return array
     */
    private function _getDataList($url, $data = [])
    {
        try {
            $result = $this->client->post($url, $data);
            $content = $result->getBody()->getContents();
            $datas = json_decode($content, true);
            if (isset($datas['code']) && $datas['code'] == '0000') {
                return ['rtn_code' => 1, 'datas' => $datas['data']];
            }
            throw new \Exception(isset($datas['message']) ? $datas['message'] : '获取数据失败');
        } catch (\Exception $exception) {
            return ['rtn_code' => 0, 'message' => $exception->getMessage()];
        }
    }

    /**
     * 采集详情数据
     *
     * @param $url
     * @return array
     */
    private function _getData($url)
    {
        try {
            $result = $this->client->get($url);
            $content = $result->getBody()->getContents();
            $datas = json_decode($content, true);
            if (is_array($datas)) {
                return ['rtn_code' => 1, 'data' => $datas];
            }
            throw new \Exception('数据不存在');
        } catch (\Exception $exception) {
            return ['rtn_code' => 0, 'message' => $exception->getMessage()];
        }
    }
}