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
    $form->add('usertype', TextType::class, array('required'   => true));
    $form->add('save', SubmitType::class, array('label'=> 'Invia'));
    $form = $form->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() &&  $form->isValid()) {
      $usertype = $form->getData();
      $em = $this->getDoctrine()->getManager();
      $em->persist($usertype);
      $em->flush();
      return $this->redirectToRoute('viewusertype');
    }
    return $this->render('usertype.html.twig', array('form' => $form->createView()));
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
    return $this->redirectToRoute('viewusertype');
  }




  public function viewusertype(Request $request)
  {
    $showusertype = $this->getDoctrine()->getRepository(Usertype::class)->findAll();
    return $this->render('viewusertype.html.twig', array('viewusertype' => $showusertype ));
  }

  public function index(Request $request)
  {
    $event = new Evento();
    $event->setTitle('Titolo ');
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
    $formadd = $this->createFormBuilder($event);
    $formadd->add("title", TextType::class, array('required'   => true));
    $formadd->add("start", DateTimeType::class, array('required'   => true));
    $formadd->add("end", DateTimeType::class, array('required'   => true));
    $formadd->add("teacher", ChoiceType::class, array('required'   => true, 'choices'  => $teacherselect));
    $formadd->add("place", ChoiceType::class, array('required'   => true, 'choices'  => $placeselect));
    $formadd->add("course", ChoiceType::class, array('required'   => true, 'choices'  => $typeselect));
    $formadd->add("topic", ChoiceType::class, array('required'   => true, 'choices'  => $topicselect));
    $formadd->add('save', SubmitType::class, array('label' => 'Invia'));
    $formadd = $formadd->getForm();
    $formadd->handleRequest($request);
    if ($formadd->isSubmitted() && $formadd->isValid()) {
        $event = $formadd->getData();
        $date = date('Y-m-d H:i:s');
        $event->setDate(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();
        return $this->redirectToRoute('admin');
    }
    $eventall = $this->getDoctrine()
      ->getRepository(Evento::class)
      ->findAll();
    foreach ($eventall as $singleevent) {
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
    return $this->render('admin.html.twig', array('form' => $formadd->createView(), 'event' => $eventall));
  }
  private function generateUniqueFileName()
  {
    return md5(uniqid());
  }
  public function alltype()
  {
    $typeall = $this->getDoctrine()
      ->getRepository(Type::class)
      ->findAll();
    return $this->render('alltype.html.twig', array('type' => $typeall));
  }
  public function allteacher()
  {
    $teacherall = $this->getDoctrine()
      ->getRepository(Teacher::class)
      ->findAll();
    return $this->render('allteacher.html.twig', array('teacher' => $teacherall));
  }
  public function alluser()
  {
    $userall = $this->getDoctrine()
      ->getRepository(User::class)
      ->findAll();
    return $this->render('alluser.html.twig', array('user' => $userall));
  }
  public function alltopic()
  {
    $topicall = $this->getDoctrine()
      ->getRepository(Topic::class)
      ->findAll();
    return $this->render('alltopic.html.twig', array('topic' => $topicall));
  }
  public function allplace()
  {
    $placeall = $this->getDoctrine()
      ->getRepository(Place::class)
      ->findAll();
    return $this->render('allplace.html.twig', array('place' => $placeall));
  }
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
  public function topic(Request $request)
  {
    $topic = new Topic();
    $topic->setActive('Attivo ');
    $topic->setName('Nome ');
    $form = $this->createFormBuilder($topic);
    $form->add("active", CheckboxType::class, array('data' => true, 'required'   => false));
    $form->add("name", TextType::class, array('required'   => true));
    $form->add("gallery", TextType::class, array('required'   => true, 'data' => $topic->getGallery()));
    $form->add('save', SubmitType::class, array('label' => 'Invia'));
    $form = $form->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $topic = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($topic);
        $em->flush();
        return $this->redirectToRoute('admin');
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
    $form->add("active", CheckboxType::class, array('data' => true, 'required'   => false));
    $form->add("name", TextType::class, array('required'   => true));
    $form->add("address", TextType::class, array('required'   => true));
    $form->add("city", TextType::class, array('required'   => true));
    $form->add("country", TextType::class, array('required'   => true));
    $form->add('save', SubmitType::class, array('label' => 'Invia'));
    $form = $form->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $place = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($place);
        $em->flush();
        return $this->redirectToRoute('admin');
    }
    return $this->render('place.html.twig', array('form' => $form->createView()));
  }
  public function teacher(Request $request)
  {
    $teacher = new Teacher();
    $teacher->setActive('Attivo ');
    $teacher->setName('Nome ');
    $form = $this->createFormBuilder($teacher);
    $form->add("active", CheckboxType::class, array('data' => true, 'required'   => false, 'label' => 'Attivo '));
    $form->add("name", TextType::class, array('required'   => true, 'label' => "Nome "));
    $form->add('save', SubmitType::class, array('label' => 'Invia'));
    $form = $form->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $teacher = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($teacher);
        $em->flush();
        return $this->redirectToRoute('admin');
    }
    return $this->render('teacher.html.twig', array('form' => $form->createView()));
  }
  public function type(Request $request)
  {
    $type = new Type();
    $type->setActive('Attivo ');
    $type->setCoursetype('Nome ');
    $form = $this->createFormBuilder($type);
    $form->add("active", CheckboxType::class, array('data' => true, 'required'   => false));
    $form->add("coursetype", TextType::class, array('required'   => true));
    $form->add('save', SubmitType::class, array('label' => 'Invia'));
    $form = $form->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $teacher = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($teacher);
        $em->flush();
        return $this->redirectToRoute('admin');
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
    $form->add("is_active", CheckboxType::class, array('data' => true, 'required'   => false));
    $form->add("username", TextType::class, array('required'   => true));
    $form->add("password", TextType::class, array('required'   => true));
    $form->add("email", TextType::class, array('required'   => true));
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
  public function topicedit(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $topic = $em->getRepository(Topic::class)->findAll();
    foreach ($topic as $topicsingle) {
        $form = $this->createFormBuilder();
        $form->add("attivo", CheckboxType::class, array('data' => $topicsingle->getActive(), 'required'   => false, 'label' => $topicsingle->getName()));
        $form->add("name", TextType::class, array('data' => $topicsingle->getName(), 'required'   => false, 'label' => 'Nome '));
        $form->add("image", TextType::class, array('required'   => true, 'data' => $topicsingle->getGallery()));
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
        $topicedit->setActive($form['attivo']);
        $topicedit->setName($form['name']);
        $eventedit->setImage($form['image']);
        $em->flush();
        return $this->redirectToRoute('admin');
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
    return $this->redirectToRoute('admin');
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
    return $this->redirectToRoute('admin');
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
    return $this->redirectToRoute('admin');
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
    return $this->redirectToRoute('admin');
  }
  public function removetype($id)
  {
    $em = $this->getDoctrine()->getManager();
    $type = $em->getRepository(Topic::class)->find($id);
    if (!$type) {
        throw $this->createNotFoundException(
            'No article found for id '.$id
        );
    }
    else {
      $em->remove($type);
      $em->flush();
    }
    return $this->redirectToRoute('admin');
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
    return $this->redirectToRoute('admin');
  }
  public function changepassword($keyurl, Request $request, \Swift_Mailer $mailer)
  {
      $em = $this->getDoctrine()->getManager();
      $user = $em->getRepository(User::class)->findOneBy(array('recoverpasswordlink' => $keyurl));
      if (!$user) {
          throw $this->createNotFoundException(
              'No user found '
          );
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
