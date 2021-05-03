<?php


namespace App\Controller;


use App\Entity\HolidaysForYear;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class HolidayForYearController extends AbstractController
{
    #[Route('/{country}/{year}', name: 'holidays')]
    public function holidaysGroupByMonth($country, $year)
    {
//        &year=2021&country=ltu
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
        $repositoryHolidays = $this->getDoctrine()->getRepository(HolidaysForYear::class);

        $holidays = $repositoryHolidays->findBy(['date' => $year]);

        if(!$holidays) {
            foreach ($contentHolidaysForYear as $val) {
                $entityManager = $this->getDoctrine()->getManager();

                $holidays = new HolidaysForYear();
                $holidays->setDate($val['date']);
                $holidays->setName($val['name']);
                $holidays->setHolidayType(array('holidayType' => $val['holidayType']));

                $entityManager->persist($holidays);
                $entityManager->flush();
            }
        } else {
            for ($i = 0; $i < count($holidays); $i++) {
                $contentHolidaysForYear = $holidays[$i];
            }
        }
        $groupByMonth = $this->groupByMonth('month', $contentHolidaysForYear);
        $dayStatus = $this->dayStatus($groupByMonth);
        $daysInRow = $this->daysInRow($dayStatus);

        $result = $daysInRow;
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

        foreach($data as $key => $d) {
            $counter = 1;
            $count = sizeof($d);
                if ($count > 1) {
                    $last = $data[$key][0]['date']['day'];
                    for ($i = 1; $i < $count; $i++) {
                        if ($data[$key][$i]['date']['day'] == $last + 1) {
//                            if($data[$key][$i]['dayStatus'] == 'free day'){
                                $counter++;
//                            }
                        }
                        $last = $data[$key][$i]['date']['day'];
                }
            }
            for ($i = 0; $i < $count; $i++) {
                $val = $data[$key][$i];
                $result[$data[$key][$i]['date']['month']][] = $val + array('daysInRow' => $counter);
            }
        }
        return $result;
    }

}