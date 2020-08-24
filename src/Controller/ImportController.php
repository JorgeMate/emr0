<?php

namespace App\Controller;

use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;

use App\Entity\Center;
use App\Entity\Insurance;
use App\Entity\Source;
use App\Entity\Place;
use App\Entity\Type;
use App\Entity\Patient;
use App\Entity\DocPatient;
use App\Entity\DocImgPatient;

use Symfony\Component\HttpFoundation\File\File;

class ImportController extends AbstractController
{

    public function importDocImgHelper($item, $type, UploaderHelper $uploaderHelper)
    {

        $yearDir = substr($item['created_at'], 0, 4);
        $oldfileName = substr($item['file_random_name'], 0, 10) . '.jpg';
        $oldfileDescription = substr($item['file_random_name'], 11);
        $oldfileDescription = substr($oldfileDescription, 0, strlen($oldfileDescription) - 4);

        if($type == 'doc'){
            $folder = 'DOCS';
            $storedFile = new DocPatient();
        } else {
            $folder = 'IMGS';
            $storedFile = new DocImgPatient();

        }

        if (file_exists('/home/jorge/Documentos/FRAX100/'. $folder .'/' . $yearDir . '/' . $oldfileName)) {
            //var_dump('/home/jorge/Documentos/FRAX100/'. $folder . '/' . $yearDir . '/' . $oldfileName);die;

            $uploadedFile = '/home/jorge/Documentos/FRAX100/'. $folder . '/' . $yearDir . '/' . $oldfileName;

            $repo = $em->getRepository(Patient::class);
            $patient = $repo->findOneBy(['id' => $item['paciente_id']]) ;

            if ($patient){
                $storedFile->setPatient($patient);
            }
            $storedFile->setVisible(true);

            if($type == 'doc'){
                $newFilename = $uploaderHelper->uploadPatientDoc(new File($uploadedFile), $storedDoc->getName());
            } else {
                $newFilename = $uploaderHelper->uploadPatientImage(new File($uploadedFile), $storedImg->getName());
            }

            $storedFile->setUpdatedAt(date_create_from_format('Y-m-d H:i:s', $item['created_at']));
            $storedFile->setName($newFilename);
            $storedFile->setOriginalFilename($oldfileName);
            $storedFile->setDescription($oldfileDescription);
            $storedFile->setMimeType(mime_content_type($uploadedFile));
            $storedFile->setDocSize(filesize($uploadedFile));

            $em->persist($storedFile);
            $em->flush();
        }
    }


    private function getLastId($table, $conn_emr)
    {
        $sqlLast = "SELECT max(id) AS last FROM " . $table;
        $stmt = $conn_emr->prepare($sqlLast);

        $stmt->execute();
        $item = $stmt->fetchAll();
        $lastId = $item[0]['last'];
        //var_dump($lastId);die;

        return $lastId;
    }


    /**
     * @Route("/import-data-for-center/{id}", name="import")
     * @param Request $request
     * @param Center $center
     * @param File $file
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function index(Request $request, Center $center, EntityManagerInterface $em)
    {
        $items = null;

        $action = $request->get('action');
        $em = $this->getDoctrine()->getManager();

        if($center->getId() == 2){ // solo para el centro 2
            $conn       = new \PDO('mysql:host=localhost;dbname=a01_kam', 'root', 'pass');
            $conn_emr   = $this->getDoctrine()->getManager()->getConnection();
            //$conn_emr   = new \PDO('mysql:host=localhost;dbname=emr0', 'root', 'pass');

            if($action == 'insurances'){

                $sql = '
                    SELECT id, cia, UZOVI FROM seguro ORDER BY id
                ';
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $items = $stmt->fetchAll();

                foreach($items as $key => $item) {

                    $ins = new Insurance;
                    $ins->setName($item['cia']);
                    $ins->setCode($item['UZOVI']);
                    $ins->setCenter($center);
                    $ins->setEnabled(true);

                    $em->persist($ins);

                    if (false){

                        $em->persist($ins);
                        if ($item['id'] == 13 ){ // 14 vacío...
                            $sou = new Insurance;
                            $sou->setCenter($center);
                            $sou->setEnabled(false);
                            $sou->setName('-------');
                            $em->persist($sou);
                        }
    
                        $em->persist($ins);
                        if ($item['id'] == 15 ){ // 16 vacío...
                            $sou = new Insurance;
                            $sou->setCenter($center);
                            $sou->setEnabled(false);
                            $sou->setName('-------');
                            $em->persist($sou);
                        }
    
                    }

                }

                // insert into insurance (name, code, center_id, created_at, slug) values ('IZA CURA', '3324', 2, NOW(), 'IZA-CURA')
                // insert into insurance (name, code, center_id, created_at, slug) values ('AEVITAE (ASR Ziektekosten)', '3328', 2, NOW(), 'AEVITAE-ASR-Ziektekosten')

                $em->flush();

                
            }

            if($action == 'sources'){

                $sql = '
                    SELECT id, cia, tel, contact, notas, email, seleccionar 
                    FROM partner ORDER BY id
                ';
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $items = $stmt->fetchAll();

                foreach($items as $key => $item) {

                    $sou = new Source;
                    $sou->setName($item['cia']);
                    $sou->setTel($item['tel']);
                    $sou->setContact($item['contact']);
                    $sou->setNotes($item['notas']);
                    $sou->setEmail($item['email']);

                    $sou->setCenter($center);

                    $sou->setEnabled(false);
                    if($item['seleccionar']){
                        $sou->setEnabled(true);
                    }

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($sou);


                }
                
                $em->flush();

            }
            if($action == 'source_internal'){

                
                $sql = "
                INSERT INTO source (id, name, enabled, created_at, slug, center_id) VALUES 
                (0, 'PCHA', 0, NOW(), 'PCHA', 2),
                (-1, 'PCHA-DG', 0, NOW(), 'PCHA-DG', 2),
                (-2, 'PCHA-VZ', 0, NOW(), 'PCHA-VZ', 2),
                (-3, 'RBK', 1, NOW(), 'RBK', 2),
                (-4, 'RBK-VZ', 1, NOW(), 'RBK-VZ', 2),
                (-5, 'RBK-SPANJE', 1, NOW(), 'RBK-SPANJE', 2)
                ";
                $stmt = $conn_emr->prepare($sql);
                $stmt->execute();



            }

            if($action == 'places'){

                $sql = '
                SELECT id, place, place AS cia FROM opera_loc ORDER BY id
                ';
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $items = $stmt->fetchAll();

                foreach($items as $key => $item) {

                    $pla = new Place;
                    $pla->setName($item['place']);
                    $pla->setCenter($center);
                    $pla->setEnabled(true);

                    $em->persist($pla);
                }
                
                $em->flush();
            }

            if($action == 'types'){

                $sql = '
                SELECT id, tipo, tipo AS cia FROM tratamiento_tipo ORDER BY id
                ';
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $items = $stmt->fetchAll();

                foreach($items as $key => $item) {

                    $typ = new Type;
                    $typ->setName($item['tipo']);
                    $typ->setCenter($center);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($typ);

                    if ($item['id'] == 11){ // 12 vacío...
                        $sou = new Type;
                        $sou->setCenter($center);
                        $sou->setName('-------');
                        $em->persist($sou);
                    }


                }

                $em->flush();                
            }

            if($action == 'treatments'){

                $lastId = $this->getLastId('treatment', $conn_emr);

                $sql = "
                    SELECT id, tipo_id, concepto, importe, notas, concepto as cia FROM tratamiento 
                    WHERE id > :lastId 
                    ORDER BY id
                ";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':lastId', $lastId);

                $stmt->execute();
                $items = $stmt->fetchAll();

                //$em = $this->getDoctrine()->getManager();
                //$repository = $em->getRepository(Type::class);

                // Conectamos al destino e insertamos tradicionalmente

    
                foreach($items as $key => $item) {

                    $sql = "
                        INSERT INTO treatment (id, type_id, name, notes, value) VALUES (:id, :type_id, :name, :notes, :value);
                    ";

                    $stmt = $conn_emr->prepare($sql);

                    $stmt->bindValue(':id', $item['id']);                    
                    $stmt->bindValue(':type_id', $item['tipo_id']);

                    $stmt->bindValue(':name', $item['concepto']);
                    $stmt->bindValue(':notes', $item['notas']);
                    $stmt->bindValue(':value', $item['importe']);

                    $stmt->execute();

                }

                

            }  
            
            if($action == 'patients') {

                $sqlLast = "SELECT max(id) AS cuantos FROM patient";
                $stmt = $conn_emr->prepare($sqlLast);
                $stmt->execute();

                $item = $stmt->fetchAll();
                //var_dump($item);die;

                $cuantos = $item[0]['cuantos'];
                //var_dump($cuantos);die;



                $sql = "
                    SELECT id, webuser_id, seguro_id, external,
                    AES_DECRYPT(paciente.firstname, SHA1('Alumbre41')) AS firstname, 
                    AES_DECRYPT(paciente.lastname, SHA1('Alumbre41')) AS lastname,
                    sex, birthdate,
                    AES_DECRYPT(paciente.email, SHA1('Alumbre41')) AS email,
                    AES_DECRYPT(paciente.address, SHA1('Alumbre41')) AS address,
                    house_no, AES_DECRYPT(paciente.house_ch, SHA1('Alumbre41')) AS house_ch,
                    AES_DECRYPT(paciente.city, SHA1('Alumbre41')) AS city,
                    AES_DECRYPT(paciente.postcode, SHA1('Alumbre41')) AS postcode,
                    AES_DECRYPT(paciente.tel, SHA1('Alumbre41')) AS tel,
                    AES_DECRYPT(paciente.cel, SHA1('Alumbre41')) AS cel,
                    created_at,
                    AES_DECRYPT(paciente.contact, SHA1('Alumbre41')) AS contact,
                    AES_DECRYPT(paciente.tel_con, SHA1('Alumbre41')) AS tel_con,
                    AES_DECRYPT(paciente.pvd, SHA1('Alumbre41')) AS pvd,
                    AES_DECRYPT(paciente.notas, SHA1('Alumbre41')) AS notas,
                    AES_DECRYPT(paciente.bsn, SHA1('Alumbre41')) AS bsn
                    
                    FROM paciente WHERE id > 0 AND id > :cuantos ORDER BY id
                ";

                $stmt = $conn->prepare($sql);

                $stmt->bindValue(':cuantos', $cuantos);

                $stmt->execute();
                $items = $stmt->fetchAll();

                //var_dump($items);die;

                foreach($items as $key => $item) {

                    $sql = "
                    INSERT INTO patient 
                    (id, user_id, insurance_id, source_id, firstname, lastname, created_at, date_of_birth, sex, email, address, house_no,
                    house_txt, city, postcode, tel, cel, contact, tel_con, doctor, notes, code1) 
                    VALUES 
                    (:id, :user_id, :insurance_id, :source_id, :firstname, :lastname, :created_at, :birthdate, :sex, :email, :address, :house_no, 
                    :house_txt, :city, :postcode, :tel, :cel, :contact, :tel_con, :doctor, :notes, :code1)
                    
                    ";

                    $stmt = $conn_emr->prepare($sql);
    
                    $stmt->bindValue(':id', $item['id']);
                    $stmt->bindValue(':user_id', 2);

                    $ins = $item['seguro_id'];
                    if($item['seguro_id'] == 0) {
                        $ins = NULL;
                    }
                    $stmt->bindValue(':insurance_id', $ins);

                    $sou = $item['external'];
                    if($item['external'] == 0) {
                        $sou = NULL;
                    }
                    $stmt->bindValue(':source_id', $sou);

                    $stmt->bindValue(':firstname', $item['firstname']);

                    if($item['lastname'] == null){
                        $item['lastname'] = '';
                    }

                    $stmt->bindValue(':lastname', $item['lastname']);

                    $stmt->bindValue(':created_at', $item['created_at']);

                    // Comprobar fecha correcta

                    if ($item['birthdate'] != '0000-00-00')
                        $stmt->bindValue(':birthdate', $item['birthdate']);
                    else {
                        $stmt->bindValue(':birthdate', null);
                    }
                    
                    if($item['sex'] == 2) {
                    $sex = 1;
                    } else {
                    $sex = 0;
                    }
                    
                    $stmt->bindValue(':sex', $sex);
                    
                    $stmt->bindValue(':email', $item['email']);
                    $stmt->bindValue(':address', $item['address']);
                    $stmt->bindValue(':house_no', $item['house_no']);
                    $stmt->bindValue(':house_txt', $item['house_ch']);
                    $stmt->bindValue(':city', $item['city']);
                    $stmt->bindValue(':postcode', $item['postcode']);
                    $stmt->bindValue(':tel', $item['tel']);
                    $stmt->bindValue(':cel', $item['cel']);
                    
                    $stmt->bindValue(':contact', $item['contact']);
                    $stmt->bindValue(':tel_con', $item['tel_con']);
                    
                    $stmt->bindValue(':doctor', $item['pvd']);
                    $stmt->bindValue(':notes', $item['notas']);
                    
                    $stmt->bindValue(':code1', $item['bsn']);            

                    $stmt->execute();

                }

            }

            if($action == 'consults') {

                $sqlLast = "SELECT max(id) AS cuantos FROM consult";
                $stmt = $conn_emr->prepare($sqlLast);
                $stmt->execute();

                $item = $stmt->fetchAll();
                //var_dump($item);die;

                $cuantos = $item[0]['cuantos'];
                //var_dump($cuantos);die;


                $sql = "
                SELECT id, paciente_id, consult, treatment, 
                AES_DECRYPT(notas, SHA1('Alumbre41')) AS notas, created_at 
                FROM consulta 
                WHERE id > :cuantos
                ";



                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':cuantos', $cuantos);
                $stmt->execute();
                $items = $stmt->fetchAll();

                //var_dump($items);die;

                foreach($items as $key => $item) {

                    // Buscamos si existe el paciente asociado a la consulta

                    $sqlSeek = "SELECT id from patient WHERE id = :id";
                    $stmtSeek = $conn_emr->prepare($sqlSeek);
                    $stmtSeek->bindValue(':id', $item['paciente_id']);
                    $stmtSeek->execute();
                    $PatId = $stmtSeek->fetchAll();

                    if ($PatId) {

                        $sql = "
                        INSERT INTO consult 
                        (id, patient_id, user_id, consult, result, notes, created_at) 
                        VALUES 
                        (:id, :patient_id, :user_id, :consult, :treatment, :notes, :created_at) 
                        ";

                        $stmt = $conn_emr->prepare($sql);
            
                        $stmt->bindValue(':id', $item['id']);
                        $stmt->bindValue(':patient_id', $item['paciente_id']);
                        $stmt->bindValue(':user_id', 2);
                        $stmt->bindValue(':consult', $item['consult']);
                        $stmt->bindValue(':treatment', $item['treatment']);
                        $stmt->bindValue(':notes', $item['notas']);
                        $stmt->bindValue(':created_at', $item['created_at']);
            
                        $stmt->execute();

                    }
                }


            }

            if($action == 'operas'){

                $lastId = $this->getLastId('opera', $conn_emr);
                //var_dump($lastId);die;

                $sql = "
                    SELECT * FROM opera where
                        id > :lastId 
                    AND
                    tratamiento_id is not null 
                    AND tratamiento_id > 0
                    AND tratamiento_id <> 145
                    AND id_paciente <> 19211
                    AND id_paciente <> 19381
                    AND id > 1328
                ";

                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':lastId', $lastId);

                $stmt->execute();
                $items = $stmt->fetchAll();

                foreach($items as $key => $item) {
                    $sql = "
                    INSERT INTO opera
                    (id, patient_id, user_id, treatment_id, place_id, created_at, made_at, value) 
                    VALUES 
                    (:id, :patient_id, :user_id, :treatment_id, :place_id, NOW(), :made_at, 0) 
                    ";
        
                    $stmt = $conn_emr->prepare($sql);

                    $stmt->bindValue(':id', $item['id']);
                    $stmt->bindValue(':patient_id', $item['id_paciente']);
                    if($item['id_medico'] == 8){
                        $item['id_medico'] = 2;
                    } else {
                        $item['id_medico'] = 1;
                    }
                    $stmt->bindValue(':user_id', $item['id_medico']);
        
                    if($item['tratamiento_id'] == 0){
                        $item['tratamiento_id'] = null;
                    }
                    $stmt->bindValue(':treatment_id', $item['tratamiento_id']);

                    if($item['id_loc'] == 0){
                        $item['id_loc'] = null;
                    }
                    $stmt->bindValue(':place_id', $item['id_loc']);
                    $stmt->bindValue(':made_at', $item['startO']);
                    
                    $stmt->execute();
                }
            }

            if($action == 'documento_paciente'){

                $sql = "
                    SELECT * FROM documento_paciente 
                ";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $items = $stmt->fetchAll();

                foreach($items as $key => $item) {
                    //var_dump($item);die;
                    $this->importDocImgHelper($item, 'doc');
                }
            }

            if($action == 'documento_imagen') {

                $sql = "SELECT * FROM documento_imagen";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $items = $stmt->fetchAll();

                foreach ($items as $key => $item) {
                    //var_dump($item);die;
                    $this->importDocImgHelper($item, 'img');
                }
            }
        }

        return $this->render('import/index.html.twig', [
            'id' => $center->getId(),
            'table' => $action,
            'items' => $items,
        ]);
    }
}
