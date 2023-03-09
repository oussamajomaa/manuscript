<?php

namespace App\Controller;

use App\Entity\SecondaryCreator;
use App\Repository\CatalogueRepository;
use App\Repository\PrimaryCreatorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use App\Factory\JsonResponseFactory;
use App\Repository\SecondaryCreatorRepository;

#[Route('/api', name: 'app_api')]
class ApiController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer)
    {
    }
    #[Route('/catalogue', name: 'app_api_catalogue')]
    public function catalogue(CatalogueRepository $repo, array $headers = []): Response
    {
        $catalogues = $repo->findAll();
        $data = [];
        foreach ($catalogues as $key => $catalogue) {
            $data[$key]['id'] = $catalogue->getId();
            $data[$key]['identifier'] = $catalogue->getIdentifier();
            $data[$key]['title'] = $catalogue->getTitle();
            $data[$key]['repository'] = $catalogue->getRepository();


            $primary = [];
            foreach ($catalogue->getPrimaryCreator() as $k => $author) {
                $primary[$k]['first_name'] = $author->getFirstName();
                // dd($author->getFirstName());
            }
            // dd($primary);
            $data[$key]['primary'] = $primary;

            $secondary = [];
            foreach ($catalogue->getSecondaryCreator() as $k => $author) {
                // dd(count($catalogue->getSecondaryCreator()));
                $secondary[$k]['first_name'] = $author->getFirstName();
            }
            $data[$key]['secondary'] = $secondary;
        }
        // dd(($data));
        return new JsonResponse($data);
    }

    #[Route('/author', name: 'app_api_author')]
    public function author(PrimaryCreatorRepository $repo1, SecondaryCreatorRepository $repo2 ): Response
    {
        $primary = $repo1->findAll();
        $secondary = $repo2->findAll();
        $data = [];
        foreach ($primary as $key1 => $authorp) {
            $data[$key1]['first_name'] = $authorp->getFirstName();
            $data[$key1]['last_name'] = $authorp->getLastName();
            
            $primary_creator = [];
            foreach ($authorp->getCatalogues() as $k1 => $catalogue) {
                $primary_creator[$k1]['id'] = $catalogue->getId();
                $primary_creator[$k1]['title'] = $catalogue->getTitle();
            }
            // dd($catalogues);
            $data[$key1]['primary'] = $primary_creator;
        }
        // dd($data[0]);

        foreach ($secondary as $key1 => $authorr) {
            // $data[$key1]['first_name'] = $authorr->getFirstName();
            // $data[$key1]['last_name'] = $authorr->getLastName();
           
            $secondary_creator = [];
            foreach ($authorr->getCatalogues() as $k2 => $catalogue) {
                // $data[$key1]['catalogues'][$k2]['title'] = $catalogue->getTitle();
                $secondary_creator[$k1]['id'] = $catalogue->getId();
                $secondary_creator[$k2]['title'] = $catalogue->getTitle();
            }
            $data[$key1]['secondary'] = $secondary_creator;
        }


        return new JsonResponse($data);
    }

    #[Route('/test', name: 'app_api_test')]
    public function test(PrimaryCreatorRepository $repo): Response
    {
        $authors = $repo->findAll();
        $data = [];
        foreach ($authors as $key => $author) {

            $data[$key]['first_name'] = $author->getFirstName();
            $data[$key]['last_name'] = $author->getLastName();
            $data[$key]['authority_link'] = $author->getAuthorityLink();
            $catalogues = [];
            foreach ($author->getCatalogues() as $k => $catalogue) {
                // dump($author->getFirstName());
                // dump($catalogue->getTitle());
                $catalogues[$k]['title'] = $catalogue->getTitle();
                // $catalogues[$key]['identifier'] = $catalogue->getIdentifier();
                // $catalogues[$key]['repository'] = $catalogue->getRepository();
                // $catalogues[$key]['shelfmark'] = $catalogue->getShelfmark();
                // $catalogues[$key]['title'] = $catalogue->getTitle();
                // $catalogues[$key]['link_archive_catalogue'] = $catalogue->getLinkArchiveCatalogue();
                // $catalogues[$key]['digital_resource'] = $catalogue->getDigitalResource();
                // $catalogues[$key]['autograph'] = $catalogue->getAutograph();
                // $catalogues[$key]['incipit_diplomatic'] = $catalogue->getIncipitDiplomatic();
                // $catalogues[$key]['incipit_modernised'] = $catalogue->getIncipitModernised();
                // $catalogues[$key]['text_language'] = $catalogue->getTextLanguage();
                // $catalogues[$key]['brief_summary'] = $catalogue->getBriefSummary();
                // $catalogues[$key]['detailed_summary'] = $catalogue->getDetailedSummary();
                // $catalogues[$key]['keywords'] = $catalogue->getKeywords();
                // $catalogues[$key]['genre'] = $catalogue->getGenre();
                // $catalogues[$key]['status'] = $catalogue->getStatus();
                // $catalogues[$key]['inclusions'] = $catalogue->getInclusions();
                // $catalogues[$key]['bibliography'] = $catalogue->getBibliography();
                // $catalogues[$key]['material'] = $catalogue->getMaterial();
                // $catalogues[$key]['extent'] = $catalogue->getExtent();
                // $catalogues[$key]['format'] = $catalogue->getFormat();
                // $catalogues[$key]['dimensions'] = $catalogue->getDimensions();
                // $catalogues[$key]['watermark'] = $catalogue->getWatermark();
                // $catalogues[$key]['additional_comments'] = $catalogue->getAdditionalComments();
                // $catalogues[$key]['hands'] = $catalogue->getHands();
                // $catalogues[$key]['additions'] = $catalogue->getAdditions();
                // $catalogues[$key]['decorations'] = $catalogue->getDecorations();
                // $catalogues[$key]['date'] = $catalogue->getDate();
                // $catalogues[$key]['origin'] = $catalogue->getOrigin();
                // $catalogues[$key]['ownership'] = $catalogue->getOwnership();
                // $catalogues[$key]['provenance'] = $catalogue->getProvenance();
                // $catalogues[$key]['link_digital_voltaire'] = $catalogue->getLinkDigitalVoltaire();
                // $catalogues[$key]['ocv_volume'] = $catalogue->getOcvVolume();
                // $catalogues[$key]['ocv_chapter'] = $catalogue->getOcvChapter();
                // $catalogues[$key]['text_chapter'] = $catalogue->getTextChapter();
                // $catalogues[$key]['text_reference'] = $catalogue->getTextReference();
                // $catalogues[$key]['manuscript_details'] = $catalogue->getManuscriptDetails();
            }
            $data[$key]['catalogues'] = $catalogues;
        }
        dump($data);
        // dump($data);
        return $this->render('api/index.html.twig');
    }
}
