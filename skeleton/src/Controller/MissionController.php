<?php
namespace App\Controller;
use App\Entity\Mission;
use App\Entity\User;
use App\Form\MissionType;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * User controller.
 * @Route("/api", name="api_")
 */
class MissionController extends FOSRestController
{
    /**
     * Lists all users.
     * @Rest\Get("/mission/all")
     *
     * @return Response
     */
    public function getAllMissions()
    {
        $repository = $this->getDoctrine()->getRepository(Mission::class);
        $users = $repository->findall();

        return $this->handleView($this->view($users));
    }
    /**
     * Create User.
     * @Rest\Post("/mission/create")
     *
     * @return Response
     */
    public function postMission(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $mission = new Mission();
        $form = $this->createForm(MissionType::class, $mission);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {

            if($repository->findOneBy(["nom", $request ->attributes ->get("nom")]) == null) {
                $em = $this->getDoctrine()->getManager();
                $mission->setToken(urlencode(sha1($mission->getNom() . "" . $mission->getDateCreation())));
                $em->persist($mission);
                $em->flush();
                return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
            }else{
                return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_FORBIDDEN));
            }
        }
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * @Rest\Delete("/mission/delete/{token}")
     *
     * @return Response
     */
    public function deleteMission( Request $request){
        $token = $request ->attributes ->get("token");
        $repository = $this->getDoctrine()->getRepository(Mission::class);
        $user = $repository->findOneBy(['token' => $token]);

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->handleView($this->view('ok'));
    }

    /**
     * @Rest\Put("/mission/update")
     *
     * @return Response
     */
    public function updateMission(Request $request){

        $data = json_decode($request->getContent(), true);
        $token = $data["token"]; //$request ->attributes ->get("token");
        $repository = $this->getDoctrine()->getRepository(Mission::class);
        $mission = $repository->findOneBy(['token' => $token]);

        $form = $this->createForm(UserType::class, $mission);

        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mission);
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors()));


    }


}