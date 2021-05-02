<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HolidayForYearController extends AbstractController
{
    #[Route('/{country}/{year}', name: 'holidays')]
    public function holidaysGroupByMonth($country, $year)
    {
//        &year=2022&country=ago
        $client = HttpClient::create();
        $contentHolidaysForYear = $client->request('GET', 'https://kayaposoft.com/enrico/json/v2.0/?action=getHolidaysForYear',
            [
                'headers' => [
                                    'Cache-Control' => 'no-cache',
                                    'Connection' => 'keep-alive'
                                ],
                                'query' => [
                                    'year' => $year,
                                    'country' => $country
                                ]
            ]);

        $contentHolidaysForYear = json_decode($contentHolidaysForYear->getContent(), true);
        $groupByMonth = $this->groupByMonth('month', $contentHolidaysForYear);
        $dayStatus = $this->dayStatus($groupByMonth);
//        $daysInRow = $this->daysInRow($dayStatus);
//        dump($daysInRow);
//die();
        $result = $dayStatus;
        $response = new Response();
        $response->setContent(json_encode($result));

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Function that groups country array of associative arrays by date.
     *
     * @param {String} $key Property to sort by.
     * @param {Array} $data Array that stores multiple associative arrays.
     */
    function groupByMonth($key, $data) {
        $result = array();

        foreach($data as $d) {
            $val = $d['date'];

            if (array_key_exists($key, $val)) {
                $result[$val[$key]][] = $d;
            } else {
                $result[""][] = $d;
            }
        }
        return $result;
    }

    /**
     * Function that finds a day status.
     *
     * @param {Array} $data Array that stores multiple associative arrays.
     */
    function dayStatus($data) {
        $result = array();

        $workDay = false;
        foreach($data as $key => $d) {
            for ($i = 0; $i < count($data[$key]); $i++) {
                $val = $data[$key][$i];
                if($data[$key][$i]['date']['dayOfWeek'] < 6){
                    $workDay = true;
                } else {
                    $workDay = false;
                }

                if($workDay){
                    $val = $val + array('dayStatus' => 'workday');
                } else {
                    $val = $val + array('dayStatus' => 'free day');
                }
                $result[$data[$key][$i]['date']['month']][] = $val;
            }
        }

        return $result;
    }

    /**
     * Function that finds the maximum number of free(free day + holiday) days in a row, which will be by a given country and year
     *
     * @param {Array} $data Array that stores multiple associative arrays.
     */
    public function daysInRow($data){
        $result = array();

        $counter = 0;
        foreach($data as $key => $d) {
            foreach ($d as $k => $dd) {dump($d);
//                $count = count($k);
//                $val = $dd['date']['day'];
////                if ($count > 0) {
//                    for ($i = 0; $i < $count - 1; $i++) {
//                        if ($data[$key][$i]['date']['day'] < $data[$key][$i++]['date']['day']) {
//                            if ($val['dayStatus'] == 'free day') {
//                                $counter++;
//                            }
//                            $result[$data[$key][$i]['date']['month']][] = $val + array('daysInRow' => $counter);
//                        }
////                    }
//                }
            }
        }die();
//                $val = $dd['date']['day'];
//
//                if($val>$max){
//                    $max = $val;
//                }
//                dump($max);die();
//
//
////                if ($data[$key][$i]['date']['day'] < $data[$key][$i++]['date']['day']) {
////                    dump($data[$key][$i]['date']['day']);
////                    if ($val['dayStatus'] == 'free day') {
////                        $counter++;
////                    }
////                    $result[$data[$key][$i]['date']['month']][] = $val + array('daysInRow' => $counter);
////                }
//            }
//            for ($i = 0; $i < $sum; $i++) {
//                if($sum > 1) {
//                    $val = $data[$key][$i];
//
//                    if ($data[$key][$i]['date']['day'] < $data[$key][$i++]['date']['day']) {
//                        dump($data[$key][$i]['date']['day']);
//                        if ($val['dayStatus'] == 'free day') {
//                            $counter++;
//                        }
//                        $result[$data[$key][$i]['date']['month']][] = $val + array('daysInRow' => $counter);
//                    }
////                $result[$data[$key][$i]['date']['month']][] = $val;
//                }
//            }
        dump($result);die();

        return $result;
    }

}