<?php
namespace App\Controller;
use App\Entity\Evento;
use App\Entity\Teacher;
use App\Entity\Topic;
use App\Entity\Type;
use App\Entity\Place;
use App\Entity\User;
use App\Entity\Usertype;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
class AdminController extends Controller
{
  public function usertype(Request $request)
  {
    $usertype = new Usertype();
    $form = $this->createFormBuilder($usertype);
    $form->add('usertype', TextType::class, array('required'   => true, 'label' => 'Tipo di utente '));
    $form->add('save', SubmitType::class, array('label'=> 'Invia'));
    $form = $form->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() &&  $form->isValid()) {
      $usertype = $form->getData();
      $em = $this->getDoctrine()->getManager();
      $em->persist($usertype);
      $em->flush();
      return $this->redirectToRoute('usertypeall');
    }
    return $this->render('usertype.html.twig', array('form' => $form->createView()));
  }

  public function usertypemodify($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $type = $em->getRepository(Usertype::class)->find($id);
    if (!$type)
    {
      throw $this->createNotFoundException('Nessun tipo di utente trovato per questo id '.$id);
    } else {
      $form = $this->createFormBuilder();
      $form->add("usertype", TextType::class, array( 'data' => $type->getUsertype(), 'label' => 'Tipo di utente '));
      $form->add('save', SubmitType::class, array('label' => 'Invia'));
      $form->add("id", HiddenType::class, array( 'data' => $type->getId()));
      $form = $form->getForm();
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $form = $form->getData();
        $usertypeedit = $em->getRepository(Usertype::class)->find($form['id']);
        $usertypeedit->setUsertype($form['usertype']);
        $em->flush();
        return $this->redirectToRoute('usertypeall');
      }
    }
    return $this->render('usertypemodify.html.twig', array('type' => $type, 'form' => $form->createView()));
  }

  public function editusertype(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();
    $query = $this->getDoctrine()->getRepository(Usertype::class)->find($id);
    $form = $this->createFormBuilder();
    $form->add('usertype', TextType::class, array('label' => 'Inserisci i dati' ,'required' => true, 'data' => $query->getUsertype()));
    $form->add('id', HiddenType::class, array('data' => $id));
    $form->add('save', SubmitType::class, array('label'=> 'Modifica'));
    $form = $form->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() &&  $form->isValid())
    {
      $formedit = $form->getData();
      print_r($formedit);

      $editusertype = $em->getRepository(Usertype::class)->find($id);
      $editusertype->setUsertype($formedit['usertype']);
      $em->flush();
      return $this->redirectToRoute('viewusertype');
    }
    return $this->render('usertype.html.twig', array('form' => $form->createView()));
  }

  public function removeusertype(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();
    $query = $this->getDoctrine()->getRepository(Usertype::class)->find($id);
    $em->remove($query);
    $em->flush();
    return $this->redirectToRoute('usertypeall');
  }

  public function viewusertype(Request $request)
  {
    $showusertype = $this->getDoctrine()->getRepository(Usertype::class)->findAll();
    return $this->render('viewusertype.html.twig', array('viewusertype' => $showusertype ));
  }

  public function index(Request $request){
    return $this->render('dashboard.html.twig');
  }

  public function allevent(Request $request)
  {
    $eventall = $this->getDoctrine()
      ->getRepository(Evento::class)
      ->findAll();
    foreach ($eventall as $singleevent) {
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
      $singleevent->setPlacename($place->getName());
/*      $place = $place->getAddress() . " - " . $place->getCity() . " (" . $place->getCountry() . ")"; */
      $place = $place->getCity() . " (" . $place->getCountry() . ")";
      $singleevent->setPlace($place);
/***  topic  ****/
      $idtopic = $singleevent->getTopic();
      $topic = $this->getDoctrine()
        ->getRepository(Topic::class)
        ->find($idtopic);
      $singleevent->setTopic($topic->getName());
/***  coursetype  ****/
      $idcoursetype = $singleevent->getCoursetype();
      $coursetype = $this->getDoctrine()
        ->getRepository(Type::class)
        ->find($idcoursetype);
      $singleevent->setCoursetype($coursetype->getCoursetype());
/***  topic.gallery  ****/
      $singleevent->setGallery($topic->getGallery());
/***  topic.weight  ****/
      $singleevent->setWeight($topic->getWeight());
    }
    return $this->render('allevent.html.twig', array('event' => $eventall));
  }

  public function event(Request $request)
  {
    $event = new Evento();
    $event->setTitle('Titolo ');
    $teacherall = $this->getDoctrine()
      ->getRepository(Teacher::class)
      ->findAll();
    foreach ($teacherall as $singleteacher) {
      $id = $singleteacher->getId();
      $teacherselect[''] = "";
      if($singleteacher->getActive()) {$teacherselect[$singleteacher->getName()] = $id;}
    }
    $topicall = $this->getDoctrine()
      ->getRepository(Topic::class)
      ->findAll();
    foreach ($topicall as $singletopic) {
      $id = $singletopic->getId();
      $topicselect[''] = "";
      if($singletopic->getActive()) {$topicselect[$singletopic->getName()] = $id;}
    }
    $typeall = $this->getDoctrine()
        ->getRepository(Type::class)
        ->findAll();
    foreach ($typeall as $singletype) {
      $id = $singletype->getId();
      $typeselect[''] = "";
      $typeselect[$singletype->getCoursetype()] = $id;
    }
    $placeall = $this->getDoctrine()
        ->getRepository(Place::class)
        ->findAll();
    foreach ($placeall as $singleplace) {
      $id = $singleplace->getId();
      $placeselect[''] = "";
      if($singleplace->getActive()) {
        $placename = $singleplace->getName()." [".$singleplace->getCountry()."]";
        $placeselect[$placename] = $id;
      }
    }
    $today = date('Y-m-d H:i:s');
    $form = $this->createFormBuilder($event);
    $form->add("title", TextType::class, array('required'   => true, 'label' => 'Titolo'));
    $form->add("topic", ChoiceType::class, array('required'   => true, 'choices'  => $topicselect, 'label' => 'Argomento'));
    $form->add("coursetype", ChoiceType::class, array('required'   => true, 'choices'  => $typeselect, 'label' => 'Tipo di corso'));
    $form->add("teacher", ChoiceType::class, array('required'   => true, 'choices'  => $teacherselect, 'label' => 'Maestro'));
    $form->add("place", ChoiceType::class, array('required'   => true, 'choices'  => $placeselect, 'label' => 'Luogo'));
/*  #JANHU
    tentativo di mettere la data attuale per start ed end
    #ENDJANHU */
/*    $form->add("start", DateTimeType::class, array('required'   => true, 'data' => $today, 'label' => 'Dal'));*/
    $form->add("start", DateTimeType::class, array('required'   => true, 'label' => 'Dal'));
/*    $form->add("end", DateTimeType::class, array('required'   => true, 'data' => $today, 'label' => 'Al')); */
    $form->add("end", DateTimeType::class, array('required'   => true, 'label' => 'Al'));
    $form->add("body", TextareaType::class, array('required'   => true, 'label' => 'Testo'));
    $form->add('save', SubmitType::class, array('label' => 'Invia'));
    $form = $form->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $event = $form->getData();
        $date = date('Y-m-d H:i:s');
        $event->setDate(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();
        return $this->redirectToRoute('eventall');
    }
    return $this->render('event.html.twig', array('form' => $form->createView()));
  }


  private function generateUniqueFileName()
  {
    return md5(uniqid());
  }
  public function alltype()
  {
    $eventall = $this->getDoctrine()
      ->getRepository(Evento::class)
      ->findAll();
    $typeall = $this->getDoctrine()
      ->getRepository(Type::class)
      ->findAll();

    foreach ($typeall as $typesingle) {
      $typesingle->setDelete(1);
      $id = $typesingle->getId();
      foreach ($eventall as $singleevent) {
        $idtype = $singleevent->getCoursetype();
        if ($id == $idtype) {
          /* type in uso non lo cancello */
          $typesingle->setDelete(0);
        }
      }
    }

    return $this->render('alltype.html.twig', array('type' => $typeall));
  }

  public function allteacher()
  {
    $eventall = $this->getDoctrine()
      ->getRepository(Evento::class)
      ->findAll();
    $teacherall = $this->getDoctrine()
      ->getRepository(Teacher::class)
      ->findAll();
    foreach ($teacherall as $teachersingle) {
      $teachersingle->setDelete(1);
      $id = $teachersingle->getId();
      foreach ($eventall as $singleevent) {
        $idteacher = $singleevent->getTeacher();
        if ($id == $idteacher) {
          /* teacher in uso non lo cancello */
          $teachersingle->setDelete(0);
        }
      }
    }
    return $this->render('allteacher.html.twig', array('teacher' => $teacherall));
  }

  public function alluser()
  {
    $userall = $this->getDoctrine()
      ->getRepository(User::class)
      ->findAll();
    return $this->render('alluser.html.twig', array('user' => $userall));
  }

  public function allusertype()
  {
    $usertypeall = $this->getDoctrine()
      ->getRepository(Usertype::class)
      ->findAll();
    return $this->render('allusertype.html.twig', array('usertype' => $usertypeall));
  }


  public function alltopic()
  {
    $eventall = $this->getDoctrine()
/*    $eventall = $this->getDoctrine()->findAll(); */
      ->getRepository(Evento::class)
      ->findAll();
    $topicall = $this->getDoctrine()
      ->getRepository(Topic::class)
      ->findAll();
    foreach ($topicall as $topicsingle) {
      $topicsingle->setDelete(1);
      $id = $topicsingle->getId();
      foreach ($eventall as $singleevent) {
        $idtopic = $singleevent->getTopic();
        if ($id == $idtopic) {
          /* topic in uso non lo cancello */
          $topicsingle->setDelete(0);
        }
      }
    }
    return $this->render('alltopic.html.twig', array('topic' => $topicall));
  }
  public function allplace()
  {
    $eventall = $this->getDoctrine()
      ->getRepository(Evento::class)
      ->findAll();
    $placeall = $this->getDoctrine()
      ->getRepository(Place::class)
      ->findAll();
      foreach ($placeall as $placesingle) {
        $placesingle->setDelete(1);
        $id = $placesingle->getId();
        foreach ($eventall as $singleevent) {
          $idplace = $singleevent->getPlace();
          if ($id == $idplace) {
            /* place in uso non lo cancello */
            $placesingle->setDelete(0);
          }
        }
      }
    return $this->render('allplace.html.twig', array('place' => $placeall));
  }

  public function eventmodify(Request $request, $idedit)
  {
/***  teacher  ***/
    $teacherall = $this->getDoctrine()
      ->getRepository(Teacher::class)
      ->findAll();
    foreach ($teacherall as $singleteacher) {
      $id = $singleteacher->getId();
      $teacherselect[''] = "";
      if($singleteacher->getActive()) {$teacherselect[$singleteacher->getName()] = $id;}
    }
/***  place  ***/
    $placeall = $this->getDoctrine()
        ->getRepository(Place::class)
        ->findAll();
    foreach ($placeall as $singleplace) {
      $id = $singleplace->getId();
      $placeselect[''] = "";
      if($singleplace->getActive()) {
        $placename = $singleplace->getName()." [".$singleplace->getCountry()."]";
        $placeselect[$placename] = $id;
      }
    }
/***  topic  ****/
    $topicall = $this->getDoctrine()
      ->getRepository(Topic::class)
      ->findAll();
    foreach ($topicall as $singletopic) {
      $id = $singletopic->getId();
      $topicselect[''] = "";
      if($singletopic->getActive()) {$topicselect[$singletopic->getName()] = $id;}
    }
/***  coursetype  ****/
    $coursetypeall = $this->getDoctrine()
      ->getRepository(Type::class)
      ->findAll();
    foreach ($coursetypeall as $singlecoursetype) {
      $id = $singlecoursetype->getId();
      $coursetypeselect[''] = "";
      $coursetypeselect[$singlecoursetype->getCoursetype()] = $id;
    }


    $em = $this->getDoctrine()->getManager();
    $event = $em->getRepository(Evento::class)->find($idedit);
    $form = $this->createFormBuilder();
    $form->add("title", TextType::class, array('required'   => true, 'label' => 'Titolo', 'data' => $event->getTitle()));
    $id = $event->getTopic();
/*  $form->add("topic", TextType::class, array('required'   => true, 'label' => 'Argomento', 'data' => $selectedtopic->getName())); */
/*  $form->add("topic", ChoiceType::class, array('required'   => true, 'label' => 'Argomento', 'is_selected' => $selectedtopic->getName(), 'choices'  => $topicselect)); */
/*  $form->add("topic", ChoiceType::class, array('required'   => true, 'label' => 'Argomento', 'is_selected' => $event->getTopic(), 'choices'  => $topicselect)); */
/*  $form->add("topic", ChoiceType::class, array('required'   => true, 'label' => 'Argomento', 'choices'  => $topicselect, 'selectedchoice'=> $event->getTopic())); */
    $form->add("topic", ChoiceType::class, array('required'   => true, 'label' => 'Argomento', 'choices'  => $topicselect));
    $form->add("coursetype", ChoiceType::class, array('required'   => true, 'label' => 'Tipo di corso', 'choices'  => $coursetypeselect));
    $form->add("teacher", ChoiceType::class, array('required'   => true, 'label' => 'Maestro', 'choices'  => $teacherselect));
    $form->add("place", ChoiceType::class, array('required'   => true, 'label' => 'Luogo', 'choices'  => $placeselect));
    $form->add("start", DateTimeType::class, array('required'   => true, 'label' => 'Dal'));
    $form->add("end", DateTimeType::class, array('required'   => true, 'label' => 'Al'));
    $form->add("id", HiddenType::class, array('data' => $event->getId()));
    $form->add("body", TextareaType::class, array('required'   => true, 'label' => 'Testo', 'data' => $event->getBody() ));
    $form->add("attivo", CheckboxType::class, array('data' => $event->getActive(), 'required'   => false, 'label' => 'attivo '));
    $form->add('save', SubmitType::class, array('label' => 'Invia'));
    $form = $form->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $event = $form->getData();
      $form = $form->getData();
      $eventedit = $em->getRepository(Evento::class)->find($form['id']);
      $eventedit->setTitle($form['title']);
      $eventedit->setTopic($form['topic']);
      $eventedit->setCoursetype($form['coursetype']);
      $eventedit->setTeacher($form['teacher']);
      $eventedit->setPlace($form['place']);
      $eventedit->setStart($form['start']);
      $eventedit->setEnd($form['end']);
      $eventedit = $em->getRepository(Evento::class)->find($form['id']);
      $eventedit->setBody($form['body']);
      if (empty($form['attivo'])) $form['attivo'] = 0;
      $eventedit->setActive($form['attivo']);
      $em->flush();
      //$event = $em->getRepository(Evento::class)->find($form['id']);
      return $this->redirectToRoute('eventall');
      }
    return $this->render('eventmodify.html.twig', array('form' => $form->createView()));  }

/*
  public function eventedit(Request $request, $idedit)
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
    $em = $this->getDoctrine()->getManager();
    $event = $em->getRepository(Evento::class)->find($idedit);
    $form = $this->createFormBuilder();
    $form->add("id", HiddenType::class, array('data' => $event->getId()));
    $form->add("title", TextType::class, array('required'   => true, 'data' => $event->getTitle()));
    $form->add("start", DateTimeType::class, array('required'   => true));
    $form->add("end", DateTimeType::class, array('required'   => true));
    $form->add("teacher", ChoiceType::class, array('required'   => true, 'choices'  => $teacherselect));
    $form->add("place", ChoiceType::class, array('required'   => true, 'choices'  => $placeselect));
    $form->add("course", ChoiceType::class, array('required'   => true, 'choices'  => $typeselect));
    $form->add("topic", ChoiceType::class, array('required'   => true, 'choices'  => $topicselect));
    $form->add('save', SubmitType::class, array('label' => 'Invia'));
    $form = $form->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $event = $form->getData();
        $form = $form->getData();
        $eventedit = $em->getRepository(Evento::class)->find($form['id']);
        if (empty($form['attivo'])) $form['attivo'] = 0;
        //$eventedit->setActive($form['attivo']);
        $eventedit->setTitle($form['title']);
        $eventedit->setStart($form['start']);
        $eventedit->setEnd($form['end']);
        $eventedit->setTeacher($form['teacher']);
        $eventedit->setPlace($form['place']);
        $eventedit->setTopic($form['topic']);
        $em->flush();
        //$event = $em->getRepository(Evento::class)->find($form['id']);
        return $this->redirectToRoute('admin');
      }
    return $this->render('editevent.html.twig', array('form' => $form->createView()));
  }
  */
  public function topic(Request $request)
  {
    $topic = new Topic();
    $topic->setActive('Attivo ');
    $topic->setName('Nome ');
    $form = $this->createFormBuilder($topic);
    $form->add("name", TextType::class, array('required'   => true, 'label' => 'Nome'));
    $form->add("gallery", TextType::class, array('required'   => true, 'label' => 'Icona', 'data' => 'Carica un`immagine'));
    $form->add("weight", TextType::class, array('required'   => true, 'label' => 'Peso', 'data' => '0'));
    $form->add("active", CheckboxType::class, array('data' => true, 'label' => 'Attivo', 'required'   => false));
    $form->add('save', SubmitType::class, array('label' => 'Invia'));
    $form = $form->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $topic = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($topic);
        $em->flush();
        return $this->redirectToRoute('topicall');
    }
    return $this->render('topic.html.twig', array('form' => $form->createView()));
  }
  public function place(Request $request)
  {
    $place = new Place();
    $place->setActive('Attivo ');
    $place->setName('Nome ');
    $place->setAddress('Indirizzo ');
    $place->setCity('Città ');
    $place->setCountry('Provincia ');
    $form = $this->createFormBuilder($place);
    $form->add("name", TextType::class, array('required'   => true, 'label' => 'Luogo '));
    $form->add("address", TextType::class, array('required'   => true, 'label' => 'Indirizzo '));
    $form->add("city", TextType::class, array('required'   => true, 'label' => 'Città '));
    $form->add("country", TextType::class, array('required'   => true, 'label' => 'Provincia '));
    $form->add("active", CheckboxType::class, array('data' => true, 'required'   => false, 'label' => 'Attivo '));
    $form->add('save', SubmitType::class, array('label' => 'Invia'));
    $form = $form->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $place = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($place);
        $em->flush();
        return $this->redirectToRoute('placeall');
    }
    return $this->render('place.html.twig', array('form' => $form->createView()));
  }

  public function placemodify($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $place = $em->getRepository(Place::class)->find($id);
    if (!$place)
    {
      throw $this->createNotFoundException('Nessun luogo trovato per questo id '.$id);
    } else {
      $form = $this->createFormBuilder();
      $form->add("name", TextType::class, array( 'data' => $place->getName(), 'label' => 'Luogo '));
      $form->add("address", TextType::class, array( 'data' => $place->getAddress(), 'label' => 'Indirizzo '));
      $form->add("city", TextType::class, array( 'data' => $place->getCity(), 'label' => 'Città '));
      $form->add("country", TextType::class, array( 'data' => $place->getCountry(), 'label' => 'Provincia '));
      $form->add("attivo", CheckboxType::class, array('data' => $place->getActive(), 'required'   => false, 'label' => 'attivo '));
      $form->add('save', SubmitType::class, array('label' => 'Invia'));
      $form->add("id", HiddenType::class, array( 'data' => $place->getId()));
      $form = $form->getForm();
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $form = $form->getData();
        $placeedit = $em->getRepository(Place::class)->find($form['id']);
        $placeedit->setName($form['name']);
        $placeedit->setAddress($form['address']);
        $placeedit->setCity($form['city']);
        $placeedit->setCountry($form['country']);
        if (empty($form['attivo'])) $form['attivo'] = 0;
        $placeedit->setActive($form['attivo']);
        $em->flush();
        return $this->redirectToRoute('placeall');
      }
    }
    return $this->render('placemodify.html.twig', array('place' => $place, 'form' => $form->createView()));
  }

  public function teacher(Request $request)
  {
    $teacher = new Teacher();
    $teacher->setActive('Attivo ');
    $teacher->setName('Nome ');
    $form = $this->createFormBuilder($teacher);
    $form->add("name", TextType::class, array('required'   => true, 'label' => "Nome "));
    $form->add("active", CheckboxType::class, array('data' => true, 'required'   => false, 'label' => 'Attivo '));
    $form->add('save', SubmitType::class, array('label' => 'Invia'));
    $form = $form->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $teacher = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($teacher);
        $em->flush();
        return $this->redirectToRoute('teacherall');
    }
    return $this->render('teacher.html.twig', array('form' => $form->createView()));
  }
  public function type(Request $request)
  {
    $type = new Type();
    $type->setActive('Attivo ');
    $type->setCoursetype('Nome ');
    $form = $this->createFormBuilder($type);
    $form->add("coursetype", TextType::class, array('required'   => true, 'label' => 'Tipo di corso '));
    $form->add("active", CheckboxType::class, array('data' => true, 'required'   => false, 'label' => 'Attivo '));
    $form->add('save', SubmitType::class, array('label' => 'Invia'));
    $form = $form->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $teacher = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($teacher);
        $em->flush();
        return $this->redirectToRoute('typeall');
    }
    return $this->render('type.html.twig', array('form' => $form->createView()));
  }
  public function recoverpassword(Request $request)
  {
    $form = $this->createFormBuilder()
        ->add('email', EmailType::class)
        ->add('send', SubmitType::class)
        ->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findAll();
        foreach ($user as $usersingle) {
          $mail = $usersingle->getEmail();
          if (strtolower($mail) == strtolower($data['email'])) {
            $recoverurl = bin2hex(openssl_random_pseudo_bytes(8));
            $usersingle->setRecoverpasswordlink($recoverurl);
            $em->flush();
            $response = $this->forward('App\Controller\MailController::recoverpassword', array(
              'mail' => $mail, 'recoverurl' => $recoverurl
            ));
          }
        }
    }
    return $this->render('recoverpassword.html.twig', array('form' => $form->createView()));
  }
  public function user(Request $request)
  {
    $type = new User();
    $type->setUsername('Nome ');
    $type->setPassword('Password ');
    $form = $this->createFormBuilder($type);
    $form->add("username", TextType::class, array('required'   => true, 'label' => 'Utente '));
    $form->add("email", TextType::class, array('required'   => true, 'label' => 'Email '));
    $form->add("password", TextType::class, array('required'   => true, 'label' => 'Password '));
    $form->add("is_active", CheckboxType::class, array('data' => true, 'required'   => false, 'label' => 'Attivo '));
/*    $form->add("roles", HiddenType::class, array( 'data' => 'ROLES_ADMIN')); */
    $form->add("save", SubmitType::class, array('label' => 'Invia'));
    $form = $form->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $user = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        $name = $user->getUsername();
        $mail = $user->getEmail();
        $response = $this->forward('App\Controller\MailController::welcomeuser', array(
          'name'  => $name, 'mail' => $mail
        ));
      //  return $this->redirectToRoute('admin');
    }
    return $this->render('user.html.twig', array('form' => $form->createView()));
  }

  public function usermodify($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository(User::class)->find($id);
    if (!$user)
    {
      throw $this->createNotFoundException('Nessun Maestro trovato per questo id '.$id);
    } else {
      $form = $this->createFormBuilder();
      $form->add("username", TextType::class, array( 'data' => $user->getUsername(), 'label' => 'Utente '));
      $form->add("email", TextType::class, array( 'data' => $user->getEmail(), 'label' => 'Email '));
      $form->add("password", TextType::class, array('label' => 'Nuova Password '));
      $form->add("isactive", CheckboxType::class, array('data' => $user->getisActive(), 'required'   => false, 'label' => 'attivo '));
      $form->add('save', SubmitType::class, array('label' => 'Invia'));
      $form->add("id", HiddenType::class, array( 'data' => $user->getId()));
      $form = $form->getForm();
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $form = $form->getData();
        $useredit = $em->getRepository(User::class)->find($form['id']);
        if (empty($form['attivo'])) $form['attivo'] = 0;
        $useredit->setActive($form['attivo']);
        $useredit->setName($form['name']);
        $em->flush();
        return $this->redirectToRoute('userall');
      }
    }
    return $this->render('usermodify.html.twig', array('user' => $user, 'forms' => $form->createView()));
  }


  public function useredit(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository(User::class)->findAll();
    foreach ($user as $usersingle) {
        $form = $this->createFormBuilder();
        $form->add("is_active", CheckboxType::class, array('data' => true, 'required'   => false));
        $form->add("username", TextType::class, array('data' => $usersingle->getUsername(), 'required'   => true));
        $form->add("password", TextType::class, array('data' => $usersingle->getPassword(), 'required'   => true));
        $form->add("email", TextType::class, array('data' => $usersingle->getEmail(), 'required'   => true));
        $form->add('save', SubmitType::class, array('label' => 'Invia'));
        $form->add("id", HiddenType::class, array( 'data' => $usersingle->getId()));
        $form = $form->getForm();
        $forms[] = $form->createView();
    }
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $form = $form->getData();
        $useredit = $em->getRepository(User::class)->find($form['id']);
        if (empty($form['is_active'])) $form['is_active'] = 0;
        $useredit->setisActive($form['is_active']);
        $useredit->setUsername($form['username']);
        $useredit->setPassword($form['password']);
        $useredit->setEmail($form['email']);
        $useredit->setRoles();
        $em->flush();
        return $this->redirectToRoute('topicedit');
      }
    return $this->render('useredit.html.twig', array('user' => $user, 'forms' => $forms));
  }

  public function topicmodify($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $topic = $em->getRepository(Topic::class)->find($id);
    if (!$topic)
      {
        throw $this->createNotFoundException('Nessun argomento trovato per questo id '.$id);
      } else {
        $form = $this->createFormBuilder();
        $form->add("name", TextType::class, array('data' => $topic->getName(), 'required'   => false, 'label' => 'Nome '));
        $form->add("weight", TextType::class, array('required'   => true, 'label' => 'Peso ', 'data' => $topic->getWeight() ));
        $form->add("image", TextType::class, array('required'   => true, 'label' => 'Icona ', 'data' => $topic->getGallery()));
        $form->add("attivo", CheckboxType::class, array('data' => $topic->getActive(), 'required'   => false, 'label' => 'attivo '));
        $form->add('save', SubmitType::class, array('label' => 'Invia'));
        $form->add("id", HiddenType::class, array( 'data' => $topic->getId()));
        $form = $form->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
          $form = $form->getData();
          $topicedit = $em->getRepository(Topic::class)->find($form['id']);
          if (empty($form['attivo'])) $form['attivo'] = 0;
          $topicedit->setActive($form['attivo']);
          $topicedit->setWeight($form['weight']);
          $topicedit->setName($form['name']);
          $topicedit->setGallery($form['image']);
          $em->flush();
          return $this->redirectToRoute('topicall');
        }
        return $this->render('topicmodify.html.twig', array('topic' => $topic, 'forms' => $form->createView()));
      }
  }

  public function topicedit(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $topic = $em->getRepository(Topic::class)->findAll();
    foreach ($topic as $topicsingle) {
        $form = $this->createFormBuilder();
        $form->add("name", TextType::class, array('data' => $topicsingle->getName(), 'required'   => false, 'label' => 'Nome '));
        $form->add("image", TextType::class, array('required'   => true, 'data' => $topicsingle->getGallery()));
        $form->add("attivo", CheckboxType::class, array('data' => $topicsingle->getActive(), 'required'   => false, 'label' => $topicsingle->getName()));
        $form->add('save', SubmitType::class, array('label' => 'Invia'));
        $form->add("id", HiddenType::class, array( 'data' => $topicsingle->getId()));
        $form = $form->getForm();
        $forms[] = $form->createView();
    }
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $form = $form->getData();
        $topicedit = $em->getRepository(Topic::class)->find($form['id']);
        if (empty($form['attivo'])) $form['attivo'] = 0;
        $topicedit->setName($form['name']);
        $topicedit->setImage($form['image']);
        $topicedit->setActive($form['attivo']);
        $em->flush();
        return $this->redirectToRoute('topicall');
      }
    return $this->render('topicedit.html.twig', array('topic' => $topic, 'forms' => $forms));
  }
  public function placeedit(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $place = $em->getRepository(Place::class)->findAll();
    foreach ($place as $placesingle) {
        $form = $this->createFormBuilder();
        $form->add("attivo", CheckboxType::class, array('data' => $placesingle->getActive(), 'required'   => false, 'label' => $placesingle->getName()));
        $form->add("name", TextType::class, array('required'   => true, 'data' => $placesingle->getName(), 'label' => 'Nome'));
        $form->add("indirizzo", TextType::class, array('required'   => true, 'data' => $placesingle->getAddress(), 'label' => 'Indirizzo'));
        $form->add("citta", TextType::class, array('required'   => true, 'data' => $placesingle->getCity(), 'label' => 'Città'));
        $form->add("provincia", TextType::class, array('required'   => true, 'data' => $placesingle->getCountry(), 'label' => 'Provincia'));
        $form->add("id", HiddenType::class, array( 'data' => $placesingle->getId()));
        $form->add('save', SubmitType::class, array('label' => 'Invia'));
        $form = $form->getForm();
        $forms[] = $form->createView();
    }
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $form = $form->getData();
        $placeedit = $em->getRepository(Place::class)->find($form['id']);
        if (empty($form['attivo'])) $form['attivo'] = 0;
        $placeedit->setActive($form['attivo']);
        $placeedit->setName($form['name']);
        $placeedit->setAddress($form['indirizzo']);
        $placeedit->setCity($form['citta']);
        $placeedit->setCountry($form['provincia']);
        $em->flush();
        return $this->redirectToRoute('placeedit');
      }
    $i = 0;
    return $this->render('placeedit.html.twig', array('place' => $place, 'forms' => $forms, 'i' => $i));
  }
  public function teacheredit(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $teacher = $em->getRepository(Teacher::class)->findAll();
    foreach ($teacher as $teachersingle) {
        $form = $this->createFormBuilder();
        $form->add("attivo", CheckboxType::class, array('data' => $teachersingle->getActive(), 'required'   => false, 'label' => $teachersingle->getName()));
        $form->add("id", HiddenType::class, array( 'data' => $teachersingle->getId()));
        $form->add("name", TextType::class, array( 'data' => $teachersingle->getName(), 'label' => 'Nome '));
        $form->add('save', SubmitType::class, array('label' => 'Invia'));
        $form = $form->getForm();
        $forms[] = $form->createView();
    }
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $form = $form->getData();
        $teacheredit = $em->getRepository(Teacher::class)->find($form['id']);
        if (empty($form['attivo'])) $form['attivo'] = 0;
        $teacheredit->setActive($form['attivo']);
        $teacheredit->setName($form['name']);
        $em->flush();
        return $this->redirectToRoute('teacheredit');
      }
    return $this->render('teacheredit.html.twig', array('forms' => $forms));
  }

  public function teachermodify($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $teacher = $em->getRepository(Teacher::class)->find($id);
    if (!$teacher)
    {
      throw $this->createNotFoundException('Nessun Maestro trovato per questo id '.$id);
    } else {
      $form = $this->createFormBuilder();
      $form->add("name", TextType::class, array( 'data' => $teacher->getName(), 'label' => 'Nome '));
      $form->add("attivo", CheckboxType::class, array('data' => $teacher->getActive(), 'required'   => false, 'label' => 'attivo '));
      $form->add('save', SubmitType::class, array('label' => 'Invia'));
      $form->add("id", HiddenType::class, array( 'data' => $teacher->getId()));
      $form = $form->getForm();
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $form = $form->getData();
        $teacheredit = $em->getRepository(Teacher::class)->find($form['id']);
        if (empty($form['attivo'])) $form['attivo'] = 0;
        $teacheredit->setActive($form['attivo']);
        $teacheredit->setName($form['name']);
        $em->flush();
        return $this->redirectToRoute('teacherall');
      }
    }
    return $this->render('teachermodify.html.twig', array('teacher' => $teacher, 'forms' => $form->createView()));
  }

  public function typeedit(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $type = $em->getRepository(Type::class)->findAll();
    $form = $this->createFormBuilder();
    foreach ($type as $typesingle) {
        $form = $this->createFormBuilder();
        $form->add("attivo", CheckboxType::class, array('data' => true, 'required'   => false, 'label' => $typesingle->getCoursetype()));
        $form->add("coursetype", TextType::class, array( 'data' => $typesingle->getCoursetype(), 'label' => 'Nome '));
        $form->add("id", HiddenType::class, array( 'data' => $typesingle->getId()));
        $form->add('save', SubmitType::class, array('label' => 'Invia'));
        $form = $form->getForm();
        $forms[] = $form->createView();
    }
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $form = $form->getData();
        $typeedit = $em->getRepository(Type::class)->find($form['id']);
        if (empty($form['attivo'])) $form['attivo'] = 0;
        $typeedit->setActive($form['attivo']);
        $typeedit->setCoursetype($form['coursetype']);
        $em->flush();
        return $this->redirectToRoute('typeedit');
      }
    return $this->render('typeedit.html.twig', array('forms' => $forms));
  }

  public function typemodify($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $type = $em->getRepository(Type::class)->find($id);
    if (!$type)
    {
      throw $this->createNotFoundException('Nessun tipo di corso trovato per questo id '.$id);
    } else {
      $form = $this->createFormBuilder();
      $form->add("coursetype", TextType::class, array( 'data' => $type->getCoursetype(), 'label' => 'Tipo di corso '));
      /*
      $form->add("attivo", CheckboxType::class, array('data' => $type->getActive(), 'required'   => false, 'label' => 'attivo '));
      */
      $form->add('save', SubmitType::class, array('label' => 'Invia'));
      $form->add("id", HiddenType::class, array( 'data' => $type->getId()));
      $form = $form->getForm();
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $form = $form->getData();
        $typeedit = $em->getRepository(Type::class)->find($form['id']);
        /*
        if (empty($form['attivo'])) $form['attivo'] = 0;
        $typeedit->setActive($form['attivo']);
        */
        $typeedit->setCoursetype($form['coursetype']);
        $em->flush();
        return $this->redirectToRoute('typeall');
      }
    }
    return $this->render('typemodify.html.twig', array('type' => $type, 'form' => $form->createView()));
  }

  public function removeevent($id)
  {
    $em = $this->getDoctrine()->getManager();
    $event = $em->getRepository(Evento::class)->find($id);
    if (!$event) {
        throw $this->createNotFoundException(
            'No article found for id '.$id
        );
    }
    else {
      $em->remove($event);
      $em->flush();
    }
    return $this->redirectToRoute('eventall');
  }
  public function removeplace($id)
  {
    $em = $this->getDoctrine()->getManager();
    $place = $em->getRepository(Place::class)->find($id);
    if (!$place) {
        throw $this->createNotFoundException(
            'No article found for id '.$id
        );
    }
    else {
      $em->remove($place);
      $em->flush();
    }
    return $this->redirectToRoute('placeall');
  }
  public function removeteacher($id)
  {
    $em = $this->getDoctrine()->getManager();
    $teacher = $em->getRepository(Teacher::class)->find($id);
    if (!$teacher) {
        throw $this->createNotFoundException(
            'No article found for id '.$id
        );
    }
    else {
      $em->remove($teacher);
      $em->flush();
    }
    return $this->redirectToRoute('teacherall');
  }
  public function removetopic($id)
  {
    $em = $this->getDoctrine()->getManager();
    $topic = $em->getRepository(Topic::class)->find($id);
    if (!$topic) {
        throw $this->createNotFoundException(
            'No article found for id '.$id
        );
    }
    else {
      $em->remove($topic);
      $em->flush();
    }
    return $this->redirectToRoute('topicall');
  }
  public function removetype($id)
  {
    $em = $this->getDoctrine()->getManager();
    $type = $em->getRepository(Type::class)->find($id);
    if (!$type) {
        throw $this->createNotFoundException(
            'No article found for id '.$id
        );
    }
    else {
      $em->remove($type);
      $em->flush();
    }
    return $this->redirectToRoute('typeall');
  }
  public function removeuser($id)
  {
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository(User::class)->find($id);
    if (!$user) {
        throw $this->createNotFoundException(
            'No article found for id '.$id
        );
    }
    else {
      $em->remove($user);
      $em->flush();
    }
    return $this->redirectToRoute('userall');
  }
  public function changepassword($keyurl, Request $request, \Swift_Mailer $mailer)
  {
      $em = $this->getDoctrine()->getManager();
      $user = $em->getRepository(User::class)->findOneBy(array('recoverpasswordlink' => $keyurl));
      if (!$user) {
          throw $this->createNotFoundException('No user found ');
      }
      else {
        $form = $this->createFormBuilder()
            ->add('newpassword', TextType::class)
            ->add('confirmpassword', TextType::class)
            ->add('send', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            if ($data['newpassword'] == $data['confirmpassword']) {
                $user->setPassword($data['newpassword']);
                $em->flush();
            } else echo "Le password non coincidono";
        }
      }
      return $this->render('newpassword.html.twig', array('form' => $form->createView()));
  }
}
