<?php

namespace App\Controller;

use App\Entity\ReportType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

//use Doctrine\ORM\EntityManagerInterface;



/**
 * Controller used to manage current user.
 *
 * @Security("is_granted('ROLE_USER')")
 *
 */
class ReportController extends AbstractController
{
  

   /**
     * @Route("/{slug}/patient-report-types", methods={"GET", "POST"}, name="report_types_index")
     * @param Request $request
     * @param $slug
     * @return Response
     */
    public function reportTypesIndex(Request $request, $slug): Response
    {

        $center = $this->getUser()->getCenter();

        $this->denyAccessUnlessGranted('CENTER_VIEW', $center);

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(ReportType::class);
        $types = $repository->findBy(['center' => $center->getId()], ['name' => 'ASC']);

        return $this->render('/report/index.html.twig', [
             
            'slug' => $slug,
            'types' => $types,
        ]);     

        
    }



}
