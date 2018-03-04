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
        $placeselect[$singleplace->getName()] = $id;
      }
      $date = date('Y,m,d');
      $form = $this->createFormBuilder()
        ->add('argomento', ChoiceType::class, array('choices' => $topicselect, 'required'   => false,))
        ->add('centro', ChoiceType::class, array('choices' => $placeselect, 'required'   => false,))
        ->add('tipo', ChoiceType::class, array('choices' => $typeselect, 'required'   => false,))
        ->add('maestro', ChoiceType::class, array('choices' => $teacherselect, 'required'   => false,))
        ->add('invia', SubmitType::class)
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
      }
      foreach ($event as $singleevent) {
        $idteacher = $singleevent->getTeacher();
        $idtopic = $singleevent->getTopic();
        $idcoursetype = $singleevent->getCourse();
        $idplace = $singleevent->getPlace();
        $teacher = $this->getDoctrine()
          ->getRepository(Teacher::class)
          ->find($idteacher);
        $singleevent->setTeacher($teacher->getName());
        $topic = $this->getDoctrine()
          ->getRepository(Topic::class)
          ->find($idtopic);
        $singleevent->setTopic($topic->getName());
        $coursetype = $this->getDoctrine()
          ->getRepository(Type::class)
          ->find($idcoursetype);
        $singleevent->setCourse($coursetype->getCoursetype());
        $place = $this->getDoctrine()
          ->getRepository(Place::class)
          ->find($idplace);
        $place = $place->getAddress() . " - " . $place->getCity() . " (" . $place->getCountry() . ")";
        $singleevent->setPlace($place);
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
