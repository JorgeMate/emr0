<?php


namespace App\Controller;

use SuperSaaS\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use App\Entity\Patient;

/**
 * Controller used to manage current user.
 *
 * @Route("/schedule")
 * @Security("is_granted('ROLE_USER')")
 *
 */
class AgendaController extends AbstractController
{
    /**
     * @Route("/{slug}/agenda/{id}", methods={"GET","POST"}, name="agenda_detail")
     * @param $id
     * @return Response
     */
    public function showAgendaResources($id): Response
    {
        $resources = null;

        $user = $this->getUser();
        $center = $user->getCenter();

        $this->denyAccessUnlessGranted('USER_EDIT', $user);

        $client = new Client();
        $client->account_name = $center->getSsaasAccountName();
        $client->api_key = $center->getSsaasApiKey();


        $resources = $client->schedules->resources($id);

        //var_dump($resources);die;

        return $this->render('agenda/agenda_resources.html.twig', [

            'user' => $user,
            #'center' => $center,

            'resources' => $resources,

        ]);

    }

    /**
     * @Route("/{slug}/agendas-users", methods={"GET"}, name="agendas_users")
     * @return Response
     */
     public function agendasUsers(): Response
     {
         $user = $this->getUser();
         $this->denyAccessUnlessGranted('USER_EDIT', $user);

         $center = $user->getCenter();

         $client = new Client();
         $client->account_name = $center->getSsaasAccountName();
         $client->api_key = $center->getSsaasApiKey();

         $usersA = $client->users->getList();
         //var_dump($usersA);die;
         $agendas = $client->schedules->getList();

         return $this->render('agenda/agendas_users.html.twig', [

             'usersA' => $usersA,
             'agendas' => $agendas,

         ]);

     }


    /**
     * @Route ("/{slug}/{id}/agenda-frame", methods={"GET","POST"}, name="agenda_frame")
     * @param Request $request
     * @param $id
     * @return Response
     */
     public function agendaFrame(Request $request, Patient $id): Response
     {
         $agenda = $request->get('after');
         $ac_name = $request->get('account');
         $arguments = $request->get('arguments');

         //var_dump($arguments);die;

         //return $this->redirectTo('https://www.supersaas.com/schedule/Nicole');

         return $this->render('agenda/agenda_frame.html.twig', [
             'agenda' => $agenda,
             'ac_name' => $ac_name,
             'arguments' => $arguments,

             'patient' => $id,
         ]);
     }

    /**
     * @Route ("/{slug}/patient/{id}/records", methods={"GET"}, name="patient_apts")
     * @param Patient $patient
     * @return Response
     */
     public function patientAppointments(Patient $patient): Response
     {
         $connAgenda = new \PDO('mysql:host=kimberly-systems.xyz;dbname=agenda0', 'agenda0_user', 'NoLoSe$13');

         $mysql_query = "SET NAMES 'utf8'";
         $stmt = $connAgenda->prepare($mysql_query);
         $stmt->execute();

         $sql = 'SELECT apt.* FROM apt
                    INNER JOIN (SELECT saas_id, MAX(id) AS max_id FROM apt GROUP BY saas_id) t0
                    ON (apt.saas_id = t0.saas_id AND apt.id = t0.max_id)
                    WHERE apt.patient_id = :patient_id
                    AND apt.event <> "destroy" 
                    ORDER BY start';
         $stmt = $connAgenda->prepare($sql);
         $stmt->bindValue(':patient_id', $patient->getId(), \PDO::PARAM_STR);
         $stmt->execute();
         $records = $stmt->fetchAll();
         //var_dump($records);die;

         $ac_name = $this->getUser()->getCenter()->getSsaasAccountName();
         $api_key = $this->getUser()->getCenter()->getSsaasApiKey();
         $checksum = md5($ac_name . $api_key . $this->getUser()->getEmail());

         return $this->render('agenda/patient_apts.html.twig',[
             'records' => $records,
             'patient' => $patient,
             'ac_name' => $ac_name,
             'api_key' => $api_key,
             'checksum' => $checksum,
         ]);
     }

}