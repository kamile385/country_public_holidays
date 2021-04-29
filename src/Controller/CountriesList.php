<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;

class CountriesList extends AbstractController
{
    /**
     * @Route("/")
     */
    public function getCountriesList(Request $request) {
//        dump($request->query->get('year'));

        $client = HttpClient::create();
        $responseSupportedCountries = $client->request('GET', 'https://kayaposoft.com/enrico/json/v2.0/?action=getSupportedCountries');
//        $responseHolidaysForYear = $client->request('GET', 'https://kayaposoft.com/enrico/json/v2.0/?action=getHolidaysForYear&year=2022&country=est&holidayType=public_holiday');

        $contentSupportedCountries = json_decode($responseSupportedCountries->getContent(), true);
//        dump($contentSupportedCountries);
        foreach ($contentSupportedCountries as $key => $item){
//            dump($item['countryCode']);
//            $url = $this->parseUrl('https://kayaposoft.com/enrico/json/v2.0/?action=getHolidaysForYear&year=2022&country=est&holidayType=public_holiday',
//                $item['countryCode'], $item['fromDate']['year'], $item['toDate']['year'], $item['holidayTypes']);
//            dump($item['holidayTypes']);
//            dump($url);
//            $responseHolidaysForYear = $client->request('GET', $url);
            foreach ($item['holidayTypes'] as $key => $holidayType) {
                $responseHolidaysForYear = $client->request('GET',
                    'https://kayaposoft.com/enrico/json/v2.0/?action=getHolidaysForYear&year=2022',
                    [
//                'auth_bearer' => $this->auth_bearer,
                        'headers' => [
                            'Cache-Control' => 'no-cache',
                            'Connection' => 'keep-alive'
                        ],
                        'query' => [
                            'country' => $item['countryCode'],
//                            'holidayType' => $item['holidayTypes']
                            'holidayType' => $holidayType
                        ]
                    ]);
                $contentHolidaysForYear = json_decode($responseHolidaysForYear->getContent(), true);

            }
            $groupByMonth = $this->group_by('month', $contentHolidaysForYear);
//            dump($groupByMonth);
        }
return $contentHolidaysForYear;

// $content = '{"id":521583, "name":"symfony-docs", ...}'
//        dump($content);
//        return $this->render('base.html.twig');
//        return new Response('What a bewitching controller we have conjured!');
    }

    /**
     * Function that groups an array of associative arrays by some key.
     *
     * @param {String} $key Property to sort by.
     * @param {Array} $data Array that stores multiple associative arrays.
     */
    function group_by($key, $data) {
        $result = array();

        foreach($data as $d) {
            $val = $d['date'];

            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $d;
            }else{
                $result[""][] = $d;
            }
        }
        return $result;
    }
}