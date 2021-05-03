<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SupportedCountries;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SupportedCountriesController extends AbstractController
{
    #[Route('/', name: 'countries')]
    public function getCountriesList(Request $request)
    {
        $repositoryCountries = $this->getDoctrine()->getRepository(SupportedCountries::class);
        $countries = $repositoryCountries->findAll();
        if (!$countries) {
            $encoders = [new XmlEncoder(), new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);

            $client = HttpClient::create();
            $contentCountries = $client->request('GET', 'https://kayaposoft.com/enrico/json/v2.0/?action=getSupportedCountries');
            $contentCountries = json_decode($contentCountries->getContent(), true);

            foreach ($contentCountries as $val) {
                $entityManager = $this->getDoctrine()->getManager();

                $countries = new SupportedCountries();
                $countries->setCountryCode($serializer->serialize($val['countryCode'], 'json'));
                $countries->setRegions($serializer->serialize($val['regions'], 'json'));
                $countries->setHolidayTypes($serializer->serialize($val['holidayTypes'], 'json'));
                $countries->setFullName($serializer->serialize($val['fullName'], 'json'));
                $countries->setFromDate($serializer->serialize($val['fromDate'], 'json'));
                $countries->setToDate($serializer->serialize($val['toDate'], 'json'));

                $entityManager->persist($countries);
                $entityManager->flush();

                $countryFullName[] = $val['fullName'];
            }
        } else {
            for ($i = 0; $i < count($countries); $i++) {
                $countryFullName[] = $countries[$i]->getFullName();
            }
        }
        $response = new Response();
        $response->setContent(json_encode($countryFullName));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}