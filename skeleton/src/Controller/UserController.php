<?php
namespace App\Controller;
use App\Entity\User;
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
class UserController extends FOSRestController
{
    /**
     * Lists all users.
     * @Rest\Get("/users")
     *
     * @return Response
     */
    public function getUserAction()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findall();

        return $this->handleView($this->view($users));
    }
    /**
     * Create User.
     * @Rest\Post("/user/create")
     *
     * @return Response
     */
    public function postUserAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            if($repository->findOneBy(["email" => $data["email"]]) == null) {
                $em = $this->getDoctrine()->getManager();
                $user->setToken(urlencode(sha1($user->getEmail() . "" . $user->getPassword())));
                $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
                $em->persist($user);
                $em->flush();
                return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
            }else{
                return $this->handleView($this->view(['status' => 'not_fount'], Response::HTTP_NOT_FOUND));
            }
        }
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * @Rest\Delete("/user/delete/{token}")
     *
     * @return Response
     */
    public function deleteUserAction( Request $request){
        $token = $request ->attributes ->get("token");
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBy(['token' => $token]);

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->handleView($this->view('ok'));
    }

    /**
     * @Rest\Put("/user/update")
     *
     * @return Response
     */
    public function updateUserAction(Request $request){
        $data = json_decode($request->getContent(), true);
        $token = $data["token"]; //$request ->attributes ->get("token");
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBy(['token' => $token]);

        $form = $this->createForm(UserType::class, $user);

        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
            $em->persist($user);
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors()));


    }

    /**
     * @Rest\Post("/user/authenticate")
     *
     * @return Response
     */
    public function authUserAction(Request $request){
        $data = json_decode($request->getContent(), true);
        $email = $data["email"];

        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBy(['email' => $email]);
        if($user != null){
            if(password_verify($data["password"], $user->getPassword())){
                return $this->handleView($this->view($user));
            }else{
                return $this->handleView($this->view(['status' => 'not_allowed'], Response::HTTP_UNAUTHORIZED));
            }
        }else{
            return $this->handleView($this->view(['status' => 'not_found'], Response::HTTP_NOT_FOUND));
        }
    }
}