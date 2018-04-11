<?php
namespace App\Controller;
use App\Entity\Evento;
use App\Entity\Teacher;
use App\Entity\Topic;
use App\Entity\Type;
use App\Entity\Place;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class CalendarController extends Controller
{
    public function index(Request $request)
    {

      $teacherall = $this->getDoctrine()
        ->getRepository(Teacher::class)
        ->findAll();
      $topicall = $this->getDoctrine()
        ->getRepository(Topic::class)
        ->findAll();
      $typeall = $this->getDoctrine()
          ->getRepository(Type::class)
          ->findAll();
      $placeall = $this->getDoctrine()
          ->getRepository(Place::class)
          ->findAll();
      foreach ($teacherall as $singleteacher) {
        $id = $singleteacher->getId();
        $teacherselect[''] = "";
        $teacherselect[$singleteacher->getName()] = $id;
      }
      foreach ($topicall as $singletopic) {
        $id = $singletopic->getId();
        $topicselect[''] = "";
        $topicselect[$singletopic->getName()] = $id;
      }
      foreach ($typeall as $singletype) {
        $id = $singletype->getId();
        $typeselect[''] = "";
        $typeselect[$singletype->getCoursetype()] = $id;
      }
      foreach ($placeall as $singleplace) {
        $id = $singleplace->getId();
        $placeselect[''] = "";
        $placeselect[$singleplace->getCIty()] = $id;
/*        $placeselect[$singleplace->getName()] = $id; */
      }
      $date = date('Y,m,d');
      $form = $this->createFormBuilder()
        ->add('argomento', ChoiceType::class, array('choices' => $topicselect, 'required'   => false,))
        ->add('tipo', ChoiceType::class, array('choices' => $typeselect, 'required'   => false,))
        ->add('citta', ChoiceType::class, array('choices' => $placeselect, 'required'   => false, 'label' => "Città",))
/*        ->add('citta', ChoiceType::class, array('choices' => $placeselect, array('required'   => false, 'label' => "Città"))) */

        ->add('maestro', ChoiceType::class, array('choices' => $teacherselect, 'required'   => false,))
        ->add('cerca', SubmitType::class)
        ->getForm();
      $form->handleRequest($request);
      if ($form->isSubmitted()) {
        $ricevuto = $form->getData();
        print_r($ricevuto);
        $event = $this->getDoctrine()
          ->getRepository(Evento::class)
          ->findByDateAndSearch($date, "topic", "");
      }
      else {
        $event = $this->getDoctrine()
          ->getRepository(Evento::class)
          ->findByDate($date);
/*          ->findAll(); */
      }
      foreach ($event as $singleevent) {

/***  teacher  ***/
        $idteacher = $singleevent->getTeacher();
        $teacher = $this->getDoctrine()
          ->getRepository(Teacher::class)
          ->find($idteacher);
        $singleevent->setTeacher($teacher->getName());
/***  place  ***/
        $idplace = $singleevent->getPlace();
        $place = $this->getDoctrine()
          ->getRepository(Place::class)
          ->find($idplace);
        $place1 = $place->getAddress() . " - " . $place->getCity() . " (" . $place->getCountry() . ")";
        $singleevent->setPlace($place1);
        $singleevent->setPlacename($place->getName());
/***  topic  ****/
        $idtopic = $singleevent->getTopic();
/*        $idcoursetype = $singleevent->getCourse(); */
        $topic = $this->getDoctrine()
          ->getRepository(Topic::class)
          ->find($idtopic);
        $singleevent->setTopic($topic->getName());
        $singleevent->setGallery($topic->getGallery());
/***  coursetype  ****/
        $idcoursetype = $singleevent->getCoursetype();
        $coursetype = $this->getDoctrine()
          ->getRepository(Type::class)
          ->find($idcoursetype);
        $singleevent->setCoursetype($coursetype->getCoursetype());
      }
      if (!$event) {
        return new Response(
            '<html><body>Nessun evento trovato</body></html>'
        );
      }
      else {
        return $this->render('calendarioeventi.html.twig', array('event' => $event, 'form' => $form->createView()));
      }
    }
}
