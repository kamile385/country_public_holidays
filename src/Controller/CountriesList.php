<?php


namespace App\Controller;


use App\Entity\SupportedCountries;
use App\Entity\HolidaysForYear;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;

class CountriesList extends AbstractController
{
    /**
     * Function that gets all supported countries list
     *
     * @Route("/", name="country_list")
     */
    public function getCountriesList(Request $request) {
//        dump($request->query->get('year'));

        $repositoryCountries = $this->getDoctrine()->getRepository(SupportedCountries::class);
        $countries = $repositoryCountries->findAll();

        $client = HttpClient::create();
//dump($countries);
        for ($i = 0; $i < count($countries); $i++) {
            $countryFullName[] = $countries[$i]->getFullName();
            $holidayTypes = $countries[$i]->getHolidayTypes();
//dump($countryFullName);
            $repositoryHolidays = $this->getDoctrine()->getRepository(HolidaysForYear::class);


                foreach ($holidayTypes as $key => $holidayType) {
//                    $holidays = $repositoryHolidays->findBy(array('country' => $countries[$i]->getCountryCode(), 'holidayType' => $holidayType));
//                    if(empty($holidays)) {
//                        $responseHolidaysForYear = $client->request('GET',
//                            'https://kayaposoft.com/enrico/json/v2.0/?action=getHolidaysForYear&year=2022',
//                            [
//                                'headers' => [
//                                    'Cache-Control' => 'no-cache',
//                                    'Connection' => 'keep-alive'
//                                ],
//                                'query' => [
//                                    'country' => $countries[$i]->getCountryCode(),
//                                    'holidayType' => $holidayType
//                                ]
//                            ]);
//                        $contentHolidaysForYear = json_decode($responseHolidaysForYear->getContent(), true);
//                        $this->redirectToRoute('homepage');
//                        ($countries[$i]->getCountryCode(), $holidayType);
                    }


                }

//            dump($contentHolidaysForYear);
//                $groupByMonth = $this->groupBy('month', $contentHolidaysForYear);
//            dump($groupByMonth);
//            $dayStatus = $this->getDayStatus($groupByMonth);
//            }

//        }
        $response = new Response();
        $response->setContent(json_encode($countryFullName));
        $response->headers->set('Content-Type', 'application/json');
        return $response;



//        return new Response(json_encode());

// $content = '{"id":521583, "name":"symfony-docs", ...}'
//        dump($content);
//        return $this->render('base.html.twig');
//        return new Response('What a bewitching controller we have conjured!');
    }

//    /**
//     * Function that groups country array of associative arrays by date.
//     *
//     * @param {String} $key Property to sort by.
//     * @param {Array} $data Array that stores multiple associative arrays.
//     */
//    function groupBy($key, $data) {
//        $result = array();
//
//        foreach($data as $d) {
//            $val = $d['date'];
//
//            if(array_key_exists($key, $val)){
//                $result[$val[$key]][] = $d;
//            }else{
//                $result[""][] = $d;
//            }
//        }
//        return $result;
//    }

//    function getDayStatus($data){
//        $days = array();
//
//        $workday = false;
//        $sequence = false;
//        foreach($data as $key => $d) {
//            if(count($d) > 1) {
//                foreach ($d as $key => $item) {
//                    $val = $item['date']['dayOfWeek'];
//                    if (1 < $val && $val < 6) {
//                        $workday = true;
//                    }
//                    if ($workday) $days[] = $item['date']['day'];
//                }
//
//                if (is_array($days) && !empty($days)){
//                    for($i=0; $i < count($d); $i++) {
//                        if($days[$i] < $days[$i++] && $days[$i] == $days[$i++] - 1 ){
//                            $sequence = true;
//                        } else {
//                            $sequence = false;
//                        }
//                    }
//                }
//            }
//        }
//
//        return $sequence;
//    }

}