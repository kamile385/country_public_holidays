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

//            foreach ($d['name'] as $text) {
                if (array_key_exists($key, $val)) {
                    $result[$val[$key]][] = $d;
                } else {
                    $result[""][] = $d;
                }
//            }
        }
        return $result;
    }

    /**
     * Function that groups country array of associative arrays by date.
     *
     * @param {String} $key Property to sort by.
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

//    #[Route('/{$country}/{$year}', name: 'holidays')]
//    public function createHolidays($country, $holiday): Response
//    {
//        dump('ddd');die();
//        $client = HttpClient::create();
//
//        $responseHolidaysForYear = $client->request('GET',
//            'https://kayaposoft.com/enrico/json/v2.0/?action=getHolidaysForYear&year=2022',
//            [
//                'headers' => [
//                    'Cache-Control' => 'no-cache',
//                    'Connection' => 'keep-alive'
//                ],
//                'query' => [
//                    'country' => $country,
//                    'holidayType' => $holiday
//                ]
//            ]);
//        $contentHolidays = json_decode($responseHolidaysForYear->getContent(), true);
//
//        foreach($contentHolidays as $val)
//        {
//            // you can fetch the EntityManager via $this->getDoctrine()
//            // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
//            $entityManager = $this->getDoctrine()->getManager();
//            $holidays = new HolidaysForYear();
//            $holidays->setDate($val['date']);
//            $holidays->setName($val['name']);
//            $holidays->setHolidayType($val['holidayType']);
//
//            // tell Doctrine you want to (eventually) save the Product (no queries yet)
//            $entityManager->persist($holidays);
//
//            // actually executes the queries (i.e. the INSERT query)
//            $entityManager->flush();
//        }
//        return new Response('Saved new product with id '.$holidays->getId());
//    }
}