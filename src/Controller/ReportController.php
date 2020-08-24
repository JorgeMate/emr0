<?php

namespace App\Controller;

use App\Entity\Opera;

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
     */
    public function reportTreatments()
    {
        $from = '01/01/' . date('Y');
        $to = date('d/m/Y');

        return $this->render('/report/treatments.html.twig', [
            'from' => $from,
            'to' => $to,
        ]);
    }


    /**
     * @Route("/{slug}/treatments-query", methods={"POST"}, name="query_treatments")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function queryTreatments(Request $request, EntityManagerInterface $em): Response
    {

        $userId = $request->get('user_id');

        $from = $request->request->get('from');
        $to = $request->request->get('to');


        $repository = $em->getRepository(Opera::class);
        $operas = $repository->findByDates($userId, $from, $to);


        //var_dump($operas);die;


        return $this->render('/report/treatments.html.twig', [

            'from' => $from,
            'to' => $to,
            'operas' => $operas


        ]);
    }




}
