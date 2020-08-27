<?php

namespace App\Controller;

use App\Entity\Opera;
use App\Entity\Place;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controller used to manage current user.
 *
 * @Security("is_granted('ROLE_USER')")
 *
 */
class ReportController extends AbstractController
{
    /**
     * @Route("/{slug}/treatments-report", methods={"GET"}, name="report_treatments")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function reportTreatments(EntityManagerInterface $em)
    {
        $from = '01/01/' . date('Y');
        $to = date('d/m/Y');

        $places = null;
        $centerId = $this->getUser()->getCenter();
        $repository = $em->getRepository(Place::class);
        $places = $repository->findBy(['center' => $centerId], ['name' => 'ASC']);

        //var_dump($places);die;

        return $this->render('/report/treatments.html.twig', [

            'all' => 0,

            'places' => $places,

            'selected_id' => '0',
            'selected_name' => 'TODOS',


            'from' => $from,
            'to' => $to,
        ]);
    }


    /**
     * @Route("/{slug}/treatments-query", methods={"GET", "POST"}, name="query_treatments")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function queryTreatments(Request $request, EntityManagerInterface $em): Response
    {
        $userId = $request->get('user_id');
        //$centerId = $this->getUser()->getCenter();

        $from = $request->get('from');
        if ($from == null){
            $from = '01/01/' . date('Y');

        }
        $to = $request->get('to');
        if ($to == null){
            $to = date('d/m/Y');
        }

        $all = $request->get('showAll');
        if ($all == null){
            $all = 0;
        } else {
            $all = 1;
        }


        $places = null;
        $centerId = $this->getUser()->getCenter();
        $repository = $em->getRepository(Place::class);
        $places = $repository->findBy(['center' => $centerId], ['name' => 'ASC']);

        $place_id = $request->get('placeId');
        //var_dump($place_id);die;

        $conn_emr   = $this->getDoctrine()->getManager()->getConnection();
        $repository = $em->getRepository(Opera::class);

        //////////////////////////////////////////////////////////////////////////////
        if($all){
            //var_dump($all);die;
            $operas = $repository->findByDatesDetail($userId, 0, $from, $to, $place_id, $conn_emr);
        } else {
            $operas = $repository->findByDates($userId, $from, $to, $place_id, $conn_emr);
        }
        //var_dump($operas);die;

        if ($place_id > 0){
            $repository = $em->getRepository(Place::class);
            $selected_name = $repository->findBy(['id' => $place_id]);
            $selected_name = $selected_name[0]->getName();
        } else {
            $selected_name = 'TODOS';
        }

        return $this->render('/report/treatments.html.twig', [

            'all' => $all,

            'places' => $places,
            'place_id' => $place_id,

            'selected_id' => $place_id,
            'selected_name' => $selected_name,

            'from' => $from,
            'to' => $to,
            'operas' => $operas
        ]);
    }

    /**
     * @Route("/{slug}/treatment-details", methods={"GET", "POST"}, name="treatment_details")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function queryTreatmentDetails(Request $request, EntityManagerInterface $em): Response
    {
        $userId = $request->get('user_id');
        $treatment_id = $request->get('treatment_id');

        $from = $request->get('from');
        if ($from == null){
            $from = '01/01/' . date('Y');
        }
        $to = $request->get('to');
        if ($to == null){
            $to = date('d/m/Y');
        }
        $place_id = $request->get('place_id');

        $conn_emr = $this->getDoctrine()->getManager()->getConnection();
        $repository = $em->getRepository(Opera::class);
        $operas = $repository->findByTreatment($userId, $treatment_id, $from, $to, $place_id, $conn_emr);

        return $this->render('/report/treatment_details.html.twig', [

            'from' => $from,
            'to' => $to,
            'operas' => $operas

        ]);
    }


}
